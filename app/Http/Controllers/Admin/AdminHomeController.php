<?php


namespace App\Http\Controllers\Admin;


use App\Models\Admin;

class AdminHomeController extends  BaseDefaultController
{
    //设置模型
    public function setModel()
    {
        $this->model=new Admin();
    }

}
