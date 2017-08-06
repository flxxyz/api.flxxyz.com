<?php

class Bing extends CI_Controller
{
    public $id, $html;
    protected $url;
    protected $data;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //var_dump($this->uri->uri_to_assoc());
    }

    public function api()
    {
        $type = get('type') ? get('type') : 'url';
        $encode = get('encode') ? get('encode') : 'json';
        $this->id = get('day') ? get('day') : 1;
        $this->url = 'http://cn.bing.com/HPImageArchive.aspx?n=1&idx=' . $this->id;
        self::init($type, $encode);
    }

    protected function init($type, $encode)
    {
        $this->data = self::main();

        if ( $type == 'bg' ) {
            self::showImage();
        } else {
            $this->dataStructure($this->data, $encode);
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

    protected function showImage()
    {
        $imgUrl = $this->data['imageurl'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imgUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $imgUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        ob_start();
        $return_content = ob_get_contents();
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = curl_exec($ch);
        ob_end_clean();
        curl_close($ch);
        if ( !( $code != '404' && $result ) )
            return false;

        header('Content-Type: image/jpeg');
        @ob_end_clean();
        echo $result;
        @ob_flush();
        @flush();
    }

    protected function handleHtmlDate($re)
    {
        $itemTxt = '';
        if ( preg_match($re, $this->html, $matches) )
            $itemTxt = $matches[1];

        return $itemTxt;
    }
}