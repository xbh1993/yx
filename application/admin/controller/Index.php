<?php
namespace app\admin\controller;

use think\Db;
use app\admin\model\AdminUser as UserModel;

class Index extends Main{

	//主界面
	public function index(){
        //锁屏跳转
        if(!empty(session('lock'))){
            $this->redirect('admin/index/lockscreen');
        }
		return $this->fetch();
	}

    //锁屏
    function lockscreen(){
        session('lock',time());
        return $this->fetch('lockscreen');
    }

    //解锁
    function  unlock($password){
        $sql_passwd = UserModel::get(session('uid'))->password;
        if(md5($password)==$sql_passwd){
            session('lock',null);
            $this->success('验证成功','admin/index/index',1000);

        }else{
            $this->error('别逗我，密码不对');
        }

    }

}
