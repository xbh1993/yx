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
class News extends Main{
    //新闻列表
    function newslist(){
        $list=Db::name('article')->order('create_time desc')->select();
        for ($i=0; $i < count($list); $i++) {
            $this->get_type($list[$i]["cid"])!=''?$list[$i]["TypeName"]=$this->get_type($list[$i]["cid"]):$list[$i]["TypeName"]='';
        }
        //获取新闻类别
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function get_type($id)
    {
        $user =Db::name('type')->where('id',$id)->find();
        if (count($user)>0) {
            return $user["title"];
        } else {
            return '';
        }
    }
    function type(){
        $list=Db::name('type')->where('name','news')->order('Id desc')->select();
        $this->assign('list',$list);
        $this->assign('tid',1);
        $this->assign('item',['item1'=>'新闻','item2'=>'新闻类别']);
        return $this->fetch();
    }
    function editlist(){
        $type=Db::name('type')->where('name','news')->order('id desc')->select();
        $this->assign('type',$type);
        if(isset($_GET["id"])){
            $list=Db::name('article')->where('id',$_GET["id"])->find();
            if (isset($list)) {
                $photo=explode(',', $list["photo"]);
                $this->assign('photo',$photo);
            }
            return  $this->fetch('editlist',['info'=>$list]);
        }
        else{
            return  $this->fetch();
        }
    }
    function edittype(){
        $this->assign('tid',input('get.tid'));
        if(isset($_GET["Id"])){
            $list=Db::name('type')->where(['Id'=>$_GET["Id"],'name'=>'news'])->find();
            return  $this->fetch('edittype',['info'=>$list]);
        }
        else{
            return  $this->fetch();
        }
    }
    /**
     * 更新/添加新闻
     */
    public function addupdate_news() {
        if ($this->request->isPost()) {

            $data=["title"=>input('post.title'),"introduction"=>input('post.introduction'),"content"=>input('post.content')
                ,"author"=>input('post.author'),"status"=>input('post.status'),"thumb"=>input('post.thumb')
                ,"photo"=>input('post.photo'),"photodescribe"=>input('post.photodescribe'),"create_time"=>input('post.create_time'),"cid"=>input('post.cid'),"sid"=>input('post.sid')];
            if(input('post.id')!=''){

                if (Db::name('article')->where('id', input('post.id'))->update($data) !== false) {
                    $this->success('修改成功');
                } else {
                    $this->error('修改失败');
                }
            }else{
                $success=Db::name('article')->insert($data);
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
    function delete_news($id)
    {
        if (Db::name('article')->where('id','in',$id)->delete()!== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 更新/添加类别
     */
    public function addupdate_newstype() {
        $name=input('get.tid')==1?"news":"video";
        $data=["title"=>$_POST["title"],"name"=>$name];
        //$data=SafeFilter($data);
        if ($this->request->isPost()) {
            if($_POST["Id"]!=''){
                if (Db::name('type')->where('Id', $_POST["Id"])->update($data) !== false) {
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
     * 删除类别
     */
    function delete_ptype($id)
    {
        if (Db::name('type')->where('id',$id)->delete()!== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    //视频列表
    public function videolist(){
        $list  = Db::name('video')->order('create_time desc')->select();
        for ($i=0; $i < count($list); $i++) {
            $this->get_type($list[$i]["type"])!=''?$list[$i]["TypeName"]=$this->get_type($list[$i]["type"]):$list[$i]["TypeName"]='';
        }
        //标题传值
        $this->assign('item',['item1'=>'视频','item2'=>'视频列表']);
        return  $this->fetch('video',['list'=>$list]);
    }
    function editvideo(){

        $type=Db::name('type')->where('name','video')->order('id desc')->select();

        $this->assign('type',$type);

        if(isset($_GET["Id"])){
            $list=Db::name('video')->where('Id',$_GET["Id"])->find();
            return  $this->fetch('editvideo',['info'=>$list]);
        }
        else{
            return  $this->fetch();
        }
    }
    function videotype(){
        $list=Db::name('type')->where('name','video')->order('id desc')->select();
        //标题传值
        $this->assign('item',['item1'=>'视频','item2'=>'视频类别']);
        $this->assign('tid',2);
        return  $this->fetch('type',['list'=>$list]);
    }
    /**
     * 更新/添加视频
     */
    public function addupdate_video() {

        $data=["type"=>input('post.type'),"title"=>input('post.title'),"create_time"=>date("Y-m-d H:i:s",time()),
            "access"=>input('post.access'),"image"=>input('post.image'),"url"=>input('post.url'),"describe"=>input('post.describe')];
        //$data=SafeFilter($data);

        if ($this->request->isPost()) {
            if($_POST["Id"]!=''){

                if (Db::name('video')->where('Id', $_POST["Id"])->update($data) !== false) {
                    $this->success('修改成功');
                } else {
                    $this->error('修改失败');
                }
            }else{

                $success=Db::name('video')->insert($data);
                if($success){
                    $this->success('新增成功');
                }else{
                    $this->error('新增失败');
                }

            }
        }

    }
    /**
     * 删除视频
     */
    function delete_video($Id)
    {

        if (Db::name('video')->where('Id','in',$Id)->delete() !== false) {
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
}