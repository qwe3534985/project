<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 13:34
 */
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate{
    protected $rule =   [
        'username'  => 'require|max:20|unique:admin',
        'password'   => 'require',
    ];

    protected $message  =   [
        'username.require' => '管理员不能为空',
        'username.unique' => '管理员不能重复',
        'username.max'     => '管理员最多不能超过20个字符',
        'password.require' => '密码不能为空',
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add' => ['username', 'password'],
        'edit' => ['username'],
    ];
}