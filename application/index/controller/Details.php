<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/8 0008
 * Time: 下午 5:44
 */

namespace app\index\controller;

use think\Controller;
class Details extends Controller
{
    public function details(){
        return $this->fetch();
    }
}