<?php
namespace app\admin\controller;

use org\Auth;
use think\Controller;
use think\Db;
use think\Session;
use think\Loader;

class Company extends Main{
    //公司简介
     function profile(){
         if(request()->isGet()){
             $company_config = Db::name('company')->where('status', '1')->find();

             return $this->fetch('profile', ['site_config' => $company_config]);
         }
         if(request()->isPost()){
             $d=request()->post();
             if(empty($d) && !is_array($d) ) return json_code(0,'操作失败');

             Db::name('company')->where('id',1)->update($d['site_config']);
             return json_code(1,'操作成功');
         }

    }


    //分公司列表
    function lists(){
        $company_lists = Db::name('company')->where('status', '2')->order('sort desc,add_time desc')->paginate(8);
         return $this->fetch('lists',['list'=>$company_lists]);
    }

    //新增分公司
    function add_company(){
        if (request()->isPost()){
            $d=request()->post();
            if(empty($d) && !is_array($d)) return json_code(0,'系统错误');
            if(!isset($d['status'])){
                $d['status']=2;
            }
            $d['add_time']=time();
            $d['update_time']=time();
            Db::name('company')->insert($d);
    return  json_code(1,'添加成功');
        }
        return $this->fetch();
    }

    function editcompany(){
        if(request()->isPost()){
            $d=request()->post();

            if(empty($d) && isset($d['id'])) return json_code(0,'操作失败');
            $res=Db::name('company')->update($d);
            return json_code(1,'操作成功');
        }
        $d=request()->get();
        if(empty($d)  && !isset($d['id'])) return json_code(0,'操作失败');
        $info=Db::name('company')->find($d['id']);
        $this->assign('info',$info);
        return $this->fetch();
    }

    //上传图片
    function uploadfile(){
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $str= $info->getSaveName();
                $str='/uploads'.DS.$str;
                return json_code(1,'success',$str);
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
    //获取经纬度
     function getmap(){
        return $this->fetch();
    }

    //公益事业列表
    function commonweal(){
        $company_lists = Db::name('company')->where('status', '3')->order('sort desc,add_time desc')->paginate(8);
        return $this->fetch('commonweal',['list'=>$company_lists]);
    }

    //新增公益事业
    function  addcommonweal(){
        return $this->fetch();
    }

    //编辑公益事业
    function editcommonweal(){
        if(request()->isPost()){
            $d=request()->post();

            if(empty($d) && isset($d['id'])) return json_code(0,'操作失败');
            $res=Db::name('company')->update($d);
            return json_code(1,'操作成功');
        }
        $d=request()->get();
        if(empty($d)  && !isset($d['id'])) return json_code(0,'操作失败');
        $info=Db::name('company')->find($d['id']);

        $this->assign('info',$info);
        return $this->fetch();
    }


    //公司文化
    function  culture(){
        if(request()->isPost()){
            $d=request()->post();

            if(!empty($d) && is_array($d)){
                Db::name('company')->where('status',4)->update($d);
                return json_code(1,'success');
            }
        }
        $info=Db::name('company')->where('status',4)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }


    //发z展历程
    function  history(){
        $lists=Db::name('company')->where('status',5)->order('sort desc,add_time desc')->select();
        $this->assign('list',$lists);
        return $this->fetch();
    }

    //添加发展历程
    function  addhistory(){
        return $this->fetch();
    }

    //删除操作
    function  delete(){
        if(request()->isGet()){
            $d=request()->get();
            if(empty($d) && !isset($d['id'])) return json_code(0,'删除失败');
            $res=Db::name('company')->delete($d['id']);
            return json_code(1,'删除成功');
        }
    }

    function edithostry(){
        if(request()->isPost()){
            $d=request()->post();
            if(empty($d) && isset($d['id'])) return json_code(0,'操作失败');
            $res=Db::name('company')->update($d);
            return json_code(1,'操作成功');
        }
         $d=request()->get();
         if(empty($d)  && !isset($d['id'])) return json_code(0,'操作失败');
         $info=Db::name('company')->find($d['id']);
         $this->assign('info',$info);
        return $this->fetch();
    }
}