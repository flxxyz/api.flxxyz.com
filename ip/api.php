<?php

require_once dirname(__DIR__).'/function.php';

$ip = isset($_GET['ip'])&&(@ $_GET['ip'] != '') ? $_GET['ip'] : getClientIp();
$source = isset($_GET['source'])&&(@ $_GET['source'] != '') ? $_GET['source'] : 'baidu';
$encode = isset($_GET['encode'])&&(@ $_GET['encode'] != '')?$_GET['encode']:'json';

if($ip == 'self') {
    $ip = getClientIp();
    $source = 'ip.cn';
}

initIP($ip ,$source ,$encode );
