<?php
namespace app\index\controller;

use  think\Url;
use  think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function ceshi()
    {
        return $this->fetch();
    }
}
