<style>
    form {
        display: table;
        margin: 0 auto;
        margin-top: 20px;
    }
    input, button {
        border: 0;
        border-radius: 0;
        padding: 10px;
    }
    input:focus, button:focus {
        outline: 0;
    }
    input {
        border: 1px solid #ddd;
        padding-right: 25px
    }
    button {
        color: #fff;
        background: #3385ff;
    }
    input:focus {
        border: 1px solid #3385ff;
    }
    form>div {

    }
    table {
        background: #fff;
        margin: 0 auto;
        padding-bottom: 20%;
    }
    th {
        background: #ddd;
        padding: 0 20px
    }
    td {
        background: #fff;
    }
    #kuaidi {
        position: relative;
    }
</style>
<header>
    <h1>快递公司名称查询</h1>
    <span><a href="/kuaidi">回到kuaidi</a></span>
</header><!-- header_end --><hr>
<form action="#">
    <div>
        <input id="kuaidi" type="text" name="company" value="<?=$kuaidi?>" placeholder="输入查找的快递公司"><button type="submit">查询</button>
    </div>
</form>
<table>
    <?=$result;?>
</table>
<script>
    $(function () {
        var kuaidi = $('#kuaidi');

        function clearText() {
            if($('#clear').text()) {
                return;
            }

            var style = {
                zIndex: 5,
                position: 'absolute',
                color: '#999'
            };
            style.left = kuaidi.get(0).offsetLeft + kuaidi.get(0).offsetWidth - 21;
            style.top = kuaidi.get(0).offsetTop + kuaidi.get(0).offsetHeight - 30;
            var div = $('<div></div>').css(style)
                .attr('id', 'clear')
                .text('x')
                .click(function () {
                    kuaidi.val('');
                    $(this).remove();
                });
            $('body').append(div);
        }

        kuaidi.bind('input propertychange focus', function() {
            if($(this).val().length > 0) {
                clearText();
            }else if($(this).val().length === 0) {
                $('#clear').remove();
            }
        })

        $('form').submit(function () {
            if(kuaidi.val().length <= 0) {
                return false;
            }
        })

        if(kuaidi.val().length > 0) {
            clearText();
        }else if(kuaidi.val().length === 0) {
            $('#clear').remove();
        }
    })
</script>