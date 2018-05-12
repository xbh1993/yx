<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Hr extends Main{
	//人才理念
	function talent(){
        $list=Db::name('publiclist')->where('coid',1)->order('sys_order asc,create_time desc')->select();
        $this->assign('list',$list);
        $this->assign('coid',1);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'人才理念']);
		return $this->fetch();
	}
	//
	function edittalent(){
		$this->assign('coid',input('get.coid'));
		if(isset($_GET["id"])){
	    $list=Db::name('publiclist')->where('id',$_GET["id"])->find();		
	    return  $this->fetch('edittalent',['info'=>$list]);
		}
		else{
		   return  $this->fetch();
		}    
	}
	//培训信息
	function school(){
        $list=Db::name('publiclist')->where('coid',2)->order('sys_order asc,create_time desc')->select();
        $this->assign('list',$list);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'培训信息']);
		return $this->fetch();
	}
	//
	function editschool(){
		if(isset($_GET["id"])){
	    $list=Db::name('publiclist')->where('id',$_GET["id"])->find();		
	    return  $this->fetch('editschool',['info'=>$list]);
		}
		else{
		   return  $this->fetch();
		}    
	}
	//培训信息
	function info(){
		$list=Db::name('publiclist')->where('coid',3)->order('sys_order asc,create_time desc')->select();
        $this->assign('list',$list);
        $this->assign('coid',3);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'培训信息']);
		return $this->fetch('talent');
	}
	//
    function train(){
    	$this->redirect('introduce');
    }
    //培训特色介绍
    function introduce(){
        $info=Db::name('content')->where('id',6)->find();
        if (isset($info)) {
    		$photo=json_decode($info["image"],true);
    		$this->assign('photo',$photo);
		}
        $this->assign('id',6);
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'培训特色介绍']);
    	return $this->fetch('train');
    }
    //培训对象
    function object(){
        $info=Db::name('content')->where('id',7)->find();
        if (isset($info)) {
    		$photo=json_decode($info["image"],true);
    		$this->assign('photo',$photo);
		}
        $this->assign('id',7);
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'培训对象']);
    	return $this->fetch('train');
    }
    function college(){
    	$this->redirect('introduction');
    }
    //大学简介
    function introduction(){
        $info=Db::name('content')->where('id',8)->find();
        if (isset($info)) {
    		$photo=json_decode($info["image"],true);
    		$this->assign('photo',$photo);
		}
        $this->assign('id',8);
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'大学简介']);
    	return $this->fetch('train');
    }
    //建设标准
    function standard(){
        $info=Db::name('content')->where('id',9)->find();
        if (isset($info)) {
    		$photo=json_decode($info["image"],true);
    		$this->assign('photo',$photo);
		}
        $this->assign('id',9);
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'建设标准']);
    	return $this->fetch('train');
    }
    //支持体系
    function system(){
        $info=Db::name('content')->where('id',10)->find();
        if (isset($info)) {
    		$photo=json_decode($info["image"],true);
    		$this->assign('photo',$photo);
		}
        $this->assign('id',10);
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'支持体系']);
    	return $this->fetch('train');
    }
    //培训方式
    function way(){
        $info=Db::name('content')->where('id',11)->find();
        if (isset($info)) {
    		$photo=json_decode($info["image"],true);
    		$this->assign('photo',$photo);
		}
        $this->assign('id',11);
        $this->assign('info',$info);
        $this->assign('item',['item1'=>'扬翔大学','item2'=>'培训方式']);
    	return $this->fetch('train');
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