<?php

class Bing extends CI_Controller
{
    public $id, $html;
    protected $url;

    public function __construct()
    {
        parent::__construct();
        $this->id = 1;
        $this->url = 'http://cn.bing.com/HPImageArchive.aspx?n=1&idx=' . $this->id;
    }

    public function index()
    {

    }

    public function api($type = 'url', $encode = 'json')
    {
        self::init($type, $encode);
    }

    protected function init($type = 'url', $encode = 'json')
    {
        $data = self::main();
        //var_dump($data);
        if ( $type == 'bg' ? true : false ) {
            self::showImage($data);
        } else {
            $this->dataStructure($data, $encode);
        }
    }

    protected function main()
    {
        $this->html = file_get_contents($this->url);

        return [
            'startdate' => self::handleHtmlDate("/<startdate>(.+?)<\/startdate>/ies"),
            'enddate' => self::handleHtmlDate("/<enddate>(.+?)<\/enddate>/ies"),
            'imageurl' => 'http://cn.bing.com' . self::handleHtmlDate("/<url>(.+?)<\/url>/ies"),
            'copyright' => self::handleHtmlDate("/<copyright>(.+?)<\/copyright>/ies")
        ];
    }

    protected function showImage($data)
    {
        header('Content-Type: image/jpeg');
        @ob_end_clean();
        echo 'image/jpeg';
        echo getNetData($data['imageurl']);
        @ob_flush();
        @flush();
        exit();
    }

    protected function handleHtmlDate($re)
    {
        $url = '';
        $html = $this->html;

        if ( preg_match($re, $html, $matches) )
            $url = $matches[1];

        return $url;
    }
}