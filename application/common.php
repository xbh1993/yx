<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// 应用公共文件
function isMobile()
{
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    if (isset($_SERVER['HTTP_VIA'])) {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}
/**
 * 子元素计数器
 * @param array $array
 * @param int   $pid
 * @return array
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }
    return $counter;
}
/**
 * 数组层级缩进转换
 * @param array $array 源数组
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1)
{
    static $list = [];
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            array2level($array, $v['id'], $level + 1);
        }
    }
    return $list;
}
/**
 * 构建层级（树状）数组
 * @param array  $array          要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children')
{
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }
    return $tree;
}
/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name])) {
                $item[$child_key_name] = [];
            }

            $item[$child_key_name][] = $child;
        }
    }
    return $parent;
}
/**
 * 手机号格式检查
 * @param string $mobile
 * @return bool
 */
function check_mobile_number($mobile)
{
    if (!is_numeric($mobile)) {
        return false;
    }
    $reg = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#';

    return preg_match($reg, $mobile) ? true : false;
}

function check_env(){
    $items = array(
        'os'      => array('操作系统', '不限制', '类Unix', PHP_OS, 'check'),
        'php'     => array('PHP版本', '5.5', '5.5+', PHP_VERSION, 'check'),
        'upload'  => array('附件上传', '不限制', '2M+', '未知', 'check'),
        'gd'      => array('GD库', '2.0', '2.0+', '未知', 'check'),
        'disk'    => array('磁盘空间', '100M', '不限制', '未知', 'check'),
    );

    // PHP环境检测
    if($items['php'][3] < $items['php'][1]){
        $items['php'][4] = 'times text-warning';
        session('error', true);
    }

    // 附件上传检测
    if(@ini_get('file_uploads'))
        $items['upload'][3] = ini_get('upload_max_filesize');

    // GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if(empty($tmp['GD Version'])){
        $items['gd'][3] = '未安装';
        $items['gd'][4] = 'times text-warning';
        session('error', true);
    } else {
        $items['gd'][3] = $tmp['GD Version'];
    }
    unset($tmp);

    // 磁盘空间检测
    if(function_exists('disk_free_space')) {
        $disk_size = floor(disk_free_space(INSTALL_APP_PATH) / (1024*1024));
        $items['disk'][3] = $disk_size.'M';
        if ($disk_size < 100) {
            $items['disk'][4] = 'times text-warning';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 */
function check_dirfile(){
    $items = array(
        array('dir',  '可写', 'check', '../application'),
        array('dir',  '可写', 'check', '../data'),
        array('dir',  '可写', 'check', '../export'),
        array('dir',  '可写', 'check', '../packet'),
        array('dir',  '可写', 'check', '../plugins'),
        array('dir',  '可写', 'check', './static'),
        array('dir',  '可写', 'check', './uploads'),
        array('dir',  '可写', 'check', '../runtime'),
        array('dir',  '可写', 'check', '../store'),
    );

    foreach ($items as &$val) {
        $item = INSTALL_APP_PATH . $val[3];
        if('dir' == $val[0]){
            if(!is_writable($item)) {
                if(is_dir($item)) {
                    $val[1] = '可读';
                    $val[2] = 'times text-warning';
                    session('error', true);
                } else {
                    $val[1] = '不存在';
                    $val[2] = 'times text-warning';
                    session('error', true);
                }
            }
        } else {
            if(file_exists($item)) {
                if(!is_writable($item)) {
                    $val[1] = '不可写';
                    $val[2] = 'times text-warning';
                    session('error', true);
                }
            } else {
                if(!is_writable(dirname($item))) {
                    $val[1] = '不存在';
                    $val[2] = 'times text-warning';
                    session('error', true);
                }
            }
        }
    }

    return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 */
function check_func(){
    $items = array(
        array('pdo','支持','check','类'),
        array('pdo_mysql','支持','check','模块'),
        array('fileinfo','支持','check','模块'),
        array('curl','支持','check','模块'),
        array('file_get_contents', '支持', 'check','函数'),
        array('mb_strlen', '支持', 'check','函数'),
    );

    foreach ($items as &$val) {
        if(('类'==$val[3] && !class_exists($val[0]))
            || ('模块'==$val[3] && !extension_loaded($val[0]))
            || ('函数'==$val[3] && !function_exists($val[0]))
        ){
            $val[1] = '不支持';
            $val[2] = 'times text-warning';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 写入配置文件
 * @param $config
 * @return array 配置信息
 */
function write_config($config){
    if(is_array($config)){
        //读取配置内容
        $conf = file_get_contents(APP_PATH . 'install/data/database.tpl');
        // 替换配置项
        foreach ($config as $name => $value) {
            $conf = str_replace("[{$name}]", $value, $conf);
        }

        //写入应用配置文件
        if(file_put_contents(APP_PATH . 'database.php', $conf)){
            show_msg('配置文件写入成功');
        } else {
            show_msg('配置文件写入失败！', 'error');
            session('error', true);
        }
        return '';
    }
}

/**
 * 创建数据表
 * @param $db 数据库连接资源
 * @param string $prefix 表前缀
 */
function create_tables($db, $prefix = ''){
    // 读取SQL文件
    $sql = file_get_contents(APP_PATH . 'install/data/dolphin.sql');

    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    // 替换表前缀
    $orginal = config('original_table_prefix');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

    // 开始安装
    show_progress('0%');
    $all_table = config('install_table_total');
    $i = 1;
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        $msg  = (int)($i/$all_table*100) . '%';
        if(false !== $db->execute($value)){
            show_progress($msg);
        } else {
            show_progress($msg, 'error');
            session('error', true);
        }
        $i++;
    }
}

/**
 * 更新数据表
 * @param $db 数据库连接资源
 * @param string $prefix 表前缀
 */
function update_tables($db, $prefix = ''){
    //读取SQL文件
    $sql = file_get_contents(APP_PATH . 'install/data/update.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    // 替换表前缀
    $sql = str_replace(" `dp_", " `{$prefix}", $sql);

    //开始安装
    show_progress('0%');
    $all_table = config('update_data_total');
    $i = 1;
    $msg = '';
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        if(substr($value, 0, 12) == 'CREATE TABLE') {
            $msg  = (int)($i/$all_table*100) . '%';
            if(($db->execute($value)) === false){
                session('error', true);
            }
        } else {
            if(substr($value, 0, 8) == 'UPDATE `') {
                $msg  = (int)($i/$all_table*100) . '%';
            } else if(substr($value, 0, 11) == 'ALTER TABLE'){
                $msg  = (int)($i/$all_table*100) . '%';
            } else if(substr($value, 0, 11) == 'INSERT INTO'){
                $msg  = (int)($i/$all_table*100) . '%';
            }
            if(($db->execute($value)) === false){
                session('error', true);
            }
        }

        if ($msg != '') {
            show_progress($msg);
            $i++;
        }
    }
}

/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 */
function show_msg($msg, $class = ''){
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}

/**
 * 显示进度
 * @param $msg
 * @param string $class
 * @author 蔡伟明 <314013107@qq.com>
 */
function show_progress($msg, $class = ''){
    echo "<script type=\"text/javascript\">show_progress(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}
/**
 * 获取 IP  地理位置
 * 淘宝IP接口
 * @Return: array
 */
function getCity($ip = '')
{
    if($ip == ''){
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
        $ip=json_decode(file_get_contents($url),true);
        $data = $ip;
    }else{
        $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
        $ip=json_decode(file_get_contents($url));   
        if((string)$ip->code=='1'){
           return false;
        }
        $data = (array)$ip->data;
    }
    
    return $data;   
}
//获取客户端真实IP
function getClientIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknow";
    }

    return $ip;
}

function json_code($code=0,$message="",$data=[]){
    $data=['code'=>$code,'msg'=>$message,'data'=>$data];
    return exit(json_encode($data));
}