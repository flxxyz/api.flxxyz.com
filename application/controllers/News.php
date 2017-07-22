<?php

class News extends CI_Controller
{
    public function __construct()
    {
        $this->load->model('News');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['new_item'] = $this->news_model->get_news($slug);

        if(empty($data['new_item'])) {
            show_404();
        }

        $data['title'] = $data['new_item']['title'];

        $this->load-view('templates/header', $data);
        $this->load-view('news/view', $data);
        $this->load-view('templates/footer');
    }
}