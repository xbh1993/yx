<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Hr extends Controller{
	function college(){
		return $this->fetch();

	}
}