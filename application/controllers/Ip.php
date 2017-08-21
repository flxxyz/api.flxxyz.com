<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ip extends CI_Controller
{
    public $encode, $source, $ip;
    protected $data;

    /**
     * 首页
     */
    public function index()
    {
        $hostname = hostname();
        $script = <<<EOT
$(function() {
    $('input.url').focus(function() {
        $(this).select()
    });
    $('.btn').click(function() {
        var ip = $('input.ip').val();
        if(ip === '') {
            ip = 'self';
        }
        var encode = $('.encode').val();
        $('input.url').val($('.protocol').val()+"://{$hostname}/ip/api?ip="+ip+"&encode="+encode+"&source="+$('.source').val()).select()
        $.ajax({
            url: $('input.url').val(),
            dataType: encode,
            success: function(result) {
                switch(encode) {
                    case 'xml':
                        var code = $('<code></code>').text(FormatHTML('<DATA>'+$(result).find('DATA').html()+'<DATA>'));
                        $('.result').next().find('pre').html(code);
                        break;
                    case 'js':
                        var code = result;
                        $('.result').next().find('pre').html(code);
                        break;
                    case 'json':
                        var code = FormatJson(result);
                        $('.result').next().find('pre').html(code);
                        break;
                }
            }
          });
    })
})
EOT;

        $this->load->view('Layout/header', [
            'title' => 'IPQuery - Public API Service',
            'author' => 'Flxxyz',
            'description' => 'IP查询',
            'keywords' => 'IP查询,IP地址,ip',
        ]);
        $this->load->view('Ip/index', ['number' => $this->db->like('type', 'ip')->count_all_results('monitor')]);
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        error_reporting(0);

        $this->ip = $this->checkIp();
        $this->source = get('source') ? get('source') : 'baidu';
        $this->encode = get('encode') ? get('encode') : 'json';

        $this->db->set($this->monitor('ip'));
        $this->db->like('type', 'ip')->insert('monitor');
        echo $this->init();
    }

    /**
     * 检测IP
     * @return mixed|string
     */
    protected function checkIp()
    {
        if ( get('ip') === 'self' ) {
            return get_client_ip();
        } else if ( get('ip') !== '' ) {
            return get('ip');
        } else {
            return '0.0.0.0';
        }
    }

    /**
     * 初始化
     * @return string
     */
    protected function init()
    {
        $this->source();

        switch ($this->encode) {
            case 'xml':
                return $this->dataStructure($this->data, 'xml');
                break;
            case 'json':
                return $this->dataStructure($this->data, 'json');
                break;
            default:
                return $this->dataStructure($this->data, 'json');
                break;
        }
    }

    /**
     * IP查询源选择
     */
    protected function source()
    {
        switch ($this->source) {
            case 'taobao':
                $this->data = $this->taobao();
                break;
            case 'baidu':
                $this->data = $this->baidu();
                break;
            case 'aliyun':
                $this->data = $this->aliyun();
                break;
            default:
                $this->data = $this->baidu();
                break;
        }
    }

    /**
     * 百度源
     * @return array
     */
    protected function baidu()
    {
        $url = 'https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query=[!IP]&resource_id=6006&ie=utf8&oe=utf8&format=json';
        $url = str_replace('[!IP]', $this->ip, $url);
        $html = getHttp($url);
        $obj = json_decode($html);
        return [
            'source' => $this->source,
            'location' => $obj->data[0]->location,
            'query_ip' => $obj->data[0]->origip,
        ];
    }

    /**
     * 淘宝源
     * @return array
     */
    protected function taobao()
    {
        $url = 'http://ip.taobao.com//service/getIpInfo.php?ip=[!IP]';
        $url = str_replace('[!IP]', $this->ip, $url);
        $json = getHttp($url);
        $obj = json_decode($json);
        return [
            'source' => $this->source,
            'location' => $obj->data->country . $obj->data->region . $obj->data->city . $obj->data->isp,
            'query_ip' => $obj->data->ip,
        ];
    }

    /**
     * 阿里云API源（需购买IP的API服务）
     * @return array
     */
    protected function aliyun()
    {
        $appcode = "";  // 你自己的AppCode
        if ( $appcode === '' ) {
            return [
                'source' => $this->source,
                'location' => '秒天秒地秒空气',
                'query_ip' => $this->ip,
            ];
        }

        $host = "http://jisuip.market.alicloudapi.com";
        $path = "/ip/location";
        $method = "GET";
        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = str_replace('[!IP]', $this->ip, "ip=[!IP]");
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if ( 1 == strpos("$" . $host, "https://") ) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }

        $result = curl_exec($curl);
        curl_close($curl);
        $obj = json_decode($result);

        if ( $obj->result->province === '未分配或者内网IP' ) {
            $location = $obj->result->province;
        } else {
            $location = $obj->result->country . $obj->result->province . $obj->result->city . $obj->result->type;
        }

        $this->db->set($this->monitor('ip-aliyun'));
        $this->db->like('type', 'ip-aliyun')->insert('monitor');
        return [
            'source' => $this->source,
            'location' => $location,
            'query_ip' => $obj->result->ip,
        ];
    }
}