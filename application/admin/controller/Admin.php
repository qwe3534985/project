<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 10:58
 */

namespace app\admin\controller;

use app\admin\widget\Blog;
use think\Controller;
use think\Validate;

class Admin extends Blog
{
    /**
     * @return mixed
     * 查询列表
     */
    public function index()
    {
        $data = db('admin')->paginate(3);
        $this->assign('data', $data);
        return $this->fetch('admin/list');
    }

    /**
     * @return mixed
     * 添加数据
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'username' => input('username'),
                'password' => md5(input('password'))//获取add中input password 内容
            ];

            //验证数组字段
            $validate = validate('Admin');
            if (!$validate->scene('add')->check($data)) {
                return $this->error($validate->getError());
            }
            //添加数据
            $res = db('admin')->insert($data);
            if ($res) {
                return $this->success('添加成功！', url('admin/index'));
            } else {
                return $this->error('添加失败!');
            }
        }
        return $this->fetch('admin/add');
    }

    /**
     *
     * 数据删除
     */
    public function del()
    {
        $id = input('id');
        $res = db('admin')->delete($id);
        if ($res) {
            return $this->success('删除成功!', url('admin/index'));
        } else {
            return $this->error('删除失败！');
        }
    }

    /**
     * @return mixed
     * 编辑
     */
    public function edit()
    {
        $id = input('id');
        $data = db('admin')->where('id', $id)->find();
        $this->assign('data', $data);
        return $this->fetch('edit');
    }

    /**
     * @return mixed|void
     * 编辑修改
     */
    public function doEdit()
    {
        if (request()->isPost()) {
            $data = [
                'id' => input('id'),
                'username' => input('username'),
                'password' => md5(input('password'))
            ];
            $res = db('admin')->update($data);
            if ($res !== false) {
                return $this->success('修改成功!', url('admin/index'));
            } else {
                return $this->error('修改失败！');
            }
        }
//        return $this->fetch();
    }
}