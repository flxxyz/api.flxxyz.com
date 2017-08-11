<header>
    <h1>IP查询 IPQuery</h1>
    <span><a href="/">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址：<b>(http://或https://)  <?php echo hostname(); ?>/ip/api</b></p>
    <p>请求类型: GET</p>
    <p>请求参数:
    <ul>
        <li><span>ip</span> 填入需要查询的IP地址,留空为本身
        </li>
        <li><span>source</span> 数据来源
            <ul>
                <li><span>baidu</span> baidu数据 【默认】</li>
                <li><span>taobao</span> taobao数据</li>
                <li><span>aliyun</span> aliyun付费数据【自用需付费，添加appcode】</li>
            </ul>
        </li>
        <li><span>encode</span>
            <ul>
                <li><span>json</span> 返回JSON格式数据 【默认】</li>
                <li><span>xml</span> 返回XML格式数据</li>
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
                <select class="encode">
                    <option value="json" selected>json</option>
                    <option value="xml">xml</option>
                </select>
            </section>
            <section>
                <label>源:</label>
                <select class="source">
                    <option value="baidu" selected>百度接口</option>
                    <option value="taobao">淘宝接口</option>
                    <option value="aliyun">阿里云付费接口</option>
                </select>
            </section>
            <section>
                <label class="ip">IP:</label>
                <input type="text" class="ip" placeholder="填写IP地址" />
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