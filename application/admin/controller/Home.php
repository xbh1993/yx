<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25 0025
 * Time: 下午 2:48
 */

namespace app\admin\controller;
use \think\Db;
use \think\Request;
use \app\admin\model\Api as ApiModel;
use \app\admin\model\App as AppModel;
use app\admin\controller\Main;

class Home extends Main
{
    public function sowingmap(){

        if(request()->isPost()){
            $d=request()->post();
            $validate=validate('Home');
            if(!$validate->check($d)){
                $msg=$validate->getError();
                return json_code(0,$msg);
            }
            unset($d['images']);
            $d['img_url']=implode(',',$d['img_url']);
            try{
                Db::name('system')->update($d);
                return json_code(200,'修改成功');
            }catch (\Exception $e){
                return json_code(0,'修改失败');
            }
        }
        $cen=Db::name('system')->find();
        if(!empty($cen['img_url'])){
            $cen['img_url']=explode(',',$cen['img_url']);
        }
        $this->assign('cen',$cen);
        return $this->fetch();
    }
}