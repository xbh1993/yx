<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7 0007
 * Time: 下午 3:02
 */

namespace app\index\controller;

use think\Controller;
class User extends Controller
{
    public function contact(){
        return $this->fetch();
    }
    public function network(){
        return $this->fetch();
    }

}