<?php



class Home extends CI_Controller
{
    public function index() {
        $this->load->helper('url');
        redirect('/');
        /*if(is_file(FCPATH . 'cloudXNS.lock')) {
            var_dump(redirect('/'));
        }else {
            redirect('/');
        }*/
    }
}