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
        $info=Db::name('content')->where('id',3)->find();
        $this->assign('info',$info);
            

        $sinfo=Db::name('content')->where('id',2)->find();
        $this->assign('sinfo',$sinfo);  

        $jinfo=Db::name('content')->where('id',1)->find();
        $this->assign('jinfo',$jinfo);
        return $this->fetch();
    }
    public function ajaxListAction(){
      $page = request()->param('apage');
      $bid=input('post.bid');
      $table=input('post.table');
      $where="";
      if (isset($bid)) {
          $where=['bid'=>$bid,'status'=>0];
      }
      else{
        $where=['status'=>0];
      }
      if (!empty($page)) {
         $rel = Db::name($table)->where($where)->paginate(6,false,[
            'type'     => 'Bootstrap',
            'var_page' => 'page',
            'page' => $page,
            'path'=>'javascript:AjaxPage([PAGE]);',
         ]);
         $page = $rel->render();
      }
      return json(['list'=>$rel,'page'=>$page]);
   }
    public function doctor(){  
            
        return $this->fetch();
    }
    public function study(){
        $info=Db::name('content')->where('id',2)->find();
        $this->assign('info',$info);
        $list1=Db::name('project')->where(['bid'=>0,'status'=>0])->paginate(6);
        $page1=$list1->render();
        $this->assign('list1',$list1);
        $this->assign('page1',$page1);
        $list2=Db::name('member')->where(['bid'=>0,'status'=>0])->paginate(6);
        $page2=$list2->render();
        $this->assign('list2',$list2);
        $this->assign('page2',$page2);
        return $this->fetch();
    }
    public function jobs(){
        $info=Db::name('content')->where('id',1)->find();
        $this->assign('info',$info);
        $list1=Db::name('project')->where(['bid'=>1,'status'=>0])->paginate(6);
        $page1=$list1->render();
        $this->assign('list1',$list1);
        $this->assign('page1',$page1);
        $list2=Db::name('member')->where(['bid'=>1,'status'=>0])->paginate(6);
        $page2=$list2->render();
        $this->assign('list2',$list2);
        $this->assign('page2',$page2);
        return $this->fetch();
    }
    public function gains(){
        return $this->fetch();
    }
}