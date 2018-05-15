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
class Product extends Main{ 
	//产品列表
	public function index(){
	 	 $list= Db::name('product')->order('time desc')->select();
        for ($i=0; $i < count($list); $i++) { 
            $this->get_productstype($list[$i]["type"])!=''?$list[$i]["TypeName"]=$this->get_productstype($list[$i]["type"]):$list[$i]["TypeName"]='';
        }
        $this->assign('list',$list);
		//标题传值
		$this->assign('item',['item1'=>'产品','item2'=>'产品列表']);
		return  $this->fetch();
	} 
    public function editlist(){

     	$type=Db::name('type')->where('name','product')->order('id desc')->select();

		$this->assign('type',$type);

        if(isset($_GET["id"])){
	    $list=Db::name('product')->where('id',$_GET["id"])->find();		
	    return  $this->fetch('editlist',['info'=>$list]);
		}
		else{
		   return  $this->fetch();
		}    
    }
     /**
     * 更新/添加产品
     */
    public function addupdate_product() {		
        $data=["type"=>$_POST["type"],"title"=>$_POST["title"],"time"=>$_POST["time"],
		"content"=>$_POST["content"],"describe"=>$_POST["describe"],"time"=>$_POST["time"]];		
        if ($this->request->isPost()) {

					if($_POST["id"]!=''){

						 if (Db::name('product')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{	

						$success=Db::name('product')->insert($data);
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
    function delete_product()
	{
		if ($this->request->isPost()) {			
	        if (Db::name('product')->where('id','in',$_POST["id"])->delete() !== false) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
        }
        else{
        	$this->error('非法操作');
        }
	}
	/*
	* 获取产品类别
	 */
	public function get_productstype($id)
	{
		$user =Db::name('type')->where(['id'=>$id,'name'=>'product'])->select();
		if (count($user)>0) {
            return $user[0]["title"];
        } else {
            return '';
        }
	}
    //产品类别
     public function type(){
     	$list  = Db::name('type')->where('name','product')->order('id desc')->select();
        $this->assign('list',$list);
		//标题传值
		$this->assign('item',['item1'=>'产品类别','item2'=>'产品类别']);
		return  $this->fetch();            
     }   
     public function edittype(){
        if(isset($_GET["id"])){
	    $list=Db::name('type')->where('id',$_GET["id"])->find();		
	    return  $this->fetch('edittype',['info'=>$list]);
		}
		else{
		   return  $this->fetch();
		}    
    } 
     /**
     * 更新/添加产品类别
     */
    public function addupdate_producttype() {
        $data=["title"=>$_POST["title"],"name"=>'product','introduction'=>$_POST["introduction"],'thumb'=>$_POST["thumb"]];
        //$data=SafeFilter($data);        
        if ($this->request->isPost()) {
					if($_POST["id"]!=''){
						 if (Db::name('type')->where('id', $_POST["id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{	
						
						$success=Db::name('type')->insert($data);
						if($success){
							$this->success('新增成功');
						}else{
							$this->error('新增失败');
						}
									
				} 			
		}		
        
    }
	/**
	* 删除新闻         
	*/
    function delete_ptype($id)
	{					
        if (Db::name('type')->where('id',$id)->delete()!== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
    //评论列表
    function comment(){
    	$list=Db::name('comment')->order('time desc')->select();
    	$this->assign('list',$list);
    	$this->assign('item',['item1'=>'评论','item2'=>'评论列表']);
    	return $this->fetch();
    }
    //评论编辑
    public function editcomment(){     	
        if(isset($_GET["Id"])){
	    $list=Db::name('comment')->where('Id',$_GET["Id"])->find();		
	    return  $this->fetch('editcomment',['info'=>$list]);
		}
		else{
		   return  $this->fetch();
		}    
    }
    //评论增改
    function addupdate_comment(){
		$data=["address"=>$_POST["address"],"content"=>$_POST["content"],"status"=>$_POST["status"],
		"time"=>$_POST["time"]];		
        if ($this->request->isPost()) {

					if($_POST["Id"]!=''){

						 if (Db::name('comment')->where('Id', $_POST["Id"])->update($data) !== false) {
								$this->success('修改成功');
							} else {
								$this->error('修改失败');
							}
					}else{	

						$success=Db::name('comment')->insert($data);
						if($success){
							$this->success('新增成功');
							//$this->redirect('/admin/login/index');
						}else{
							$this->error('新增失败');
						}
									
				} 			
		}		
    }
    //评论删除
    function delete_comment($Id)
	{					
        if (Db::name('comment')->where('Id','in',$Id)->delete() !== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	function upload_file(){
		upload_file();
	}
}