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
class Manpower extends Controller
{
  public function manpower(){
      
      
      
      return $this->fetch();
   }
   //校企合作
    public function school(){
        
        return $this->fetch();
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
        return $this->fetch();
    }
}