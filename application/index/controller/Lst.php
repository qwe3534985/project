<?php
/**
 * Created by PhpStorm.
 * User: jia
 * Date: 2017/8/21
 * Time: 15:11
 */
namespace app\index\controller;


class Lst extends Base
{
    public function index()
    {
        $id=input('id');
        //查询栏目名称
        $cate=db('cate')->field('catename')->find($id);
        if(isset($id)&&$id){
            //查询所有文章
            $articleData=db('article')->where(['cateid'=>$id])
                ->field('id,title,desc,time,pic,keywords')->paginate(1);
        }
        $keywords=input('keywords');
        if (isset($keywords)&&$keywords){
            $map['keywords']=['like','%'.$keywords.'$'];
            $articleData=db('article')->where($map)->field('id,title,desc,time,pic,keywords')->paginate(1);
            $this->assign('keywords',$keywords);
        }
        $this->assign('cate',$cate);
        $this->assign('articleData',$articleData);
        return $this->fetch('lst');
    }
}