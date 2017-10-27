<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Qr extends CI_Controller
{
    /**
     * 首页
     */
    public function index()
    {
        $url = base_url('/qr/api', 'http');
        $script = <<<EOT
$(function() {
    $('input.url').focus(function() {
		$(this).select()
	});
	$('.btn').click(function() {
	    var content = $('#text').val();
	    if(!content) {
	        alert('请输入二维码内容');
	        return;
	    }
	    
	    $.ajax({
	        url: '{$url}',
	        type: 'post',
	        dataType: 'json',
	        data: {
	            content: content
	        },
	        success: function(res) {
	            var url = res.result.url;
	            var type = $('#type').val()
	            var size = $('#size').val();
	            if(type != 'png') {
	                url = url + '?type=' + type;
	            }
	            if(res.result.url != url) {
	                if(size) {
	                    url = url + '&size=' + size;
	                }
	            }else {
	                if(size) {
	                    url = url + '?size=' + size;
	                }
	            }
	            
	            $('.url').val(url);
	            $('.message').text(res.message);
                var showIcon = $('<img>').attr('src', url);
                $('.result').next().html(showIcon);
	        }
	    });
	});
})
EOT;
        $css = '.result {color:red}';

        $this->load->view('Layout/header', [
            'title' => 'Qrcode - Public API Service',
            'author' => '冯小贤',
            'description' => '基本的二维码生成，且支持ss二维码',
            'keywords' => 'qrcode,ss,二维码,二维码生成,ss二维码',
            'css' => $css,
        ]);
        $this->load->view('Qr/index', ['number' => $this->db->like('type', 'qrcode')->count_all_results('monitor')]);
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        $value = post('content') ? post('content') : '';

        if ( empty($value) ) {
            exit(message(100, 'error', '参数不正确'));
        }

        $this->db->set($this->monitor('qrcode'));
        $this->db->like('type', 'qrcode')->insert('monitor');

        // 简单过滤字符串
        $value = htmlspecialchars($value, ENT_QUOTES);

        $this->db->where('value', $value);
        $query = $this->db->get('qrcode');
        if ( $query->result_id->num_rows > 0 ) {
            $query = $query->result()[0];

            $updated_at = ['updated_at' => time()];
            $this->db->where('id', $query->id);
            $this->db->update('qrcode', $updated_at);

            $result = [];
            $result['name'] = $query->name;
            $result['url'] = base_url('/qr/image/' . $query->name);
            if ( !is_null($query->nick) ) {
                $result['nick'] = $query->nick;
                $result['url'] = base_url('/qr/image/' . $query->nick);
            }

            exit(message(200, 'success', '当前二维码存在', $result));
        }

        $name = md5(base64_encode($value));
        $name = base_convert($name, 10, 2);
        $name = base_convert($name, 2, 32);

        $row = [
            'name' => $name,
            'value' => $value,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        $this->db->set($row);

        if ( $this->db->insert('qrcode') ) {
            $result = [];
            $result['name'] = $name;
            $result['url'] = base_url('/qr/image/' . $name);
            exit(message(200, 'success', '生成二维码成功', $result));
        } else {
            exit(message(100, 'error', '生成二维码失败'));
        }
    }

    /**
     * 展示二维码
     *
     * @param string $param
     */
    public function image($param)
    {
        $size = get('size') ? get('size') - 20 : 180;
        $type = get('type') ? get('type') : 'png';

        $this->db->set($this->monitor('qrcode-show'));
        $this->db->like('type', 'qrcode-show')->insert('monitor');

        $query = $this->db->where('name', $param)
            ->or_where('nick', $param)
            ->get('qrcode');
        if ( $query->result_id->num_rows > 0 ) {
            $value = $query->result()[0]
                ->value;
            $text = $value;
        } else {
            $text = '对不起, 你查找的二维码 tan°90';
        }

        $qr = new QrCode($text);
        $qr->setWriterByName($type);
        $qr->setSize($size)
            ->setEncoding('utf-8')
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0]);
        //->setLogoPath(__DIR__ . '/../../static/img/23333.160.gif')
        //->setLogoWidth(intval($qr->getSize() / 6))
        //->setValidateResult(false);

        header('Content-Type: ' . $qr->getContentType());
        echo $qr->writeString();
    }

    /**
     * shadowsocks二维码
     */
    protected function ss()
    {
        $config = [
            'method' => 'aes-256-cfb',
            'pass' => '12345678',
            'host' => '127.0.0.1',
            'port' => '31313'
        ];
        $ss = 'ss://' . base64_encode("{$config['method']}:{$config['pass']}@{$config['host']}:{$config['port']}");

    }
}