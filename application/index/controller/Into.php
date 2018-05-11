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
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);

        $info=Db::name('company')->where('status',1)->find();
        $this->assign('info',$info);

        $videoArr=Db::name('system')->find(2);
        $videoArr=unserialize($videoArr['value']);
        if(isset($videoArr['video'])){
            $video=$videoArr['video'];
            $this->assign('video',$video);
        }

        $this->assign('bannerinfo',$banner);

    }

    public function into(){
        //杨翔简介
        $info=Db::name('company')->where('status',1)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function summary(){

        return $this->fetch();
    }
    public function course(){
        return $this->fetch();
    }
    public function culture(){
        return $this->fetch();
    }
    public function cause(){
        return $this->fetch();
    }


}