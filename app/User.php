<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    //
    public function signup()
    {

        /* */
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password){
            return ['status'=>0,'msg'=>'用户名和密码皆不能为空'];
        }else{
            $username = $has_username_and_password[0];
            $password = $has_username_and_password[1];
        }
        $user_exists = $this->where('username',$username)->exists();

        if($user_exists){
            return ['status'=>0,'msg'=>'用户名已存在'];
        }

        /**/
        $hashed_password = Hash::make($password);
//        dd($hashed_password);
        $user = $this;
        $user->password = $hashed_password;
//        dd($user->password);
        $user->username = $username;
        if($user->save()){
            return ['status'=>1,'id'=>$user->id];
        }else{
            return ['status'=>0,'msg' =>'db insert failed'];
        }
    }
    
    /*用户登录*/
    public function login()
    {
        /*获取用户名和密码*/
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password){
            return ['status'=>0,'msg'=>'用户名和密码皆不能为空'];
        }else{
            $username = $has_username_and_password[0];
            $password = $has_username_and_password[1];
        }
        /*判断用户名是否存在*/
        $user = $this->where('username',$username)->first();
        if(!$user){
            return ['status'=>0,'msg'=>'用户名不存在'];
        }

            /*判断密码是否正确*/
            $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password)){
            return ['status'=>0,'msg'=>'密码错误'];
        }

        /*将用户信息写入session*/
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);
//        dd(session()->all());
        return ['status'=>1,'id'=>$user->id];
    }

    public function has_username_and_password()
    {
        $username = rq('username');
        $password = rq('password');
        if($username&&$password){
            return [$username,$password];
        }else{
            return false;
        }
    }


    /*判断是否已经登陆*/
    public function is_logged_in()
    {
//        dd(session()->all());
//        session()->put('user_id',1);
//        dd(session('user_id'));
        /*存在问题，没有登陆应该返回false，现在暂时用0代替*/
        return session('user_id')?:0;
    }

    /*登出*/
    public function logout()
    {
        session()->forget('username');
        session()->forget('user_id');
        return ['status'=>1];
    }
}
