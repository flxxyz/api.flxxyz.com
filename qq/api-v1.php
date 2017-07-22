<?php

require_once dirname(__DIR__).'/function.php';

$qq = isset($_GET['q'])&&(@ $_GET['q'] != '') ? $_GET['q'] : 'MjEzMDI3MTA0OQ==';
$AllSize = array('40','100','140','160');
$size = in_array(@$_GET['s'],$AllSize) ? $_GET['s'] : '100';
$time = time();
$qq = base64_decode($qq);

$url = "http://ptlogin2.qq.com/getface?&imgtype=1&uin=".$qq;
$html = getNetData($url);
$tmp = explode('"',$html);
$str = explode('&s=',$tmp[3]);
$q = $str[0]."&s=$size&t=$time";
$url = stripslashes($q);


// 输出头像
header('Content-Type: image/png');
@ob_end_clean();
@readfile($url);
@ob_flush();@flush();
exit();