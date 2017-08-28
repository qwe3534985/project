<?php
/**
 * Created by PhpStorm.
 * User: jia
 * Date: 2017/8/21
 * Time: 20:17
 */

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }

    public function login()
    {
        $data = [
            'username' => input('username'),
            'password' => input('password'),
            'code' => input('code'),
        ];
        //首先验证验证码
        if ($data['code'] == '' || !$data['code']) {
            return $this->error('验证码不能为空');
        }
        //验证验证码是否正确
        if (!captcha_check($data['code'])) {
            return $this->error('验证码输入错误 请重新输入');
        }
        //验证用户名
        if ($data['username'] == '' || !$data['username']) {
            return $this->error('请输入用户名');
        }
        //验证密码
        if ($data['password'] == '' || !$data['password']) {
            return $this->error('请输入密码');
        }

        //判断用户是否存在
        $arr = db('admin')->where(['username' => $data['username']])->find();

        if (!$arr) {
            return $this->error('用户名错误');
        }
        if ($arr['password'] != md5($data['password'])) {
//            dump($data) ;exit;
            return $this->error('用户或者密码错误');
        }
        //登入成功以后,把用户信息放到session里面
        session('admin', $arr);
        return $this->success('登入成功·正在跳转到首页...', url('Index/index'));
    }
}