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
class Science extends Main{ 	
	 //科研成果列表
	 function fruit(){
	 	$list=Db::name('fruit')->order('time desc')->select();
	 	$this->assign('list',$list);
	 	return $this->fetch();
	 }
	 //科研成果编辑
	 function editfruit(){
        if(isset($_GET["Id"])){
	    $list=Db::name('fruit')->where('Id',$_GET["Id"])->find();		
	    return  $this->fetch('editfruit',['info'=>$list]);
		}
		else{
		   return  $this->fetch();
		}    
	 }	 
    //更新/添加产品
    
    function addupdate_fruit() {		
        $data=["title"=>$_POST["title"],"content"=>$_POST["content"],"time"=>$_POST["time"],
		"image"=>$_POST["image"],"character"=>$_POST["character"],"status"=>$_POST["status"],"introduction"=>$_POST["introduction"]];		
        if ($this->request->isPost()) {
					if($_POST["id"]!=''){
						 if (Db::name('fruit')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{	
						$success=Db::name('fruit')->insert($data);
						if($success){
							$this->success('新增成功');
							//$this->redirect('/admin/login/index');
						}else{
							$this->error('新增失败');
						}								
				} 			
		}		
        
    }
	/**
	* 删除产品
	*/
    function delete_fruit($id)
	{					
        if (Db::name('fruit')->where('id','in',$id)->delete() !== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}

	//上传图片
	function upload_file()
    {    	
    	$filename = $_FILES['file']['name'];
    	$filetype = $_FILES['file']['type'];
    	$filetmpname=$_FILES['file']['tmp_name'];
    	$filesize = $_FILES['file']['size']/1024/1024;

    	$file = request()->file('file');
    	$info = $file->validate([])->move(ROOT_PATH . 'public' . DS . 'uploads');
    	if ($info) {    		
    		$msg=$info->getSaveName();
    		$result=array( 
		    'status'=>true, 
		    'filename'=>$filename, 
		    'filetype'=>$filetype,
		    '$filesize'=>round($filesize,2).'mb',
            'filesrc'=>'/uploads/'.str_replace('\\','/',$msg)
		   ); 
    	   echo  json_encode($result);
    	};		
    }
     function base(){
	 	return $this->fetch();
	 }
	 function institute(){
	 	return $this->fetch();
	 }
	 function workstation(){
	 	return $this->fetch();
	 }
	 function wsummary(){
	 	$info=DB::name('content')->where('id',1)->find();
	 	$this->assign('info',$info);
	 	$this->assign('bid',1);
	 	$this->assign('item',['item1'=>'工作站','item2'=>'简介']);
	 	return $this->fetch();
	 }
	 function isummary(){
	 	$info=DB::name('content')->where('id',2)->find();
	 	$this->assign('info',$info);
	 	$this->assign('bid',0);
	 	$this->assign('item',['item1'=>'研究院','item2'=>'简介']);
	 	return $this->fetch('wsummary');
	 }

	 //更新/添加简介
    
    function addupdate_summary() {		
        $data=["title"=>$_POST["title"],"content"=>$_POST["content"],"image"=>$_POST["image"]];		
        if ($this->request->isPost()) {
					if($_POST["id"]!=''){
						 if (Db::name('content')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{	
						$success=Db::name('fruit')->insert($data);
						if($success){
							$this->success('新增成功');
						}else{
							$this->error('新增失败');
						}								
				} 			
		}		
        
    }

    //项目列表
    function wproject(){
    	$list=Db::name('project')->where('bid',1)->select();
    	$this->assign('list',$list);
    	$this->assign('bid',1);
    	$this->assign('item',['item1'=>'工作站','item2'=>'研究成果']);
	 	return $this->fetch();
	}
	function iproject(){
    	$list=Db::name('project')->where('bid',0)->select();
    	$this->assign('list',$list);
    	$this->assign('bid',0);
    	$this->assign('item',['item1'=>'研究院','item2'=>'研究成果']);
	 	return $this->fetch('wproject');
	}
	function bfruit(){
    	$list=Db::name('project')->where('bid',2)->select();
    	$this->assign('list',$list);
    	$this->assign('bid',2);
    	$this->assign('item',['item1'=>'实验基地','item2'=>'研究成果']);
	 	return $this->fetch('wproject');
	}
    function editproject(){
    	$bid=input('get.bid');    	
    	$this->assign('bid',$bid);
    	if(isset($_GET["id"])){
            $list=Db::name('project')->where('id',input('get.id'))->find();		
	        return  $this->fetch('editproject',['info'=>$list]);
    	}
    	else{
    	   return $this->fetch();
        }
    }
     function addupdate_project() {		
        $data=input('post.');
        if ($this->request->isPost()) {
                    unset($data['id']);
                    unset($data['file']);
					if($_POST["id"]!=''){
						 if (Db::name('project')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{							
						$success=Db::name('project')->insert($data);
						if($success){
							$this->success('新增成功');
							//$this->redirect('/admin/login/index');
						}else{
							$this->error('新增失败');
						}								
				} 			
		}	
        
    }
    function delete_project($id)
	{					
        if (Db::name('project')->where('id','in',$id)->delete() !== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	//成员
	function wmember(){
		$list=Db::name('member')->where('bid',1)->select();
		$this->assign('list',$list);
		$this->assign('bid',1);
		$this->assign('item',['item1'=>'工作站','item2'=>'成员列表']);
		return $this->fetch();
	}
	function imember(){
		$list=Db::name('member')->where('bid',0)->select();
		$this->assign('list',$list);
		$this->assign('bid',0);
		$this->assign('item',['item1'=>'研究院','item2'=>'成员列表']);
		return $this->fetch('wmember');
	}
	function editmember(){
    	$bid=input('get.bid');    	
    	$this->assign('bid',$bid);
    	if(isset($_GET["id"])){
            $list=Db::name('member')->where('id',input('get.id'))->find();		
	        return  $this->fetch('editmember',['info'=>$list]);
    	}
    	else{
    	   return $this->fetch();
        }
    }
    function addupdate_member() {		
        $data=input('post.');
        if ($this->request->isPost()) {
                    unset($data['id']);
                    unset($data['file']);
					if($_POST["id"]!=''){
						 if (Db::name('member')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{							
						$success=Db::name('member')->insert($data);
						if($success){
							$this->success('新增成功');
							//$this->redirect('/admin/login/index');
						}else{
							$this->error('新增失败');
						}								
				} 			
		}		
        
    }
    function delete_member($id)
	{					
        if (Db::name('member')->where('id','in',$id)->delete() !== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	//基地简介
	function bsummary(){
		$info=Db::name('content')->where('id',3)->find();
		$this->assign('info',$info);
		$this->assign('item',['item1'=>'实验基地','item2'=>'简介']);
		return $this->fetch('wsummary');
	}


}