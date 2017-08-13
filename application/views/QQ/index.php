<header>
    <h1>QQ头像 qq-icon</h1>
    <span><a href="http://api.flxxyz.com">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址: <b>(http://或https://)  <?php echo hostname(); ?>/qq/api</b></p>
    <p>请求类型: POST</p>
    <p>请求参数:
    <ul>
        <li><span>qq</span> QQ号码</li>
        <li><span>size</span> 返回相应尺寸
            <ul>
                <li><span>40</span> 返回尺寸40x40的图片</li>
                <li><span>100</span> 返回尺寸100x100的图片 【默认】</li>
                <li><span>140</span> 返回尺寸140x140的图片</li>
                <li><span>160</span> 返回尺寸160x160的图片</li>
            </ul>
        </li>
        <li><span>protocol</span> 返回相应协议类型
            <ul>
                <li><span>http</span> 返回使用http协议的链接 【默认】</li>
                <li><span>https</span> 返回使用https协议的链接</li>
            </ul>
        </li>
    </ul>

    </p>
    <form method="get">
        <section class="option">
            <section>
                <label class="qq">QQ:</label>
                <input type="text" class="qq" maxlength="12" min="5" pattern="[1-9][0-9]{4,11}" placeholder="填写QQ号" />
            </section>
            <section>
                <label>尺寸:</label>
                <select class="size">
                    <option value="40">40</option>
                    <option value="100" selected>100</option>
                    <option value="140">140</option>
                    <option value="160">160</option>
                </select>
            </section>
            <section>
                <label>协议:</label>
                <select class="protocol">
                    <option value="http">http</option>
                    <option value="https">https</option>
                </select>
            </section>
            <section>
                <button class="btn" type="button">获取加密头像</button>
            </section>
        </section>
        <section class="result">
            <hr>
            <input type="text" class="url" value="" placeholder="返回结果:" />
        </section>
        <section></section>
    </form>
</article><!-- article_end -->