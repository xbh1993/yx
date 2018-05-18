<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/6 0006
 * Time: 下午 4:05
 */

namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Model;
class Manpower extends Controller
{

    public function _initialize(){
        //banner图
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);
        $this->assign('banner',$banner);
    }

  public function manpower(){
      $talent=Db::name('publiclist')->where(['coid'=>1,'status'=>1])->limit(3)->select();
      $this->assign('talent',$talent);       
      //大学简介
      $info1=Db::name('content')->where('id',8)->find();
      $this->assign('info1',$info1);
      //建设标准
      $info2=Db::name('content')->where('id',9)->find();
      $this->assign('info2',$info2);
      $list1=Db::name('publiclist')->where(['coid'=>7,'status'=>1])->order('sys_order asc,create_time desc')->select();
      $this->assign('list1',$list1);
      //支持体系
      $info3=Db::name('content')->where('id',10)->find();
      $this->assign('info3',$info3);
      $list2=Db::name('publiclist')->where(['coid'=>8,'status'=>1])->order('sys_order asc,create_time desc')->select();
      $this->assign('list2',$list2);
      //培训方式
      $info4=Db::name('content')->where('id',11)->find();
      //杨翔大学轮播图
      $yxdxlist=Db::name('banner')->where('type_pid',43)->find();
      $yxdxlist['img_url']=unserialize($yxdxlist['img_url']);
      $this->assign('photo1',$yxdxlist);
      $this->assign('info4',$info4);
      $info5=Db::name('content')->where('id',6)->find();
      //培训特色轮播图
      $list=Db::name('banner')->where('type_pid',42)->find();
      $list['img_url']=unserialize($list['img_url']);
      $this->assign('photo2',$list);
      $info6=Db::name('content')->where('id',7)->find();
      $this->assign('info5',$info5);
      $this->assign('info6',$info6);
      $info7=Db::name('publiclist')->where(['status'=>1,'is_top'=>1,'coid'=>3])->find();
        $this->assign('info7',$info7);
      return $this->fetch();
   }
   //校企合作
    public function school(){
        $list = Db::name('publiclist')->where(['coid'=>2,'tid'=>0])->paginate(2,false,[
           'type'     => 'Bootstrap',
           'var_page' => 'page',
           'path'=>'javascript:AjaxPage([PAGE]);',
           //使用函数助手传入参数
           'query' => request()->param(),
        ]);
        $list2 = Db::name('publiclist')->where(['coid'=>2,'tid'=>1])->paginate(2,false,[
           'type'     => 'Bootstrap',
           'var_page' => 'page',
           'path'=>'javascript:AjaxPage([PAGE]);',
           //使用函数助手传入参数
           'query' => request()->param(),
        ]);
//        $res = $mem->getList();
        $this->assign('list2',$list2);
//        $res = $mem->getList();
        $this->assign('list',$list);
        return $this->fetch();

    }
    public function ajaxListAction(){
      $page = request()->param('apage');
      $tid=input('post.tid');
      $coid=input('post.coid');
      $where="";
      if (isset($tid)) {
          $where=['tid'=>$tid,'coid'=>$coid,'status'=>1];
      }
      else{
        $where=['coid'=>$coid,'status'=>1];
      }
      if (!empty($page)) {
         $rel = Db::name('publiclist')->where($where)->paginate(2,false,[
            'type'     => 'Bootstrap',
            'var_page' => 'page',
            'page' => $page,
            'path'=>'javascript:AjaxPage([PAGE]);',
         ]);
         $page = $rel->render();
      }
      return json(['list'=>$rel,'page'=>$page]);
   }
    //人才理念
    public function talent(){

    $list=Db::name('publiclist')->where(['coid'=>1,'status'=>1])->limit(3)->select();
      $this->assign('list',$list);   
        return $this->fetch();
    }
    //培训特色介绍
    public function train(){
        $info=Db::name('content')->where('id',6)->find();
        if (isset($info)) {
            $photo=json_decode($info["image"],true);
            $this->assign('photo',$photo);
        }
        $info2=Db::name('content')->where('id',7)->find();
        $this->assign('info2',$info2);
        $this->assign('info',$info);
        return $this->fetch();
    }
    //培训信息
    public function train_info(){
        
        return $this->fetch();
    }
    //扬翔大学
    public function university(){
        //大学简介
        $info1=Db::name('content')->where('id',8)->find();
        $this->assign('info1',$info1);
        //建设标准
        $info2=Db::name('content')->where('id',9)->find();
        $this->assign('info2',$info2);
        //支持体系
        $info3=Db::name('content')->where('id',10)->find();
        $this->assign('info3',$info3);
        //培训方式
        $info4=Db::name('content')->where('id',11)->find();
        if (isset($info4)) {
            $photo=json_decode($info4["image"],true);
            $this->assign('photo',$photo);
        }
        $this->assign('info4',$info4);
        return $this->fetch();
    }
}