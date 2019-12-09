<?php
// +----------------------------------------------------------------------
// | KongQiAdminBase [ Laravel快速后台开发 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012~2019 http://www.kongqikeji.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kongqi <531833998@qq.com>`
// +----------------------------------------------------------------------
namespace App\TraitClass;
trait BladeTrait
{

    public $bladeView;
    public $bladePrefix='';


    /**
     * 输出视图
     * @param array $data
     * @return mixed
     */
    public function display($data = [])
    {


        $this->commonBlade();


        return view($this->bladePrefix.$this->bladeView, $data);
    }


    /**
     * 改变控制器里面的视图
     * 比如我原本视图自动识别到admin/index/create
     * 如果你要改成其他的，那么就传入改方法，比如我要换成admin/index/add
     * $this->setModelControllerView('add')
     * @param string $view_name
     */
    public function setModelControllerView($view_name = '')
    {
        $route_info = $this->routeInfo;
        $controller=$this->toModelBlade($route_info['controller_base']) . '.' ;

        $view_name ? $this->bladeView =$this->toModelBlade($this->module). '.' .$controller . $view_name : '';
    }

    /**
     * 改变我们的视图模块路径，本来是admin/index/
     * $this->setModelView('home');
     * 改变之后,比如admin/home
     *
     * @param string $view_name
     */
    public function setModelView($view_name = '')
    {

        $view_name ? $this->bladeView = $this->toModelBlade($this->module) . '.' . $view_name : '';
    }

    /**
     * 将路径转换成小写
     * @param $path
     * @return string
     */
    public function toModelBlade($path){
        $arr= explode("\\",$path);

        return strtolower(implode(".",$arr));
    }

    /**
     * 是否视图目录取消控制器目录
     * @return bool
     */
    public function viewNotControllerBlade(){
        return false;
    }

    /**
     * 自动去搜索blade
     */
    public function getBlade()
    {
        $route_info = $this->routeInfo;
        //控制器目录转化成小写
        $controller=$this->toModelBlade($route_info['controller_base']) . '.' ;
        if($this->viewNotControllerBlade())
        {
            $controller='';
        }
        //$this->module 比如模块定义的是Admin,则会变成admin
        //$controller 如果不存在取消控制器目录，那么就会把控制器目录写入,bi
        //admin/index/
        //最后就是我们的控制器的方法，比如create
        //那么最后的视图模版就是/admin/index/create
        $this->bladeView =$this->toModelBlade($this->module) . '.' .$controller . $route_info['action_name'];

    }

    /**
     * 通用设置
     */
    public function commonBlade()
    {

    }
}
