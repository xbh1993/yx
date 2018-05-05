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
        $this->assign('bannerinfo',$banner);
    }

    public function into(){
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