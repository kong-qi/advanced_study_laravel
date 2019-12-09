<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends BaseController
{
    //
    public function index()
    {


        //改变控制内的
        //$this->setModelControllerView('aa');
        //改变整个
        //$this->setModelView('user');
        return $this->display();
    }

    public function console()
    {

        return $this->display();
    }

    public function plugin($ename)
    {
        return $this->display(['side_menu_type' => 'plugin.' . strtolower($ename)]);
    }

    //清除缓存
    public function clearCache()
    {
        Cache::flush();;
        return $this->display();
    }

}
