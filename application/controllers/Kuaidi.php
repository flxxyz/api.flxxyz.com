<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kuaidi extends CI_Controller
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
EOT;
        $query = $this->db->get('kuaidi');
        $select = '<select>';
        foreach ($query->result() as $row) {
            $select .= "<option value='{$row->name}'>{$row->name}</option>";
        }
        $select .= '</select>';

        $this->load->view('Layout/header', [
            'title' => 'Kuaidi - Public API Service',
            'author' => 'Flxxyz',
            'description' => '提供快递查询接口服务',
            'keywords' => '快递查询',
        ]);
        $this->load->view('Kuaidi/index', [
            'select' => $select,
            'number' => $this->db->like('type', 'kuaidi')->count_all_results('monitor'),
        ]);
        $this->load->view('Layout/footer', ['script' => $script]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        $kuaidi_name = get('name');
        $danhao = get('num', '0000000000000');
        $query = $this->db->where(['name' => $kuaidi_name])->get('kuaidi');

        $uri = 'http://www.kuaidi.com/index-ajaxselectcourierinfo-[%YD%]-[%KD%].html';
        foreach($query->result() as $row) {
            $uri = str_replace('[%YD%]', $danhao, $uri);
            $uri = str_replace('[%KD%]', $row->value, $uri);
        }

        echo getHttp($uri);
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
            case 'json':
                return $this->json();
                break;
            default:
                return $this->json();
                break;
        }
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