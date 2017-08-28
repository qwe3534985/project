<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 13:34
 */
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate{
    protected $rule =   [
        'catename'  => 'require|max:20|unique:cate',
    ];

    protected $message  =   [
        'catename.require' => '栏目名不能为空',
        'catename.unique' => '栏目名不能重复',
        'catename.max'     => '栏目名最多不能超过6个字符',
    ];
}