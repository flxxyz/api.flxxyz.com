<?php

require_once dirname(__DIR__).'/function.php';

$qq = isset($_GET['q'])&&(@ $_GET['q'] != '') ? $_GET['q'] : 'MjEzMDI3MTA0OQ==';
$AllSize = array('40','100','140','160');
$size = in_array(@$_GET['s'],$AllSize) ? $_GET['s'] : '100';

$qq = base64_decode($qq );
$qq = mb_substr($qq ,2 );
$url = "http://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=$size";

// 存储 && 输出
header('Content-Type: image/png');
@ob_end_clean();
echo getNetData($url);
@ob_flush();@flush();
exit();