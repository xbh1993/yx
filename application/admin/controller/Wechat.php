<?php
namespace app\admin\controller;

use think\Db;

class Wechat extends Main
{
    public function config()
    {
        if (request()->isPost()) {
            $d = request()->post();
            if (empty($d) || !is_array($d)) return json_code(0, '系统错误');
            $value = serialize($d);
            $res = Db::name('system')->where('name', 'wechat')->update(['value' => $value]);
            return json_code(1, '更新成功');
        }
        $info = Db::name('system')->where('name', 'wechat')->find();
        $info = unserialize($info['value']);
        $this->assign('info', $info);
        return $this->fetch();
    }

    //微信菜单管理列表
    public function menu()
    {
        $lists = Db::name('wxmenu')->where('pid', 0)->order('sort desc')->select();
        $this->assign('lists', $lists);
        return $this->fetch();
    }

    public function menuson()
    {
        $pid = input('get.');
        if (!isset($pid['pid'])) {
            $pid = 0;
        } else {
            $pid = $pid['pid'];
        }
        $pidName = Db::name('wxmenu')->field('title,id')->find($pid);
        $lists = Db::name('wxmenu')->where('pid', $pid)->order('sort desc')->select();
        $this->assign('lists', $lists);
        $this->assign('pidName', $pidName);
        return $this->fetch();
    }

    //新增微信菜单
    public function addmenu()
    {
        if (request()->isPost()) {
            $d = request()->post();
            if (empty($d) || !is_array($d)) return json_code(0, '系统错误');
            if ($d['status'] == 1) {
                $arr = ['title' => $d['title'], 'title' => $d['title'], 'menu_event_url' => $d['menu_event_url'], 'sort' => $d['sort'], 'pid' => $d['pid']];
                $arr['menu_event_type'] = $d['status'];
                $arr['add_time'] = time();
                $arr['update_time'] = time();
                $res = Db::name('wxmenu')->insert($arr);
                return json_code(1, '新增成功');
            }
        }
        if (request()->isGet()) {
            $pid = request()->get();
            if (isset($pid['pid'])) {
                $pid = $pid['pid'];
            } else {
                $pid = 0;
            }
            $this->assign('pid', $pid);
            return $this->fetch();
        }

    }


    //微信素材管理
    public function article()
    {
        $list = Db::name('media')
            ->order('add_time desc')
            ->select();
        $this->assign('lists', $list);
        return $this->fetch();
    }


     //发布素材
    public function addarticle()
    {
        if (request()->isPost()) {
            $d = request()->post();
            if (empty($d) || !is_array($d)) return json_code(0, '系统错误');
            //文本消息
            if ($d['types'] == 1) {
                $arr = array('title' => '文本消息', 'type' => 1, 'add_time' => time(), 'update_time' => time());
                $id = Db::name('media')->insertGetId($arr);
                $arrs['content'] = $d['data'];
                $arrs['media_id'] = $id;
                $arrs['title'] = '文本消息';
                Db::name('media_item')->insert($arrs);
                return json_code(1, '操作成功');
            }
            //多图文消息
            if ($d['types'] == 3) {
                $arr = explode('&', $d['data']);
                $header_title = explode(',', $arr[0]);
                $data_article = array('title' => $header_title[0], 'add_time' => time(), 'update_time' => time(), 'type' => 3);
                $media_id = Db::name('media')->insertGetId($data_article);
                foreach ($arr as $k => $v) {
                    $media_arr = [];
                    $data = explode(',', $v);
                    $media_arr = ['media_id' => $media_id, 'title' => $data[0], 'summary' => $data[1], 'content' => $data[2], 'cover' => $data[3]];
                    Db::name('media_item')->insert($media_arr);
                }
                return json_code(1, '操作成功');
            }

            //单图文信息发布
            if ($d['types'] == 2) {
                $data = explode(',', $d['data']);
                $arr = array('title' => $data[0], 'type' => 2, 'add_time' => time(), 'update_time' => time());
                $media_id = Db::name('media')->insertGetId($arr);
                $media_arr = [];

                $media_arr = ['media_id' => $media_id, 'title' => $data[0], 'summary' => $data[1], 'content' => $data[2], 'cover' => $data[3]];
                Db::name('media_item')->insert($media_arr);
                return json_code(1, '操作成功');
            }

        }
        return $this->fetch();
    }

    public function addtest()
    {
        var_dump(123);
        exit;
    }

    public function editarticle()
    {
        $d = request()->get();
        if (empty($d) || !isset($d['id'])) return json_code(0, '系统错误');
        $types = Db::name('media')->field('type')->find($d['id']);
        if ($types['type'] == 1) $templete = 'message';
        if ($types['type'] == 2) $templete = 'iamge';
        if ($types['type'] == 3) $templete = 'images';
        if($types['type']==2 || $types['type']==1){
            $info=Db::name('media_item')->where('media_id',$d['id'])->find();
        }
        if($types['type']==3){
            $info=Db::name('media_item')->where('media_id',$d['id'])->select();
        }
        $this->assign('info',$info);
        return $this->fetch($templete);
    }


    //文本消息修改
     public  function update_article(){
        if(request()->isPost()){
            $d=request()->post();
            if(empty($d)||!isset($d['id'])) return json_code(0,'系统错误');
            $res=Db::name('media_item')->where('media_id',$d['id'])->update(['content'=>$d['message_text']]);
            return json_code(1,'操作成功');
        }

     }

     //单图文修改
    public  function update_article_image(){
         if(request()->isPost()){
             $d=request()->post();
             $data = explode(',', $d['data']);
             Db::name('media')->where('id',$d['id'])->update(['title'=>$data[0]]);
             $media_arr = [ 'title' => $data[0], 'summary' => $data[1], 'content' => $data[2], 'cover' => $data[3]];
             Db::name('media_item')->where('media_id',$d['id'])->update($media_arr);
             return json_code(1, '操作成功');
         }
    }

    //多图文信息修改
    public  function update_article_images(){
        if(request()->isPost()){
            $d=request()->post();
            $arr = explode('&', $d['data']);
            $header_title = explode(',', $arr[0]);
            $data_article = array('title' => $header_title[0], 'update_time' => time());
            $media_id = Db::name('media')->where('id',$d['id'])->update($data_article);
            $res=Db::name('media_item')->where(['media_id'=>$d['id']])->delete();
            foreach ($arr as $k => $v) {
                $media_arr = [];
                $data = explode(',', $v);
                $media_arr = ['media_id' => $d['id'], 'title' => $data[0], 'summary' => $data[1], 'content' => $data[2], 'cover' => $data[3]];
                Db::name('media_item')->insert($media_arr);
            }
            return json_code(1,'操作成功');
        }
    }

    //删除素材信息
    public  function delete_ptype(){
        if(request()->isGet()){
            $d=request()->get();
            $id=$d['id'];
            Db::name('media')->delete($id);
            Db::name('media_item')->where('media_id',$id)->delete();
            return json_code(1,'删除成功');
        }
    }
}