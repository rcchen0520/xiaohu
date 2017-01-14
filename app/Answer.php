<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //回答api
    public function add()
    {
        //判断用户是否登陆
        if (!user_ins()->is_logged_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }
        //检查参数中是否存在question_id和内容
        if (!rq('question_id') || !rq('content')) {
            return ['status' => 0, 'msg' => 'question_id and content are required'];
        }
        //判断问题是否存在
        $question = question_ins()->find(rq('question_id'));
        if (!$question) {
            return ['status' => 0, 'msg' => 'question not exists'];
        }
        //判断是否重复回答
        $answerd = $this
            ->where(['question_id' => rq('question_id'), 'user_id' => session('user_id')])
            ->count();
        if ($answerd) {
            return ['status' => 0, 'msg' => 'duplicate answers'];
        }
        //保存数据
        $this->content = rq('content');
        $this->user_id = session('user_id');
        $this->question_id = rq('question_id');

        return $this->save() ? ['status' => 1, 'id' => $this->id] : ['status' => 0, 'mag' => 'db insert failed'];
    }

    //更新回答api
    public function change()
    {
        //判断用户是否登陆
        if (!user_ins()->is_logged_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }
        //判断是否有回答id和更新内容
        if (!rq('id') || !rq('content')) {
            return ['status' => 0, 'msg' => 'id and content are required'];
        }
        $answer = $this->find(rq('id'));
//        dd($answer);
        if (!$answer) {
            return ['status' => 0, 'msg' => 'answer not exists'];
        }
//        //判断当前更新回答用户和所要更新回答的用户是否匹配
        if ($answer->user_id != session('user_id')) {
            return ['status' => 0, 'msg' => 'premission denied'];
        }
        $answer->content = rq('content');
        return $answer->save() ? ['status' => 1] : ['status' => 0, 'msg' => 'db update failed'];
    }

    //查看回答api
    public function read()
    {
        if (!rq('id') && !rq('question_id')) {
            return ['status' => 0, 'msg' => 'id or question_id is required'];
        }
        //只查看单个回答
        if (rq('id')) {
            $answer = $this->find(rq('id'));
            if (!$answer) {
                return ['status' => 0, 'msg' => 'answer not exists'];
            } else {
                return ['status' => 1, 'data' => $answer];
            }
        }

        if (!question_ins()->find(rq('question_id'))) {
            return ['status' => 0, 'msg' => 'question not exists'];
        }

        $answers = $this
            ->where('question_id', rq('question_id'))
            ->get()
            ->keyBy('id');

        return ['status' => 1, 'data' => $answers];
    }

    public function vote()
    {
        if(!user_ins()->is_logged_in()){
            return ['status' => 0,'msg' => 'login required'];
        }

        if(!rq('id')||!rq('vote')){
            return ['status' => 0,'msg' => 'id and vote are required'];
        }
        $answer = $this->find(rq('id'));
        if(!$answer){
            return ['status' => 0,'msg' => 'answer not exists'];
        }

        $vote = rq('vote')<=1 ? 1:2;

            $answer ->users()
            ->newPivotStatement()
            ->where('user_id',session('user_id'))
            ->where('answer_id',rq('id'))
            ->delete();

        $answer
            ->users()
            ->attach(session('user_id'),['vote'=>$vote]);

        return ['status' => 1];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //
    public function users()
    {
        return $this
            ->belongsToMany('App\User')
            ->withPivot('vote')
            ->withTimestamps();
    }
}