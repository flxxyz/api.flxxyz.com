<header>
    <h1>二维码 Qrcode</h1>
    <span><a href="/">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址: <b>https://<?php echo hostname(); ?>/qr/api</b></p>
    <p>请求类型: POST</p>
    <p>请求参数:
    <ul>
        <li><span>content</span> 二维码内容</li>
    </ul>

    </p>
    <form method="post">
        <section class="option">
            <section>
                <label>二维码内容:</label>
                <textarea name="text" id="text" cols="30" rows="4" placeholder="填写二维码中的内容"></textarea>
            </section>
            <section>
                <button class="btn" type="button">获取二维码</button>
            </section>
        </section>
        <section class="result">
            <hr>
            <p class="message"></p>
            <input type="text" class="url" value="" placeholder="返回结果:" />
        </section>
        <section></section>
    </form>
</article><!-- article_end -->