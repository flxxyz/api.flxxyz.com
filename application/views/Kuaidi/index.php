<header>
    <h1>快递查询 Kuaidi</h1>
    <span><a href="/">回到首页</a></span>
</header><!-- header_end --><hr>
<article>
    <h3>使用手册</h3>
    <p>请求地址：<b><?=hostname()?>/kuaidi/api</b></p>
    <p>请求类型: GET</p>
    <p>请求参数:
    <ul>
        <li><span>num</span> 填入需要查询的快递单号
        </li>
        <li><span>company</span> 快递公司名称 <a href="/kuaidi/company">->查询快递名称-<</a>
        </li>
    </ul>
    </p>
    <form method="get">
        <section class="option">
            <section>
                <label>快递公司:</label>
                <select class="company">
                    <?=$options?>
                </select>
            </section>
            <section>
                <label class="num">快递单号:</label>
                <input type="text" class="num" placeholder="填写快递单号" />
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
</article>
<script>
    $('input.url').focus(function() {
        $(this).select()
    });
    $('.btn').click(function() {
        var num = $('input.num').val();
        if(num == '') {
            return;
        }
        var encode = $('.encode').val();
        $('input.url').val("http://<?=hostname()?>/kuaidi/api?company="+$('.company').val()+"&num="+num).select();
        console.log($('input.url').val());
        $.ajax({
            url: $('input.url').val(),
            dataType: 'json',
            success: function(result) {
                var code = FormatJson(result);
                $('.result').next().find('pre').html(code);
            }
        });
    })
</script>