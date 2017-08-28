<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/26
 * Time: 14:47
 */

namespace app\admin\controller;

use app\admin\widget\Blog;
use think\Controller;
use think\Validate;

class Article extends Blog
{
    public function index()
    {
//        $data = db('article')->select();
        //两表联查
        $data = db('article')
            ->alias('a')
            ->field('a.id,a.title,a.state,a.author,a.time,a.keywords,a.click,a.pic,c.catename')
            ->join('cate c', 'a.cateid=c.id')
            ->paginate(2);
        //查询sql语句方法
//        echo db()->getLastSql();exit;

        $this->assign('data', $data);
        return $this->fetch('article/list');
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'title' => input('title'),
                'cateid' => input('cateid'),
                'author' => input('author'),
                'desc' => input('desc'),
                'keywords' => input('keywords'),
                'content' => input('content'),
                'state' => input('state'),
                //获取时间
                'time' => time()
            ];
            //判断是否推荐
            if (input('state' == 'on')) {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }
            //图片上传
            if ($_FILES['file']['tmp_name']) {
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('file');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    /**
                     * // 成功上传后 获取上传信息
                     * // 输出 jpg
                     * echo $info->getExtension();
                     * // 输出 事件图片名与后缀
                     * echo $info->getSaveName();
                     * // 输出 图片名与后缀
                     * echo $info->getFilename();
                     */
                    //生成图片路径名
                    $filename = '/uploads/' . $info->getSaveName();
                    $filename = str_replace('\\', '/', $filename);
                    //把图片名称路径放到data数组中
                    $data['pic'] = $filename;
                } else {
                    // 上传失败获取错误信息
                    echo $this->error($file->getError());
                }
            }
            //验证器
            $validate = Validate('Article');
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            //添加数据
            $res = db('article')->insert($data);
            if ($res) {
                return $this->success('添加成功!', url('article/index'));
            } else {
                return $this->error('添加失败！');
            }
        }
        //查询所有栏目
        $cate = db('cate')->select();
        $this->assign('cate', $cate);

        return $this->fetch('article/add');
    }

    public function del()
    {
        $id = input('id');
        //查出原先图片路径
        $imge = db('article')->field('pic')->find($id);
        $img=$imge['pic'];
        if($imge!=""){
        //删除图片
        @unlink('.'.$img);
        }
        $res = db('article')->delete($id);
        if ($res) {
            return $this->success('删除成功！', url('article/index'));
        } else {
            return $this->error('删除失败！');
        }
    }

    public function edit()
    {
        //查询所有栏目
        $cate = db('cate')->select();
        $this->assign('cate', $cate);

        $id = input('id');
        $data = db('article')->find($id);
        $this->assign('data', $data);

        return $this->fetch('article/edit');

    }

    public function doEdit()
    {
        if (request()->isPost()) {
            $data = [
                'id' => input('id'),
                'title' => input('title'),
                'cateid' => input('cateid'),
                'author' => input('author'),
                'desc' => input('desc'),
                'keywords' => input('keywords'),
                'content' => input('content'),
                'state' => input('state'),
                //获取时间
                'time' => time()
            ];
            //判断是否推荐
            if (input('state' == 'on')) {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }
            //图片上传
            if ($_FILES['file']['tmp_name']) {
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('file');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    /**
                     * // 成功上传后 获取上传信息
                     * // 输出 jpg
                     * echo $info->getExtension();
                     * // 输出 事件图片名与后缀
                     * echo $info->getSaveName();
                     * // 输出 图片名与后缀
                     * echo $info->getFilename();
                     */
                    //生成图片路径名
                    $filename = '/uploads/' . $info->getSaveName();
                    $filename = str_replace('\\', '/', $filename);
                    //把图片名称路径放到data数组中
                    $data['pic'] = $filename;
                } else {
                    // 上传失败获取错误信息
                    echo $this->error($file->getError());
                }
            }

            //验证器
            $validate = Validate('Article');
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }

            //查出原先图片路径
            $imge = db('article')->field('pic')->find($data['id']);
            $pic = $imge['pic'];
            //更新数据
            $res = db('article')->update($data);
            if ($res !== false) {
                //有新图片上传
                if (isset($data['pic']) && $data['pic']) {
                    //删除图片
                    @unlink('.'.$pic);
                }
                $this->success('修改成功!', url('index'));
            } else {
                $this->error('删除失败！');
            }
        }
    }
}