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

    //
    public function read_by_user_id($user_id)
    {
        $user = user_ins()->find($user_id);
        if(!$user){
            return err('user not exist');
        }
        $r = $this
            ->with('question')
            ->where('user_id',$user_id)
            ->get()
            ->keyBy('id');
        return suc($r->toArray());
    }
    
    //查看回答api
    public function read()
    {
        if (!rq('id') && !rq('question_id') && !rq('user_id')) {
            return ['status' => 0, 'msg' => 'id,question_id or user_id is required'];
        }

        if(rq('user_id')){
            $user_id = rq('user_id')==='self'?session('user_id'):rq('user_id');
            return $this->read_by_user_id($user_id);
        }
        //只查看单个回答
        if (rq('id')) {
            $answer = $this
                ->with('user')
                ->with('users')
                ->find(rq('id'));
            if (!$answer) {
                return ['status' => 0, 'msg' => 'answer not exists'];
            } else {
                $answer = $this->count_vote($answer);
                return ['status' => 1, 'data' => $answer];
            }
        }

        //查看回答之前查看问题是否存在
        if (!question_ins()->find(rq('question_id'))) {
            return ['status' => 0, 'msg' => 'question not exists'];
        }

        $answers = $this
            ->where('question_id', rq('question_id'))
            ->get()
            ->keyBy('id');

        return ['status' => 1, 'data' => $answers];
    }

    public function count_vote($answer)
    {
        $upvote_count = 0;
        $downvote_count = 0;
        foreach ($answer->users as $user){
            if($user->pivot->vote==1){
                $upvote_count++;
            }else{
                $downvote_count++;
            }
        }
        $answer->upvote_count = $upvote_count;
        $answer->downvote_count = $downvote_count;
        return $answer;
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

        $vote = rq('vote');
        if($vote!=1&&$vote!=2&&$vote!=3){
            return ['status' => 0,'msg' => 'invalid vote'];
        }

            $answer ->users()
            ->newPivotStatement()
            ->where('user_id',session('user_id'))
            ->where('answer_id',rq('id'))
            ->delete();

        if($vote == 3){
            return ['status' => 1];
        }

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

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}