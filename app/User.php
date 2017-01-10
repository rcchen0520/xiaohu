<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    //注册api
    public function signup()
    {

        /* */
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password){
            return err('用户名和密码皆不能为空');
        }else{
            $username = $has_username_and_password[0];
            $password = $has_username_and_password[1];
        }
        $user_exists = $this->where('username',$username)->exists();

        if($user_exists){
            return err('用户名已存在');
        }

        /**/
        $hashed_password = Hash::make($password);
//        dd($hashed_password);
        $user = $this;
        $user->password = $hashed_password;
//        dd($user->password);
        $user->username = $username;
        if($user->save()){
            return suc(['id'=>$user->id]);
        }else{
            return err('db insert failed');
        }
    }

    //获取用户信息api
    public function read()
    {
        if(!rq('id')){
            return err('required id');
        }
        $get = ['id','username','avatar_url','intro'];
        $user = $this->find(rq('id'),$get);
        $data = $user->toArray();
        $answer_count = answer_ins()->where('user_id',rq('id'))->count();
        $question_count = question_ins()->where('user_id',rq('id'))->count();
        $data['answer_count'] = $answer_count;
        $data['question_count'] = $question_count;

        return suc($data);
    }
    
    /*用户登录api*/
    public function login()
    {
        /*获取用户名和密码*/
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password){
            return err('用户名和密码皆不能为空');
        }else{
            $username = $has_username_and_password[0];
            $password = $has_username_and_password[1];
        }
        /*判断用户名是否存在*/
        $user = $this->where('username',$username)->first();
        if(!$user){
            return err('用户名不存在');
        }

            /*判断密码是否正确*/
            $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password)){
            return err('密码错误');
        }

        /*将用户信息写入session*/
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);
//        dd(session()->all());
        return suc(['id'=>$user->id]);
    }

    //判断是否有username和password
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
        return suc();
    }
    
    /*修改密码*/
    public function change_password()
    {
        if(!$this->is_logged_in()){
            return err('login required');
        }
        /*判断是否传进旧密码和新密码*/
        if(!rq('old_password') || !rq('new_password')){
            return err('old_password and new_password are required');
        }
        /*查询当前用户*/
        $user = $this->find(session('user_id'));
        /*判断旧密码是否相符*/
        if(!Hash::check(rq('old_password'),$user->password)){
            return err('invalid old_password');
        }
        /*将新密码写入*/
        $user->password = bcrypt(rq('new_password'));

        return $user->save()?suc():err('db update failed');
    }
    //找回密码，生产短信验证码
    public function reset_password()
    {
        if($this->is_robot()){
            return err('max frequency reached');
        }

        if(!rq('phone')){
            return err('phone is required');
        }

        $user = $this->where('phone',rq('phone'))->first();

        if(!$user){
            return err('invalid phone number');
        }
        /*生成验证码*/
        $captcha = $this->generate_captcha();

        $user->phone_captcha = $captcha;

        $this->update_robot_time();//跟新生成验证码时间

        if($user->save()){
            /*如果验证码保存成功，发送验证码短信息*/
            $this->send_sms();
            return suc();
        }
        return err('db update failed');

    }
    //生成随机4位数验证码
    public function generate_captcha()
    {
        return rand(1000,9999);
    }
    //模拟发送短信
    public function send_sms()
    {
        return true;
    }
    /*判断前后刷新时间*/
    public function is_robot($time=10)
    {
        if(!session('last_active_time')){
            return false;
        }

        $current_time = time();
        $last_active_time = session('last_active_time');

        $elapsed = $current_time - $last_active_time;

        return !($elapsed > $time);
    }
    //
    public function update_robot_time()
    {
        session()->set('last_active_time',time());
    }
    //根据电话，短信验证码重置密码api
    public function validate_reset_password()
    {
        //判断是否是验证机器人，防止强力破解
        if($this->is_robot(2)){
            return err('max frequency reached');
        }

        if(!rq('phone')||!rq('phone_captcha')||!rq('new_password')){
            return err('phone,phone_captcha and new_password are required');
        }
        $user = $this->where([
            'phone' =>  rq('phone'),
            'phone_captcha' =>  rq('phone_captcha'),
        ])->first();

        if(!$user){
            return err('invalid phone or invalid phone_captcha');
        }
        //加密新密码
        $user->password = bcrypt(rq('new_password'));
        //跟新重置密码时间
        $this->update_robot_time();
        return $user->save() ? suc():err('db update failed');
    }

    public function answers()
    {
        return $this
            ->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }
}
