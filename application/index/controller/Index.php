<?php
namespace app\index\controller;


class Index extends Base
{
    public function index()
    {
        //查询所有文章
        $articleData=db('article')->field('id,title,desc,time,pic,keywords')->paginate(1);
        $this->assign('articleData',$articleData);
        //加载模版
        return $this->fetch();
    }
}
