<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 10:43
 */

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index/index');
    }
    public function logout(){
        session('admin',null);
        return $this->success('退出成功',url('Login/index'));
//        return $this->redirect(url('Login/index'));
    }

}