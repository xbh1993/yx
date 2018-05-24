<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/3 0003
 * Time: 下午 5:26
 */

namespace app\index\controller;
use think\Controller;
use  think\Db;

class Into extends Controller
{
    public function _initialize()
    {
        $type=request()->param();
        if(isset($type['showType'])){
            $this->assign('showType',$type['showType']);
        }else{
            $this->assign('showType','summary');
        }
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);

        //公司
        $info=Db::name('company')->where('status',1)->find();

        $this->assign('info',$info);
        $videoArr=Db::name('system')->find(2);
        $videoArr=unserialize($videoArr['value']);
        if(isset($videoArr['video'])){
            $video=$videoArr['video'];
            $this->assign('video',$video);
        }

        //杨翔风采轮播图
        $list=Db::name('banner')->where('type_pid',41)->find();
        $list['img_url']=unserialize($list['img_url']);
        $this->assign('yxfcList',$list);
        //公益事业
       if(isset($type['page'])){
           $this->assign('p',1);
       }
        $gysyList=Db::name('company')->where('status',3)->paginate(6,false,['query'=>$type]);

        $page=$gysyList->render();

        $this->assign('page',$page);

        $this->assign('gyshlists',$gysyList);

        $this->assign('bannerinfo',$banner);

    }

    //公司简介
    public function into(){
        //杨翔简介
        $info=Db::name('company')->where('status',1)->find();
        $this->assign('info',$info);

        //公司荣誉公司展示轮播图列表
        $where['type_pid']=[33,34];
        $lits1=Db::name('banner')
            ->where('type_pid',33)
            ->find();
        $lits2=Db::name('banner')
            ->where('type_pid',34)
            ->find();
        $lits1['img_url']=unserialize($lits1['img_url']);
        $lits1['data']=unserialize($lits1['data']);
        $lits2['img_url']=unserialize($lits2['img_url']);
        $lits2['data']=unserialize($lits2['data']);
        $this->assign('lits1',$lits1);
        $this->assign('lits2',$lits2);

        //公司文化
        $clist=Db::name('publiclist')->where(['coid'=>9,'status'=>1])->order('sys_order asc')->select();
        $this->assign('clist',$clist);
        return $this->fetch();
    }
    //公司简介
    public function summary(){
        return $this->fetch();
    }
    //发展历程
    public function course(){
        return $this->fetch();
    }
    //公司文化
    public function culture(){
        return $this->fetch();
    }
    //公益事业
    public function cause(){
        return $this->fetch();
    }


}