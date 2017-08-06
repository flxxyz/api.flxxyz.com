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

        return $this->load->view('Home/index', $data);
    }
}