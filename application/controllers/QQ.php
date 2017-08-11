<?php
/**
 * Created by PhpStorm.
 * User: fff
 * Date: 2017/8/6
 * Time: 22:35
 */

class QQ extends CI_Controller
{
    public $qq, $protocol, $size;

    public function index()
    {
        $protocol = is_https() ? 'https' : 'http';
        $url = base_url('/qq/api', $protocol);

        $script = <<<EOT
$(function() {
	$('input.url').focus(function() {
		$(this).select()
	});
    $('.btn').click(function() {
    	var qq = $('input.qq');
    	var re = /^[1-9][0-9]{4,11}$/;
        if( (qq.val() === '') ) {
            alert('请填写QQ号');
            return;
        }
        if( !re.test(qq.val()) ) {
        	alert('格式输入不正确呀，再来一次？');
            return;
        }
        $.ajax({
            url: '{$url}',
            type: 'get',
            dataType: 'json',
            data: {
            	qq: qq.val(),
            	protocol: $('select.protocol').val(),
            	size: $('select.size').val()
            },
            success: function(res) {
                $('input.url').val(res.url).select()
            }
        })
    })
})
EOT;

        $this->load->view('Layout/header', [
            'title' => 'QQ - API by Flxxyz.com',
            'author' => 'Flxxyz',
            'description' => '加密链接内QQ号，不用烦恼如何隐藏链接里的QQ号辣~',
            'keywords' => 'QQ头像解析,加密QQ头像连接,加密,QQ,qlogoK值',
        ]);
        $this->load->view('QQ/index');
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    public function api()
    {
        // 获取QQ号，否则默认
        $this->qq = get('qq') ? get('qq') : '10000';
        $this->protocol = $this->protocol();
        $this->size = $this->size();

        // 加密转换
        $cryp = $this->mx();

        // 效验QQ号规则，否则返回错误
        $re = "/^[1-9][0-9]{4,11}$/";

        if ( preg_match($re, $this->qq, $matches) ) {
            $hostname = hostname();
            $url = "{$this->protocol}://{$hostname}/qq/icon/{$cryp}?size={$this->size}";
            $arr = [
                "message" => "OK",
                "url" => $url,
                "error" => 0
            ];
        } else {
            $arr = [
                "message" => "error",
                "url" => "",
                //"orgin"   => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']:$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'],
                "error" => 1
            ];
        }

        echo json_encode($arr);
    }

    /**
     * 获取所需协议
     */
    protected function protocol() {
        $allProtocol = ['http', 'https'];
        return in_array(get('protocol'), $allProtocol) ? get('protocol') : 'http';
    }

    /**
     * 获取图片尺寸
     */
    protected function size() {
        $allSize = ['40', '100', '140', '160'];
        return in_array(get('size'), $allSize) ? get('size') : '100';
    }

    protected function mx($base = true)
    {
        if($base) {
            $qq = base_convert($this->qq, 10, 2);
            $qq .= 1;
            return base_convert($qq, 2, 32);
        }else {
            $qq = substr(base_convert($this->qq, 32, 2), 0, -1);
            return base_convert($qq, 2, 10);
        }

    }

    public function icon($qq)
    {
        $this->qq = $qq;
        $size = get('size') ? get('size') : '100';
        $this->qq = $this->mx(false);

        $url = "http://q.qlogo.cn/headimg_dl?dst_uin=$this->qq&spec=$size";
        //echo $url;

        showImage($url);
    }


}