<?php
/**
 * Created by PhpStorm.
 * User: fff
 * Date: 2017/8/11
 * Time: 12:40
 */

class Ip extends CI_Controller
{
    public $encode, $source, $ip;
    protected $data;

    public function index()
    {

    }

    public function api()
    {
        $this->ip = $this->checkIp();
        $this->source = get('source') ? get('source') : 'baidu';
        $this->encode = get('encode') ? get('encode') : 'json';

        echo $this->init();
        //echo $this->init();
    }

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

    protected function init()
    {
        $this->optSource();

        switch ($this->encode) {
            case 'xml':
                return dataStructure($this->data, 'xml');
                break;
            case 'json':
                return dataStructure($this->data, 'json');
                break;
            default:
                return dataStructure($this->data, 'json');
                break;
        }
    }

    protected function optSource()
    {
        switch ($this->source) {
            case 'taobao':
                $this->data = $this->taobao();
                break;
            case 'baidu':
                $this->data = $this->baidu();
                break;
        }
    }

    protected function baidu()
    {
        $url = 'https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query=[!IP]&resource_id=6006&ie=utf8&oe=utf8&format=json';
        $url = str_replace('[!IP]', $this->ip, $url);
        $html = getHttp($url);
        $obj = json_decode($html);
        return [
            'location' => $obj->data[0]->location,
            'origip' => $obj->data[0]->origip,
        ];
    }

    protected function taobao()
    {
        $url = 'http://ip.taobao.com//service/getIpInfo.php?ip=[!IP]';
        $url = str_replace('[!IP]', $this->ip, $url);
        $json = getHttp($url);
        $obj = json_decode($json);
        return $obj;
    }
}