<?php

class Home extends CI_Controller
{
    public function index()
    {
        //$this->load->helper('url');
        //echo base_url() . 'api/domain/list';
        //redirect(base_url() . 'api/domain/list');
        /*if(is_file(FCPATH . 'cloudXNS.lock')) {
            var_dump(redirect('/'));
        }else {
            redirect('/');
        }*/

        $data = [];
        if(is_https()) {
            $data['protocol'] = 'http';
        }else {
            $data['css'] = 'a.protocol{color:#f00}';
            $data['protocol'] = 'https';
        }

        $this->load->view('Layout/header', [
            'title' => 'API by Flxxyz.com',
            'author' => 'Flxxyz',
            'description' => '希望各位大佬放过＞﹏＜，别做奇怪的事情',
            'keywords' => '自用API,冯小贤,分享',
        ]);
        $this->load->view('Home/index', $data);
        $this->load->view('Layout/footer.php', ['script' => '']);
    }

    public function test()
    {
        var_dump(get_config());
    }
}