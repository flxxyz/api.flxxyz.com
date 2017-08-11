<?php

class Bing extends CI_Controller
{
    public $id, $html, $encode;
    protected $url = 'http://cn.bing.com/HPImageArchive.aspx?n=1&idx=[!ID]';
    protected $data;

    public function __construct()
    {
        parent::__construct();
    }

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
            $('input.url').val($('.protocol').val() + "://{$hostname}/bing/api?type=" + $('.type').val() + "&encode=" + $('.version').val() + "&day=" + $('.day').val()).select()
        })
    })
EOT;

        $this->load->view('Layout/header', [
            'title' => 'Bing - API by Flxxyz.com',
            'author' => 'Flxxyz',
            'description' => '必应壁纸',
            'keywords' => '必应壁纸,必应图片',
        ]);
        $this->load->view('Bing/index');
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        $type = get('type') ? get('type') : 'url';
        $this->encode = get('encode') ? get('encode') : 'json';
        $this->id = get('day') ? get('day') : 1;
        $this->url = str_replace('[!ID]', $this->id, $this->url);

        $this->init($type);
    }

    /**
     * 初始化
     *
     * @param $type
     */
    protected function init($type)
    {
        $this->data = $this->main();

        if ( $type === 'bg' ) {
            showImage($this->data['imageurl']);
        } else {
            $this->dataStructure($this->data, $this->encode);
        }
    }

    /**
     * 处理主体
     * @return array
     */
    protected function main()
    {
        $this->html = file_get_contents($this->url);

        return [
            'startdate' => $this->handleHtmlDate("/<startdate>(.+?)<\/startdate>/ies"),
            'enddate' => $this->handleHtmlDate("/<enddate>(.+?)<\/enddate>/ies"),
            'imageurl' => 'http://cn.bing.com' . $this->handleHtmlDate("/<url>(.+?)<\/url>/ies"),
            'copyright' => $this->handleHtmlDate("/<copyright>(.+?)<\/copyright>/ies")
        ];
    }

    /**
     * 处理HTML数据
     *
     * @param $re
     *
     * @return string
     */
    protected function handleHtmlDate($re)
    {
        $itemTxt = '';
        if ( preg_match($re, $this->html, $matches) )
            $itemTxt = $matches[1];

        return $itemTxt;
    }
}