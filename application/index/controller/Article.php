<?php
/**
 * Created by PhpStorm.
 * User: jia
 * Date: 2017/8/21
 * Time: 15:01
 */
namespace app\index\controller;


class Article extends Base
{
    public function index(){
        $id=input('id');
        //给点击量加1
        db('article')->where(['id'=>$id])->setInc('click',1);
        //查询数据
        $data=db('article')
            ->alias('a')
            ->field('a.id,a.title,a.desc,a.content,a.pic,a.time,a.cateid,a.keywords,a.click,a.author,c.catename')
            ->join('cate c','a.cateid=c.id','left')
            ->find($id)
        ;
        //频道推荐
        $tvCate=db('article')->field('id,title,pic')
            ->where(['cateid'=>$data['cateid']])->limit(8)->order('id desc')->select();
        //相关阅读
        $keywords=explode(',',$data['keywords']);
        $where='';
        foreach ($keywords as $v){
            $where .="keywords like '%{$v}%' or ";
        }
        $where=rtrim($where,' or ');
        $relateRead=db('article')->field('id,title,pic')
            ->where($where)->limit(8)->order('id desc')->select();
        $this->assign('relateRead',$relateRead);
        $this->assign('tvCate',$tvCate);
        $this->assign('data',$data);
        return $this->fetch("article");
    }
}