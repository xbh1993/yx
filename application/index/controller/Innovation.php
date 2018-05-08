<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/5 0005
 * Time: 上午 9:43
 */

namespace app\index\controller;
use think\Controller;
use think\Db;
class Innovation extends Controller
{
    public function _initialize()
    {
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);
        $this->assign('bannerinfo',$banner);
    }
    public function innovation(){
        return $this->fetch();
    }
    public function doctor(){
        return $this->fetch();
    }
    public function study(){
        return $this->fetch();
    }
    public function jobs(){
        return $this->fetch();
    }
    public function gains(){
        return $this->fetch();
    }
}