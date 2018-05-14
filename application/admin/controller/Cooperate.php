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
class Cooperate extends Main{ 
	function news(){
       $list=Db::name('publiclist')->where(['coid'=>5])->order('create_time')->select();
       $this->assign('list',$list);
       $this->assign('coid',5);
       return $this->fetch();
	}
	function editnews(){
	   $this->assign('coid',5);
       if(isset($_GET["id"])){
	    $info=Db::name('publiclist')->where('id',$_GET["id"])->find();		
	    return  $this->fetch('editnews',['info'=>$info]);
		}
		else{
		   return  $this->fetch();
		}    
	}
	function expert(){
		$this->assign('coid',6);
       $list=Db::name('publiclist')->where(['coid'=>6])->order('create_time')->select();
       $this->assign('list',$list);
       return $this->fetch();
	}
	function editexpert(){
		$this->assign('coid',6);
        if(isset($_GET["id"])){
		    $info=Db::name('publiclist')->where('id',$_GET["id"])->find();		
		    return  $this->fetch('editexpert',['info'=>$info]);
		}
		else{
		    return  $this->fetch();
		}
	}
	function add_update(){
		$data=input('post.');
		$tablename=$data["tablename"];
        if ($this->request->isPost()) {
                    unset($data['id']);
                    unset($data['file']);
                    unset($data['tablename']);
					if($_POST["id"]!=''){
						 if (Db::name($tablename)->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{							
						$success=Db::name($tablename)->insert($data);
						if($success){
							$this->success('新增成功');
							//$this->redirect('/admin/login/index');
						}else{
							$this->error('新增失败');
						}								
				} 			
		}
	}
	function delete($id,$tablename){
		if (Db::name($tablename)->where('id','in',$id)->delete()!== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	function upload_file(){
		upload_file();
	}
}