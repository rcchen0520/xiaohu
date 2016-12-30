<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public function add()
    {
        if(!user_ins()->is_logged_in()){
//            return user_ins()->is_logged_in();
            return ['status'=>0,'msg'=>'login required'];
        }

        if(!rq('title')){
            return ['status'=>0,'msg'=>'required title'];
        }

        $this->title = rq('title');
        $this->user_id = session('user_id');
        if(rq('desc')){
            $this->desc = rq('desc');
        }
        return $this->save()?['status'=>1,'id'=>$this->id]:['status'=>0,'msg'=>'db insert failed'];
    }

    public function change()
    {
        /*判断用户是否登陆*/
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login required'];
        }
        /*检查传参中是否有id*/
        if(!rq('id')){
            return ['status'=>0,'msg'=>'id required'];
        }
        /*获取指定id的model*/
        $question = $this->find(rq('id'));
        /*判断问题是否存在*/
        if(!$question){
            return ['status'=>0,'msg'=>'question not exists'];
        }
        /*判断用户id是否匹配，决定该用户是否有权限更新问题*/
        if($question->user_id!=session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }
        if(rq('title')){
            $question->title = rq('title');
        }
        if(rq('desc')){
            $question->desc = rq('desc');
        }
//        $this->user_id = session('user_id');
        return $question->save()?['status'=>1]:['status'=>0,'msg'=>'db update failed'];

    }
}
