<?php

class Pages extends CI_Controller
{
    /**
     * 重新练手操作，熟悉方法，路由，视图
     * @param string $page
     */
    public function view($page = 'home')
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = ucfirst($page);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function get_news($slug = false) {
        if($slug === false) {
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', ['slug' => $slug]);
        return $query->row_array();
    }
}