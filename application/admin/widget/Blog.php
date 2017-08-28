<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 11:12
 */
namespace app\admin\widget;
use think\Controller;

class Blog extends Controller
{
    public function head(){
        return $this->fetch('commonality/head');
    }
    public function left(){
        return $this->fetch('commonality/left');
    }
    /***
     * 初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->islogin();
    }

    /**
     * 判断是否登入
     */
    public function islogin()
    {
        $admin = session('admin');
        if (!isset($admin) || !$admin['id']) {
            return $this->error('请先登入...', url('Login/index'));
        }
    }
}