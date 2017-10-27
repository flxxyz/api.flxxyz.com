<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hitokoto extends CI_Controller
{
    public $protocol, $encode = 'json';
    protected $data;

    /**
     * 首页
     */
    public function index()
    {
        $hostname = hostname();
        $script = <<<EOT
  $(function () {
      $('input.url').focus(function () {
        $(this).select()
        });
      $('.btn').click(function () {
          var encode = $('.encode').val();
          $('input.url').val($('.protocol').val() + "://{$hostname}/hitokoto/api?encode=" + encode).select();
          if($('.encode').val() === 'js') {
            encode = 'text';
          }
          $.ajax({
            url: $('input.url').val(),
            dataType: encode,
            success: function(result) {
                switch(encode) {
                    case 'xml':
                        var code = $('<code></code>').text(FormatHTML('<DATA>'+$(result).find('DATA').html()+'<DATA>'));
                        $('.result').next().find('pre').html(code);
                        break;
                    case 'text':
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
            'title' => 'Hitokoto - Public API Service',
            'author' => '冯小贤',
            'description' => '分享一言，分享感动。',
            'keywords' => '一言,一句话,ヒトコト,动漫语录,动漫,语录,动漫经典语录,经典动漫台词,ACG,冯小贤',
        ]);
        $this->load->view('Hitokoto/index', ['number' => $this->db->like('type', 'hitokoto')->count_all_results('monitor')]);
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        $file = FCPATH . 'static/hitokoto.json';
        $json = file_get_contents($file);
        $this->data = json_decode($json, true);
        $this->protocol = is_https() ? 'https' : 'http';
        $this->encode = get('encode');

        $this->db->set($this->monitor('hitokoto'));
        $this->db->like('type', 'hitokoto')->insert('monitor');
        echo $this->init();
    }

    /**
     * 初始化
     * @return string
     */
    protected function init()
    {
        $data = $this->data;
        if ( count($data) != 0 ) {
            $this->data = $data[array_rand($data)];
        } else {
            exit('{"id":"","hitokoto":"","cat":"","catname":"","author":"","source":"","date":""}');
        }

        return $this->encode();
    }

    /**
     * 编码类型默认JSON
     * @return string
     */
    protected function encode()
    {
        switch ($this->encode) {
            case 'xml':
                return $this->xml();
                break;
            case 'js':
                return $this->js();
                break;
            case 'json':
                return $this->json();
                break;
            default:
                return $this->json();
                break;
        }
    }

    /**
     * XML编码
     * @return string
     */
    protected function xml()
    {
        $data = $this->data;

        header("content-type:application/xml;charset:utf-8;");
        $str = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<DATA>
  <id>[!ID]</id>
  <hitokoto>[!HITOKOTO]</hitokoto>
  <cat>[!CAT]</cat>
  <catname>[!CATNAME]</catname>
  <author>[!AUTHOR]</author>
  <source>[!SOURCE]</source>
  <date>[!DATE]</date>
</DATA>
EOT;
        $str = str_replace('[!ID]', $data['id'], $str);
        $str = str_replace('[!HITOKOTO]', $data['hitokoto'], $str);
        $str = str_replace('[!CAT]', $data['cat'], $str);
        $str = str_replace('[!CATNAME]', $data['catname'], $str);
        $str = str_replace('[!AUTHOR]', $data['author'], $str);
        $str = str_replace('[!SOURCE]', $data['source'], $str);
        $str = str_replace('[!DATE]', $data['date'], $str);
        return $str;
    }

    /**
     * JS编码
     * @return string
     */
    protected function js()
    {
        $data = $this->data;

        header("content-type:charset:utf-8;");
        return "var hitokoto = function(){document.getElementById('hitokoto').innerHTML='{$data['hitokoto']}'}";
    }

    /**
     * JSON编码
     * @return string
     */
    protected function json()
    {
        $data = $this->data;

        header("content-type:application/json;charset:utf-8;");
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}