<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示资源的列表
     * @return \Illuminate\Http\Response
     */
    public function info(){

        return view('admin.system.info');
    }

    /**
     * Show the form for creating a new resource.
     * 显示添加再远的表单
     * @return \Illuminate\Http\Response
     */
    public function backup(){

        return view('admin.system.backup');
    }

    /**
     * Store a newly created resource in storage.
     * 保存一个新的资源
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

}
