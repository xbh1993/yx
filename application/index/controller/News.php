<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/30 0030
 * Time: 下午 4:06
 */

namespace app\index\controller;
use think\Controller;
use think\Db;
class news extends Controller
{
    public function _initialize()
    {
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);
        $this->assign('bannerinfo',$banner);
    }
    public function yxnews()
    {
        return $this->fetch();
    }
    public function yxnews_info()
    {
        //扬翔新闻
        $list1=Db::name('article')->where(['cid'=>20,'status'=>1])->order('create_time desc')->paginate(5);
        $page1=$list1->render();
        $this->assign('list1',$list1);
        $this->assign('page1',$page1);
        return $this->fetch();
    }
    public function media()
    {
        //媒体报道
        $list3=Db::name('article')->where(['cid'=>21,'status'=>1])->order('create_time desc')->paginate(5);
        $page3=$list3->render();
        $this->assign('list3',$list3);
        $this->assign('page3',$page3);
        return $this->fetch();
    }
    public function video()
    {
        //视频
        $list2=Db::name('video')->where(['status'=>1])->order('create_time desc')->paginate(5);
        $page2=$list2->render();
        $this->assign('list2',$list2);
        $this->assign('page2',$page2);
        return $this->fetch();
    }
}