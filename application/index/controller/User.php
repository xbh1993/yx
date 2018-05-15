<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7 0007
 * Time: 下午 3:02
 */
namespace app\index\controller;
use think\Controller;
use think\Db;
class User extends Controller
{
    public function _initialize(){
        //banner图
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);
        $this->assign('bannerinfo',$banner);
    }
    public function contact(){
    	$info=Db::name('content')->where('id',4)->find();
    	$this->assign('info',$info);
        return $this->fetch();
    }
    public function network(){
    	$info=Db::name('content')->where('id',5)->find();
    	$this->assign('info',$info);
        return $this->fetch();
    }

}