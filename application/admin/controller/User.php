<?php
namespace app\admin\controller;

use org\Auth;
use think\Controller;
use think\Db;
use think\Session;
use think\Loader;
use think\Url;
use app\admin\model\AdminUser as UserModel;
use app\admin\model\AuthRule  as  AuthRuleModel;
use think\Request;
class User extends Main{ 
    function contact(){
    	$info=Db::name('content')->where('id',4)->find();
    	$this->assign('info',$info);
    	$this->assign('item',['item1'=>'联系我们','item2'=>'修改']);
    	return $this->fetch('detail');
    }
    function network(){
    	$info=Db::name('content')->where('id',5)->find();
    	$this->assign('info',$info);
    	$this->assign('item',['item1'=>'营销网络','item2'=>'修改']);
    	return $this->fetch('detail');
    }
    function service(){
        $info=Db::name('content')->where('id',12)->find();
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'技术服务','item2'=>'修改']);
        return $this->fetch('detail');
    }
    function add_update(){
    	$data=input('post.');
        if ($this->request->isPost()) {
                    unset($data['id']);
                    unset($data['file']);
					if($_POST["id"]!=''){
						 if (Db::name('content')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{							
						$success=Db::name('content')->insert($data);
						if($success){
							$this->success('新增成功');
							//$this->redirect('/admin/login/index');
						}else{
							$this->error('新增失败');
						}								
				} 			
		}		
    }

}