<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 13:55
 */

namespace app\admin\controller;

use app\admin\widget\Blog;
use think\Controller;
use think\Validate;

class Cate extends Blog
{
    public function index()
    {
        $data = db('cate')->paginate(3);
        $this->assign('data', $data);
        return $this->fetch('cate/cate');
    }

    /**
     * @return mixed
     * 添加数据
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'catename' => input('catename'),
            ];
            //验证器
            $validate = Validate('cate');
            if (!$validate->check($data)) {
                return $this->error($validate->getError());
            }
            //添加数据
            $res = db('cate')->insert($data);
            if ($res) {
                return $this->success('添加成功！', url('cate/index'));
            } else {
                return $this->error('添加失败!');
            }

        }
        return $this->fetch('cate/add');
    }

    /**
     *
     * 数据删除
     */
    public function del()
    {
        $id = input('id');
        $res = db('cate')->delete($id);
        if ($res) {
            return $this->success('删除成功!', url('cate/index'));
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
        $data = db('cate')->where('id', $id)->find();
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
                'catename' => input('catename')
            ];
            $res = db('cate')->update($data);
            if ($res !== false) {
                return $this->success('修改成功!', url('cate/index'));
            } else {
                return $this->error('修改失败！');
            }
        }
//        return $this->fetch();
    }
}