<header>
    <h1>一言 Hitokoto</h1>
    <span><a href="/">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址: <b>(http://或https://)  <?php echo hostname(); ?>/hitokoto/api</b></p>
    <p>请求类型: GET</p>
    <p>请求参数:
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
