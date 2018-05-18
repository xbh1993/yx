<?php
namespace app\index\controller;

use  think\Url;
use  think\Db;
use  think\Controller;
class Index extends Controller
{
    public function _initialize(){
        $banner=Db::name('banner')->where('type_pid',40)->find();
        $banner=unserialize($banner['img_url']);
//        if(isset($banner['img_url'])){
//            $bannerinfo['imgurl']=$banner['img_url'];
//        }
//        if(isset($banner['video'])){
//            $bannerinfo['video']=$banner['video'];
//        }
        $this->assign('bannerinfo',$banner);
    }
    public function index()
    {

          //公司简介
          $info=Db::name('company')->find(1);
          $this->assign('profile',$info);
          //国际合作
          $newslist=Db::name('publiclist')->where(['coid'=>5,'status'=>1,'is_top'=>1])->find();
          $this->assign('newslist',$newslist);
          //产品介绍
          $productlist=Db::name('type')->where('name','product')->select();
          $this->assign('productlist',$productlist);
          //视频
          $video=Db::name('video')->order('create_time desc')->limit(1)->find();
          $this->assign('video',$video);
          //扬翔新闻
          $news1=Db::name('article')->where('cid',20)->order('create_time desc')->limit(1)->find();
          $this->assign('news1',$news1);
          //媒体报道
          $news2=Db::name('article')->where('cid',21)->order('create_time desc')->limit(1)->find();
          $this->assign('news2',$news2);
        return $this->fetch();
    }
    public function testsasas(){
        dump(1213);
        return $this->fetch();
    }

    public function getCompanyList(){
        $type=request()->post();
        $where=[];
        $where['status']=2;
        if(isset($type['type'])){
            $where['type']=$type['type'];
        }
        $lists=Db::name('company')->where($where)->select();
        return json_code(1,'success',$lists);
    }

}
