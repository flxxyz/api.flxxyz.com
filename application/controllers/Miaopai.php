<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Miaopai extends CI_Controller
{
    public $base64, $url;
    protected $download, $info;
    protected $data = [
        'nickInfo' => [
            'url' => '',
            'nick' => '',
            'icon' => '',
            'nickUrl' => ''
        ],
        'videoInfo' => [
            'length' => '',
            'lengthNice' => '',
            'width' => '',
            'height' => '',
            'pic' => '',
            'download' => '',
            'dowmloadBak' => ''
        ],
        't' => '',
        'ft' => '',
        'vend' => ''
    ];

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
        var miaopai = $('.miaopai').val();
        if(!miaopai) {
            alert('请输入秒怕视频网址');
            return;
        }
        $('input.url').val($('.protocol').val()+"://{$hostname}/miaopai/api?url="+miaopai).select();
        $.getJSON($('input.url').val(), function(result) {
            var code = FormatJson(result);
            $('.result').next().find('pre').html(code);
        });
    })
})
EOT;

        $this->load->view('Layout/header', [
            'title' => 'Miaopai - Public API Service',
            'author' => 'Flxxyz',
            'description' => '秒拍视频API',
            'keywords' => '秒拍,秒拍视频,秒拍视频解析,秒拍API,api,秒拍视频API',
            'css' => '.miaopai { width: 600px }',
        ]);
        $this->load->view('Miaopai/index', ['number' => $this->db->like('type', 'miaopai')->count_all_results('monitor')]);
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        error_reporting(0);

        $this->checkUrl();
        $this->base64 = str_replace(".htm", "", str_replace("http://www.miaopai.com/show/", "", $this->url));

        $this->init();
        $this->db->set($this->monitor('miaopai'));
        $this->db->like('type', 'miaopai')->insert('monitor');
        echo $this->handle();
    }

    /**
     * 检测URL
     */
    protected function checkUrl()
    {
        if ( get('url') === '' ) {
            exit($this->dataStructure($this->data));
        } else {
            $this->url = get('url');
        }
    }

    /**
     * 初始化
     */
    protected function init()
    {
        $api_url_download = "http://gslb.miaopai.com/stream/[!BASE64].json?token=";
        $api_url_download = str_replace('[!BASE64]', $this->base64, $api_url_download);
        $api_url_info = "http://api.miaopai.com/m/v2_channel.json?fillType=259&scid=[!BASE64]&vend=miaopai";
        $api_url_info = str_replace('[!BASE64]', $this->base64, $api_url_info);

        $tmp_download = json_decode(file_get_contents($api_url_download));
        $tmp_info = json_decode(file_get_contents($api_url_info));

        $this->download = $tmp_download;
        $this->info = $tmp_info;
    }

    /**
     * 处理返回的数据结构
     */
    protected function handle()
    {
        $i = $this->download->result;
        $j = $this->info->result;

        $url = str_replace('[!BASE64]', $this->base64, "http://www.miaopai.com/show/[!BASE64].htm");

        $this->data['nickInfo']['url'] = $url;
        $this->data['nickInfo']['nick'] = $j->otherinfo->mark1;
        $this->data['nickInfo']['icon'] = $j->ext->owner->icon;
        $this->data['nickInfo']['nickUrl'] = $j->otherinfo->url;

        $this->data['videoInfo']['length'] = $j->ext->length;
        $this->data['videoInfo']['lengthNice'] = $j->ext->lengthNice;
        $this->data['videoInfo']['width'] = $j->ext->w;
        $this->data['videoInfo']['height'] = $j->ext->h;
        $this->data['videoInfo']['pic'] = $j->pic->base . $j->pic->m;
        $this->data['videoInfo']['download'] = $i[0]->scheme . $i[0]->host . $i[0]->path;
        $this->data['videoInfo']['dowmloadBak'] = $i[1]->scheme . $i[1]->host . $i[1]->path;

        $this->data['t'] = $j->ext->t;
        $this->data['ft'] = $j->ext->ft;
        $this->data['vend'] = $j->ext2->vend;

        return $this->dataStructure($this->data);
    }
}