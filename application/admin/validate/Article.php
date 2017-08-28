<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 13:34
 */

namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title' => 'require|max:20|unique:article',
        'cateid' => 'require',
        'author' => 'require',
    ];

    protected $message = [
        'title.require' => '标题不能为空',
        'title.unique' => '标题不能重复',
        'title.max' => '标题最多不能超过20个字符',
        'cateid.require' => '栏目名不能为空',
        'author.require' => '作者名不能为空',
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add' => ['title', 'cateid','author'],
        'edit' => ['title', 'cateid','author'],
    ];
}