<?php

header("content-type:application/json;charset:utf-8");

function token() {
    return mt_rand(1,9).mt_rand(0,9);
}

// 获取QQ号，否则默认
$qq = isset($_GET['q'])&&(@ $_GET['q'] != '') ? $_GET['q'] : '2130271049';
// 获取图片尺寸，否则默认
$AllSize = array('40','100','140','160');
$size = in_array(@$_GET['s'],$AllSize) ? $_GET['s'] : '100';
// 获取所需协议，否则默认
$AllProtocol = array('http','https');
$protocol = in_array(@$_GET['p'],$AllProtocol) ? $_GET['p'] : 'https';
// 获取所需版本，否则默认
$AllVersion = array('1','2');
$version = in_array(@$_GET['v'],$AllVersion) ? $_GET['v'] : '2';

// echo $url = "{$protocol}://api.com/api-v{$version}.php?q={$qq}&s={$size}";
// exit;

$q = base64_encode(token() . $qq );

// 效验QQ号规则，否则返回错误
$re = "/^[1-9][0-9]{4,11}$/";

if(preg_match($re, $qq, $matches)) {
    $url = "{$protocol}://api.com/qq/api-v{$version}.php?q={$q}&s={$size}";
    $arr = array(
        "message" => "OK",
        "url"     => $url,
        "orgin"   => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']:$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'],
        "error"   => 0
    );
}else {
    $arr = array(
        "message" => "QQ error",
        "url"     => "",
        "orgin"   => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']:$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'],
        "error"   => 1
    );
}

// $orgin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']:$_SERVER['SERVER_NAME'];
// if($orgin != 'flxxyz.com') {
//     echo "来自其它网站";
// }else {
//     echo "来自flxxyz.com";
// }

// 输出json信息
echo json_encode($arr ,JSON_UNESCAPED_UNICODE );
