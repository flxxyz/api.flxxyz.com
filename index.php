<?php
$css = '';
if( $_SERVER['REQUEST_SCHEME'] == 'http' )
    $protocol = 'https';
else {
    $css = '<style>a.protocol{color:#f00}</style>';
    $protocol = 'http';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>API by Flxxyz.com</title>
    <meta name="author" content="Flxxyz">
    <meta name=description content="希望各位大佬放过＞﹏＜，别做奇怪的事情" />
    <meta name="keywords" content="自用API,冯小贤,分享" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="public/css/main.css" />
    <?=$css?>
</head>
<body>
<header>
    <h2>API by Flxxyz.com</h2>
    <span><a href="<?=$protocol?>://api.flxxyz.com" class="protocol">切换至<?=$protocol?></a></span>
</header><!-- /header --><hr>
<article>
   <ul>
        <li><a href="hitokoto/" target="_blank">一言 Hitokoto</a></li>
        <li><a href="qq/" target="_blank">QQ头像 QQlogo</a></li>
        <li><a href="bing/" target="_blank">Bing壁纸 Bing</a></li>
        <li><a href="miaopai/" target="_blank">MiaoPai解析 MiaoPai</a></li>
        <li><a href="hello" target="_blank">随机语 RandomWords</a></li>
        <li><a href="ip/" target="_blank">IP查询 IPQuery</a></li>
    </ul>
</article>
<footer>
    <script src="https://api.flxxyz.com/hitokoto/api.php?encode=js"></script>
    <div id="hitokoto"><script>hitokoto()</script></div>
    <section><?=@date('Y')?> Power by <a href="https://www.flxxyz.com" target="_blank" style="color:#000">冯小贤</a>.</section>
</footer>
</body>
</html>