<?php

class Admin extends CI_Controller
{
    public function index() {
        return $this->load->view('admin/index');
    }
    public function domain($param = 'list') {
        //echo base_url() . 'api/domain/list';
        //redirect(base_url() . 'api/domain/list');
        $data['header'] = json_encode([
            '域名ID',
            '域名名称',
            '域名状态',
            '域名接管状态 ',
            '域名等级',
            '创建时间',
            '更新时间',
            'TTL'
        ]);
        return $this->load->view('admin/domain_' . $param, $data);
    }
}