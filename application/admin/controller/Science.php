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
            "image"=>$_POST["image"],"character"=>$_POST["character"],"status"=>$_POST["status"]];
        if ($this->request->isPost()) {
            if($_POST["Id"]!=''){
                if (Db::name('fruit')->where('Id', $_POST["Id"])->update($data) !== false) {
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
        if (Db::name('fruit')->where('Id','in',$id)->delete() !== false) {
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

}