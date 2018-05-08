<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/6 0006
 * Time: 下午 4:05
 */

namespace app\index\controller;
use think\Controller;

class Manpower extends Controller
{
  public function manpower(){
      return $this->fetch();
  }
    public function school(){
        return $this->fetch();
    }
    public function talent(){
        return $this->fetch();
    }
    public function train(){
        return $this->fetch();
    }
    public function train_info(){
        return $this->fetch();
    }
    public function university(){
        return $this->fetch();
    }
}