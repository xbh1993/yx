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
    public function details(){
        return $this->fetch();
    }
    public function office(){
        return $this->fetch();
    }
    public function international(){
    	//国际合作
    	$list = Db::name('publiclist')->where(['coid'=>5,'status'=>1])->paginate(2,false,[
           'type'     => 'Bootstrap',
           'var_page' => 'page',
           'path'=>'javascript:AjaxPage([PAGE]);',
           //使用函数助手传入参数
           'query' => request()->param(),
        ]);
        //专家顾问
        $list2 = Db::name('publiclist')->where(['coid'=>6,'status'=>1])->paginate(2,false,[
           'type'     => 'Bootstrap',
           'var_page' => 'page',
           'path'=>'javascript:AjaxPage([PAGE]);',
           //使用函数助手传入参数
           'query' => request()->param(),
        ]);
        $this->assign('list2',$list2);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function ajaxListAction(){
      $page = request()->param('apage');
      if (!empty($page)) {
         $rel = Db::name('publiclist')->where(['coid'=>input('post.coid'),'tid'=>input('post.tid')])->paginate(2,false,[
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