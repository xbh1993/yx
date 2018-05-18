<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/8 0008
 * Time: 下午 5:44
 */

namespace app\index\controller;

use think\Controller;
use think\Db;
class Details extends Controller
{
    protected $bannerinfo=[];
    public function _initialize(){
        $banner=Db::name('system')->find(4);
        $banner=unserialize($banner['value']);
        $this->bannerinfo=$banner;
    }
    public function details(){
        $table=input('get.table');
        $id=input('get.id');
        $data=input('get.');
        $sign=isset($data['sign'])?$data['sign']:false;
         $index=$this->switchImg($table,$sign);
         $this->assign('bannerinfo',$this->bannerinfo);
         $this->assign('index',$index);
        $info=Db::name($table)->where('id',$id)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function office(){
        return $this->fetch();
    }
    public function switchImg($table,$sign){

        switch ($table){
            case 'product':
                $index=2;//产品中心
            break;
            case 'publiclist':
                if($sign){
                   if($sign=="details")$index=1;//国际合作
                    if($sign=="manpower")$index=6; //人力资源中心
                }else{
                    $index=1;//国际合作
                }
                break;
            case 'article':
                $index=3;//新闻中心
                break;
            case 'fruit':
                $index=4;//创新科研中心
                break;
            default:
                $index=1;
        }

        return $index;

    }
    public function international(){
    	//国际合作
    	$list = Db::name('publiclist')->where(['coid'=>5,'status'=>1])->select();
        //专家顾问
        $list2 = Db::name('publiclist')->where(['coid'=>6,'status'=>1])->paginate(12,false,[
           'type'     => 'Bootstrap',
           'var_page' => 'page',
           'path'=>'javascript:AjaxPage([PAGE]);',
           //使用函数助手传入参数
           'query' => request()->param(),
        ]);
        $this->assign('list2',$list2);
        $this->assign('list',$list);
        $this->assign('bannerinfo',$this->bannerinfo);
        return $this->fetch();
    }
    public function ajaxListAction(){
      $page = request()->param('apage');
      if (!empty($page)) {
         $rel = Db::name('publiclist')->where(['coid'=>input('post.coid'),'tid'=>input('post.tid')])->paginate(6,false,[
            'type'     => 'Bootstrap',
            'var_page' => 'page',
            'page' => $page,
            'path'=>'javascript:AjaxPage([PAGE]);',

         ]);
         $page = $rel->render();
      }
      return json(['list'=>$rel,'page'=>$page]);
   }

}