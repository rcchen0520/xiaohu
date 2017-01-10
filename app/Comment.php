<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //添加评论
    public function add()
    {
        if(!user_ins()->is_logged_in()){
            return ['status' => 0,'msg' => 'login required'];
        }
        //是否有传question_id或answer_id
        if((!rq('question_id') && !rq('answer_id'))||(rq('question_id') && rq('answer_id'))){
            return ['status' => 0,'msg' => 'question_id or answer_id is required'];
        }
        //评论问题
        if(rq('question_id')){
            $question = question_ins()->find(rq('question_id'));
            if(!$question){
                return ['status' => 0,'msg' => 'question not exists'];
            }else{
                $this->question_id = rq('question_id');
            }
        }else{
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer){
                return ['status' => 0,'msg' => 'answer not exists'];
            }else{
                $this->answer_id = rq('answer_id');
            }
        }
        if(rq('reply_to')){
            $target = $this->find(rq('reply_to'));
            if(!$target) {
                return ['status' => 0,'msg' => 'target comment not exists'];
            }
            elseif($target->user_id == session('user_id')) {
                return ['status' => 0,'cannot replay to yourself'];
            }
            else {
                $this->reply_to = rq('reply_to');
            }
        }
        if(!rq('content')){
            return ['status' => 0,'msg' => 'empty content'];
        }
        $this->content = rq('content');
        $this->user_id = session('user_id');
        return $this->save()?['status' => 1,'id' => $this->id]:['status' => 0,'msg' => 'db insert failed'];
    }

    //查看评论api
    public function read()
    {
        if(!rq('question_id') && !rq('answer_id')){
            return ['status' => 0,'msg' => 'question_id or answer_id is required'];
        }
        if(rq('question_id')){
            $question = question_ins()->find(rq('question_id'));
            if(!$question){
              return ['status' => 0,'msg' => 'question not exists'];
            }else{
                $data = $this->where('question_id',rq('question_id'));
            }
        }else{
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer){
                return ['status' => 0,'msg' => 'answer not exists'];
            }else{
                $data = $this->where('answer_id',rq('answer_id'));
            }
        }
        $data = $data->get()->keyBy('id');
        return ['status' => 1,'data' => $data];
    }
    //删除评论api
    public function remove()
    {
        if(!user_ins()->is_logged_in()){
            return ['status' => 0,'msg' => 'login required'];
        }
        if(!rq('id')){
            return ['status' => 0,'msg' => 'id is required'];
        }
        $comment = $this->find(rq('id'));
        if(!$comment) {
            return ['status' => 0, 'msg' => 'comment not exists'];
        }
        if($comment->user_id != session('user_id')){
            return ['status' =>0 , 'msg' => 'premission denied'];
        }
        //先删除所有评论下的回复
        $this->where('reply_to',rq('id'))->delete();
        return $comment->delete()?['status' => 1]:['status' => 0,'db delete failed'];
    }
}
