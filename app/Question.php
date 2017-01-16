<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //增加问题api
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

    //更新问题api
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

    public function read_by_user_id($user_id)
    {
        $user = user_ins()->find($user_id);
        if(!$user){
            return err('user not exist');
        }
        $r = $this->where('user_id',$user_id)->get()->keyBy('id');
        return suc($r->toArray());
    }

    //查看问题api
    public function read(){
        //请求参数中是否有id，如果有的话直接返回id所在行
        if(rq('id')){
            $r = $this
                ->with('answers_with_user_info')
                ->find(rq('id'));
            return ['ststus' => 1,'data' => $r];
        }

        if(rq('user_id')){
            $user_id = rq('user_id') == 'self'?session('user_id'):rq('user_id');
            return $this->read_by_user_id($user_id);
        }
        //list条件
        //skip条件，用于分页
        list($limit,$skip) = paginate(rq('page'),rq('limit'));

        $r = $this
            ->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            ->get(['id' , 'title' , 'desc' , 'user_id' , 'created_at' , 'updated_at'])
            ->keyby('id')
        ;

        return ['status'=>1,'data'=>$r];
    }

    //删除问题
    public function remove(){
        //判断用户是否登陆
        if(!user_ins()->is_logged_in()){
            return ['status' => 0,'msg' => 'login required'];
        }
        //判断id是否存在
        if(!rq('id')){
            return ['status' => 0,'msg' => 'id  is required'];
        }

        $question = $this->find(rq('id'));
        if(!$question){
            return ['status' => 0,'msg' => 'question not exist'];
        }

        if(session('user_id') != $question->user_id){
            return ['status' => 0,'msg' => 'premission denied'];
        }

        return $question->delete()?['status' => 1]:['status' => 0,'msg' => 'db delete failed'];

    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function answers_with_user_info()
    {
        return $this
            ->answers()
            ->with('user')
            ->with('users');
    }
}
