<?php
namespace app\admin\controller;

use org\Auth;
use think\Controller;
use think\Db;
use think\Session;
use think\Loader;

class Banner extends Main{
    public function lists(){
        $list=Db::name('banner')
            ->alias('b')
            ->join('lotus_type t','b.type_pid=t.Id')
            ->field('b.*,t.title')
            ->paginate(8);
        $this->assign('list',$list);
        return $this->fetch();
    }


    public function editbanner(){
        if(request()->isPost()){
            $d=request()->post();
            if(empty($d) || !is_array($d) || !isset($d['id'])) return json_code(0,'参数错误');
            $arr=[];
            $arr['id']=$d['id'];
            $arr['img_url']=serialize($d['img_url']);
            $arr['data']=serialize($d['data']);
            $arr['update_time']=time();
            Db::name('banner')->update($arr);
            return json_code(1,'更新成功');
        }
        $d=request()->get();
        if(!isset($d['id']) || empty($d['id'])) return json_code(0,'参数错误');
        $info=Db::name('banner')->find($d['id']);
        $info['img_url']=unserialize($info['img_url']);
        $info['data']=unserialize($info['data']);
        $this->assign('info',$info);
        return  $this->fetch('edit');
    }



}