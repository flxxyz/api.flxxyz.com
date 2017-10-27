<header>
    <h1>秒拍 Miaopai</h1>
    <span><a href="/">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址: <b>(http://或https://)  <?php echo hostname(); ?>/miaopai/api</b></p>
    <p>请求类型: GET</p>
    <p>请求参数:
    <ul>
        <li><span>url</span>
            <ul>
                <li><span>秒拍视频的网址</span></li>
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
                <label>秒拍视频地址:</label>
                <input class="miaopai" type="url" placeholder="如：http://www.miaopai.com/show/zeepmhJos0atV3QuRA2Pbm5-c8RFSHlc.htm">
            </section>
            <section>
                <button class="btn" type="button">提取</button>
            </section>
        </section>
        <section class="result">
            <hr>
            <input type="text" class="url" value="" placeholder="返回结果:" />
        </section>
        <section><pre></pre></section>
    </form>
</article><!-- article_end -->
