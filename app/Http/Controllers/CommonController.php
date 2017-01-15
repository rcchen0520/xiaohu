<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommonController extends Controller
{
    //
    public function timeline()
    {
        list($limit,$skip) = paginate(rq('page'),rq('limit'));
        //获取问题数据
        $questions = question_ins()
            ->with('user')
            ->limit($limit)
            ->skip($skip)
            ->orderBy('created_at','desc')
            ->get();
        //获取回复数据
        $answers = answer_ins()
            ->with('user')
            ->with('users')
            ->limit($limit)
            ->skip($skip)
            ->orderBy('created_at','desc')
            ->get();
        //合并数据
        $data = $questions->merge($answers);
        //按照时间排序
        $data = $data->sortByDesc(function($item){
           return $item->created_at;
        });
        $data = $data->values()->all();
        return ['status' => 1,'data' =>$data];
    }

}
