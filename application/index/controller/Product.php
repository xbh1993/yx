<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/29 0029
 * Time: 上午 9:40
 */

namespace app\index\controller;
use think\Controller;
use  think\Db;
class Product extends Controller
{
    public function _initialize()
    {
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);
        $this->assign('bannerinfo',$banner);
    }
    public function pig()
    {        
        $tid=is_null(input('get.tid'))?"1":input('get.tid');
        $list=Db::name('product')->where(['type'=>$tid])->order('time desc')->paginate(3);
        $page=$list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('tid',$tid);
        return $this->fetch();
    }
    public function piginfo()
    {
        return $this->fetch();
    }
    public function feed()
    {
        return $this->fetch();
    }
    public function pigs()
    {
        return $this->fetch();
    }
    public function move()
    {
        return $this->fetch();
    }
    public function equipment()
    {
        return $this->fetch();
    }



}