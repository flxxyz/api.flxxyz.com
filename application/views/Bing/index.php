<header>
    <h1>必应壁纸 Bing</h1>
    <span><a href="/">回到首页</a></span>
</header><!-- header_end -->
<hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址: <b>(http://或https://)  <?php echo hostname(); ?>/bing/api</b></p>
    <p>请求类型: GET</p>
    <p>请求参数:
    <ul>
        <li><span>type</span> 返回类型
            <ul>
                <li><span>url</span> 返回数据 【默认】</li>
                <li><span>bg</span> 返回图片</li>
            </ul>
        </li>
        <li><span>day</span> 选取某天
            <ul>
                <li><span>0</span> 返回明天数据</li>
                <li><span>1</span> 今天 【默认】</li>
                <li><span>2</span> 昨天</li>
                <li><span>...</span> 以此类推</li>
                <li><span>10</span> 返回之前第10天内容</li>
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
                <label>选取某天:</label>
                <select class="day">
                    <option value="-1">明天</option>
                    <option value="0" selected>今天</option>
                    <option value="1">-1s</option>
                    <option value="2">-2s</option>
                    <option value="3">-3s</option>
                    <option value="4">-4s</option>
                    <option value="5">-5s</option>
                    <option value="6">-6s</option>
                    <option value="7">-7s</option>
                    <option value="8">-8s</option>
                    <option value="9">-9s</option>
                    <option value="10">-10s</option>
                </select>
            </section>
            <section>
                <label>获取类型:</label>
                <select class="type">
                    <option value="url" selected>url</option>
                    <option value="bg">bg</option>
                </select>
            </section>
            <section>
                <button class="btn" type="button">提取</button>
            </section>
        </section>
        <section class="result">
            <hr>
            <input type="text" class="url" value="" placeholder="返回结果:"/>
        </section>
        <section></section>
    </form>
</article><!-- article_end -->
