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
          $info=Db::name('company')->find(1);
          $this->assign('profile',$info);
        return $this->fetch();
    }
    public function testsasas(){
        return $this->fetch();
    }
}
