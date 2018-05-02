<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/30 0030
 * Time: 下午 4:06
 */

namespace app\index\controller;
use think\Controller;

class news extends Controller
{
    public function yxnews()
    {
        return $this->fetch();
    }
    public function yxnews_info()
    {
        return $this->fetch();
    }
    public function media()
    {
        return $this->fetch();
    }
    public function video()
    {
        return $this->fetch();
    }
}