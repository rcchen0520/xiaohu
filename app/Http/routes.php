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

function rq($key=null,$default=null){
    if(!$key){
        return Request::all();
    }
    return Request::get($key,$default);
}

Route::get('/', function () {
    return view('welcome');
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
