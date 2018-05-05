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
        if($banner['showType']==1){
            $bannerinfo=$banner['img_url'];
        }else{
            $bannerinfo=$banner['video'];
        }
        $this->assign('bannerinfo',$bannerinfo);
    }
    public function index()
    {

        return $this->fetch();
    }
    public function testsasas(){
        return $this->fetch();
    }
}
