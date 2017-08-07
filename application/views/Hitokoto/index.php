<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>Hitokoto - API by Flxxyz.com</title>
    <meta name="author" content="Flxxyz">
    <meta name=description content="分享一言，分享感动。" />
    <meta name="keywords" content="一言,一句话,ヒトコト,动漫语录,动漫,语录,动漫经典语录,经典动漫台词,ACG,冯小贤" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!--script src="../node_modules/jquery/dist/jquery.min.js"></script-->
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../public/css/main.css" />
</head>
<body>
<header>
    <h1>一言 Hitokoto</h1>
    <span><a href="http://api.flxxyz.com">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址：<b>http://api.flxxyz.com/hitokoto/api.php</b></p>
    <p>请求类型: GET</p>
    <p>请求参数：
    <ul>
        <li><span>encode</span>
            <ul>
                <li><span>json</span> 返回JSON格式数据 【默认】</li>
                <li><span>xml</span> 返回XML格式数据</li>
                <li><span>js</span> 返回函数名为hitokoto的JavaScript脚本</li>
            </ul>
        </li>
    </ul>
    </p>
    <form method="get">
        <section class="option">
            <section>
                <label>协议:</label>
                <select class="protocol">
                    <option value="http">http</option>
                    <option value="https">https</option>
                </select>
            </section>
            <section>
                <label>数据格式:</label>
                <select class="version">
                    <option value="js">js</option>
                    <option value="json" selected>json</option>
                    <option value="xml">xml</option>}
                    option
                </select>
            </section>
            <section>
                <button class="btn" type="button">提取</button>
            </section>
        </section>
        <section class="result">
            <hr>
            <input type="text" class="url" value="" placeholder="返回结果:" />
        </section>
    </form>
</article><!-- article_end -->
<footer>
    <script src="https://api.flxxyz.com/hitokoto/api.php?encode=js"></script>
    <div id="hitokoto"><script>hitokoto()</script></div>
    <section>2017 Power by <a href="https://www.flxxyz.com" target="_blank" style="color:#000">冯小贤</a>.</section>
</footer>
</body>
<script>
</script>
</html>