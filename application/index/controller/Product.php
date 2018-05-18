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
        $listli=Db::name('type')->where('name','product')->select();

        $this->assign('list',$listli);

        //产品列表
        
        return $this->fetch();
    }
    public function ajaxListAction(){        
      $page = request()->param('apage');
      $index=input('post.index');
      $tid=input('post.tid');
      $pagesize=input('post.pagesize');
      if (!isset($pagesize)) {
          $pagesize=2;
      }
      if (!empty($page)) {
         $rel = Db::name('product')->where(['type'=>$tid])->paginate($pagesize,false,[
            'type'     => 'Bootstrap',
            'var_page' => 'page',
            'page' => $page,
            'query'=>['tid'=>$tid,'index'=>$index,'size'=>$pagesize],
         ]);
         $page = $rel->render();
      }
      return json(['list'=>$rel,'page'=>$page]);
   }
    public function piginfo()
    {
        // $tid=is_null(input('get.tid'))?"1":input('get.tid');
        // $list=Db::name('product')->where(['type'=>$tid])->order('time desc')->paginate(3);
        // $page=$list->render();
        // $this->assign('list', $list);
        // $this->assign('page', $page);
        // $this->assign('tid',$tid);
        return $this->fetch();
    }
    public function feed()
    {
        // $tid=is_null(input('get.tid'))?"2":input('get.tid');
        // $list=Db::name('product')->where(['type'=>$tid])->order('time desc')->paginate(3);
        // $page=$list->render();
        // $this->assign('list', $list);
        // $this->assign('page', $page);
        // $this->assign('tid',$tid);
        return $this->fetch();
    }
    public function pigs()
    {
        // $tid=is_null(input('get.tid'))?"4":input('get.tid');
        // $list=Db::name('product')->where(['type'=>$tid])->order('time desc')->paginate(3);
        // $page=$list->render();
        // $this->assign('list', $list);
        // $this->assign('page', $page);
        // $this->assign('tid',$tid);
        return $this->fetch();
    }
    public function move()
    {
        // $tid=is_null(input('get.tid'))?"3":input('get.tid');
        // $list=Db::name('product')->where(['type'=>$tid])->order('time desc')->paginate(3);
        // $page=$list->render();
        // $this->assign('list', $list);
        // $this->assign('page', $page);
        // $this->assign('tid',$tid);
        return $this->fetch();
    }
    public function equipment()
    {
        // $tid=is_null(input('get.tid'))?"5":input('get.tid');
        // $list=Db::name('product')->where(['type'=>$tid])->order('time desc')->paginate(3);
        // $page=$list->render();
        // $this->assign('list', $list);
        // $this->assign('page', $page);
        // $this->assign('tid',$tid);
        return $this->fetch();
    }



}