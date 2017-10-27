<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuaidi extends CI_Controller
{
    public $protocol, $encode = 'json';
    protected $data, $response;

    /**
     * 首页
     */
    public function index()
    {
        $query = $this->db->get('kuaidi');
        $options = '';
        foreach ($query->result() as $row) {
            $options .= "<option value='{$row->name}'>{$row->name}</option>";
        }

        $this->load->view('Layout/header', [
            'title' => 'Kuaidi - Public API Service',
            'author' => '冯小贤',
            'description' => '提供快递查询接口服务',
            'keywords' => '快递查询',
        ]);
        $this->load->view('Kuaidi/index', [
            'options' => $options,
            'number' => $this->db->like('type', 'kuaidi')->count_all_results('monitor'),
        ]);
        $this->load->view('Layout/footer', [
            'script' => '',
        ]);
    }

    public function company()
    {
        $data = '';
        $name = get('company', '');
        if ($name != '') {
            $data = '<tr><th>公司名称</th><th> 名称拼音 </th></tr>';
            $query = $this->db->like('name', $name)->get('kuaidi');
            $count = 0;
            foreach ($query->result() as $row) {
                $data .= "<tr><td>{$row->name}</td><td>{$row->value}</td></tr>";
                $count++;
            }
            if ($count == 0) {
                $data = '<tr><td colspan="2">对不起，没有查询到此快递公司</tdcols></tr>';
            }
        }

        $this->load->view('Layout/header', [
            'title' => 'Kuaidi - Public API Service',
            'author' => 'Flxxyz',
            'description' => '提供快递查询接口服务',
            'keywords' => '快递查询',
        ]);
        $this->load->view('Kuaidi/company', [
            'kuaidi' => $name,
            'result' => $data
        ]);
    }

    /**
     * 提供API接口服务
     */
    public function api()
    {
        $kuaidi_name = get('company');
        $danhao = get('num', '0000000000000');
        $query = $this->db->like('name', $kuaidi_name)->get('kuaidi', 0, 1);

        $uri = 'http://www.kuaidi.com/index-ajaxselectcourierinfo-[%YD%]-[%KD%].html';
        foreach ($query->result() as $row) {
            $uri = str_replace('[%YD%]', $danhao, $uri);
            $uri = str_replace('[%KD%]', $row->value, $uri);
        }

        $this->data = getHttp($uri);
        echo $this->init($kuaidi_name);
    }

    /**
     * 初始化
     * @param $company
     * @return string
     */
    protected function init($company = '')
    {
        $data = json_decode($this->data);

        // 返回数据体结构
        $response = [
            'success' => $data->success,
            'phone' => $data->phone,
            'status' => 0,
            'companytype' => isset($query['value']) ? $query['value'] : '',
            'company' => $company,
            'num' => $data->nu,
            'data' => [],
            'time' => time(),
            'timeused' => 0,
            'exceed' => '',
        ];

        // 提取快递公司中英文名称
        $query = $this->db->where(['name' => $company])->get('kuaidi', 0, 1);
        $query = $query->result_array();
        if (count($query) == 0) {
            exit(json_encode($response));
        }

        if (!$data->success) {
            exit(json_encode($response));
        }

        $response['status'] = 1;
        $response['data'] = $data->data;
        $response['timeused'] = ($data->timeused != '--') ? $data->timeused : 0;
        $response['exceed'] = $data->exceed;
        $this->response = $response;
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
        $response = $this->response;

        header("content-type:application/json;charset:utf-8;");
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

}