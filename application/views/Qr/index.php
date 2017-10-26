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
    <p>返回数据: json</p>
    <p>结果集url参数:</p>
    <p>
    <ul>
        <li><span>type</span> 二维码显示格式
            <ul>
                <li><span>png</span> 返回png格式二维码【默认】</li>
                <li><span>svg</span> 返回svg格式二维码</li>
                <!--li><span>eps</span> 返回eps格式二维码</li-->
            </ul>
        </li>
        <li><span>size</span> 数值大小 【默认180】(不包含边框)</li>
    </ul>
    </p>

    <form method="post">
        <section class="option">
            <section>
                <label>显示格式:</label>
                <select name="type" id="type">
                    <option value="png">png</option>
                    <option value="svg">svg</option>
                    <!--option value="eps">eps</option-->
                </select>
            </section>
            <section>
                <label>显示大小</label>
                <input type="text" id="size" placeholder="默认大小180">
            </section>
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