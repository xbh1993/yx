<?php
namespace app\index\controller;

use  think\Url;
use  think\Db;
use  think\Controller;
class Index extends Controller
{
    public function _initialize(){
        $banner=Db::name('system')->find(2);
        $banner=unserialize($banner['value']);
            $bannerinfo['imgurl']=$banner['img_url'];
            $bannerinfo['video']=$banner['video'];
        $this->assign('bannerinfo',$bannerinfo);
    }
    public function index()
    {
          //公司简介
          $info=Db::name('company')->find(1);
          $this->assign('profile',$info);
          //国际合作
          $newslist=Db::name('article')->where(['cid'=>19,'status'=>1])->limit(4)->select();
          $this->assign('newslist',$newslist);
          //产品介绍
          $productlist=Db::name('product')->limit(4)->select();
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
        return $this->fetch();
    }

    public function test(){
        var_dump(123);
    }
}
