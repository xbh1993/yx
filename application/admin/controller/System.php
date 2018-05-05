<?php
namespace app\admin\controller;

use org\Auth;
use think\Controller;
use think\Db;
use think\Session;
use think\Loader;

class System extends Main{
	//渲染页面
	function index(){
		$list = Db::name('system_log')
			->order('id desc')
			->paginate('15');
		return $this->fetch('index',['list'=>$list]);
	}
	function setting(){
	    if(request())
        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);
        return $this->fetch('setting', ['site_config' => $site_config]);
	}
	/**
     * 更新配置
     */
    public function updateSiteConfig()
    {
        if ($this->request->isPost()) {
            $site_config                = $this->request->post('site_config/a');
            // $site_config['code'] = htmlspecialchars_decode($site_config['code']);
            $data['value']              = serialize($site_config);
            if (Db::name('system')->where('name', 'site_config')->update($data) !== false) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }

    //轮播图 配置

    public  function sowingmap(){
        $info=Db::name('system')->find(2);
        $banner=Db::name('system')->find(4);
        $info=unserialize($info['value']);
        $banner=unserialize($banner['value']);
        $this->assign('info',$info);
        $this->assign('banner',$banner);
        return $this->fetch();
    }


    //上传视频
    function uploadvideo(){
        $file = request()->file('video');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'video');
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


    function updateBanner(){
        if(request()->isPost()){
            $d=request()->post();
            if(empty($d) || !is_array($d) || !isset($d['banner']) || !$d['banner']) return json_code(0,'系统错误');
            $arr=[];
            if(isset($d['video']) && !empty($d['video'])) $arr['video']=$d['video'];
            if(isset($d['img_url'])  && !empty($d['img_url'])) $arr['img_url']=$d['img_url'];
            if (isset($d['showType']) && !empty($d['showType'])) $arr['showType']=$d['showType'];
            $bannerArr=$d['banner'];
            $bannerstr=serialize($bannerArr);
            $str=serialize($arr);
//            var_dump($bannerstr);exit;
            Db::name('system')->update(['id'=>2,'value'=>$str]);
            Db::name('system')->update(['id'=>4,'value'=>$bannerstr]);
            return json_code(1,'操作成功');
        }
    }
}