<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
function user_ins() {
    return new \App\User;
}

function question_ins() {
    return new \App\Question();
}

function answer_ins() {
    return new \App\Answer();
}

function comment_ins() {
    return new \App\Comment();
}

function rq($key=null,$default=null){
    if(!$key){
        return Request::all();
    }
    return Request::get($key,$default);
}

function paginate($page=1,$limit=16){
    $limit = $limit ? : 16;
    $skip = ($page? $page-1 : 0) * $limit;
    return [$limit,$skip];
}

function err($msg = null){
    return ['status' => 0,'msg' => $msg];
}

function suc($data_to_add = []){
    $data = ['status' => 1,'data' => []];
    if ($data_to_add){
        $data['data'] =$data_to_add;
    }
    return $data;
}

Route::get('/', function () {
    return view('index');
});

Route::any('api',function(){
   return ['version'=>0.1];
});

Route::any('api/signup',function(){
    return user_ins()->signup();
});

Route::any('api/login',function(){
   return user_ins()->login();
})->middleware('web');

Route::any('api/logout',function(){
   return user_ins()->logout();
})->middleware('web');

Route::any('api/user/change_password',function(){
    return user_ins()->change_password();
})->middleware('web');

Route::any('api/user/reset_password',function(){
    return user_ins()->reset_password();
})->middleware('web');

Route::any('api/user/validate_reset_password',function(){
    return user_ins()->validate_reset_password();
})->middleware('web');

Route::any('api/user/read',function(){
    return user_ins()->read();
})->middleware('web');

Route::any('api/user/exist',function(){
    return user_ins()->exist();
})->middleware('web');

Route::get('api/test',function(){
//     dd(user_ins()->is_logged_in());
    return user_ins()->is_logged_in();
})->middleware('web');

Route::any('api/question/add',function(){
    return question_ins()->add();
})->middleware('web');

Route::any('api/question/change',function(){
    return question_ins()->change();
})->middleware('web');

Route::any('api/question/read',function(){
    return question_ins()->read();
})->middleware('web');

Route::any('api/question/remove',function(){
    return question_ins()->remove();
})->middleware('web');

Route::any('api/answer/add',function(){
    return answer_ins()->add();
})->middleware('web');

Route::any('api/answer/change',function(){
    return answer_ins()->change();
})->middleware('web');

Route::any('api/answer/read',function(){
    return answer_ins()->read();
})->middleware('web');

Route::any('api/answer/vote',function(){
    return answer_ins()->vote();
})->middleware('web');

Route::any('api/comment/add',function(){
    return comment_ins()->add();
})->middleware('web');

Route::any('api/comment/read',function(){
    return comment_ins()->read();
})->middleware('web');

Route::any('api/comment/remove',function(){
    return comment_ins()->remove();
})->middleware('web');

Route::any('api/timeline','CommonController@timeline');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

// 返回前端路由视图
Route::get('tpl/page/home',function(){
    return view('page.home');//注意路由写法
});
Route::get('tpl/page/signup',function(){
    return view('page.signup');
});
Route::get('tpl/page/login',function(){
    return view('page.login');
});
Route::get('tpl/page/question_add',function(){
    return view('page.question_add');
});
Route::get('tpl/page/404',function(){
    return view('page.404');
});