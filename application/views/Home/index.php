<header>
    <h2>Public API Service</h2>
    <span><a href="<?php echo base_url('/', $protocol); ?>" class="protocol <?php echo $protocol?>">切换至<?=$protocol?></a></span>
</header><!-- /header --><hr>
<article>
    <ul>
        <li><a href="<?php echo base_url('/hitokoto', getProtocol()); ?>">一言 Hitokoto</a></li>
        <li><a href="<?php echo base_url('/qq',  getProtocol()); ?>">QQ头像 QQlogo</a></li>
        <li><a href="<?php echo base_url('/bing',  getProtocol()); ?>">Bing壁纸 Bing</a></li>
        <li><a href="<?php echo base_url('/miaopai',  getProtocol()); ?>">MiaoPai解析 MiaoPai</a></li>
        <li><a href="<?php echo base_url('/ip',  getProtocol()); ?>">IP查询 IPQuery</a></li>
        <li><a href="<?php echo base_url('/qr',  getProtocol()); ?>">二维码 QrCode</a></li>
    </ul>
</article>