<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller
{
    public function index()
    {
        //$this->session->set_userdata('aaa', 123);
        //$this->session->unset_userdata('is_login');

        if ( isset($this->session->is_login) ) {
            $this->session->unset_userdata('message');
            redirect('manager/u/' . $this->session->username);
        } else {
            redirect('manager/login');
        }
    }

    public function login()
    {
//        $this->session->unset_userdata('is_login');
        $script = '';

        var_dump($this->session->is_login);
        if ( isset($this->session->is_login) ) {
            if ( !$this->session->is_login ) {
                $this->session->unset_userdata('message');
            }
        } else {
            $this->session->unset_userdata('url');
            $this->session->unset_userdata('id');
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('is_login');
        }

        if ( isset($this->session->is_login) ) {
            if ( $this->session->is_login === 2 ) {
                $this->session->message = '登陆成功, <span id="time">3</span>秒后跳转';
                $this->session->url = site_url('manager/u/') . $this->session->id;
                $script = <<<EOT
<script>
var timer = setInterval(function() {
    var a = parseInt($('#time').text());
    if(a === 0) {
        clearInterval(timer);
    }
    $('#time').text(--a);
}, 1000);
var redirect = setTimeout(function() {
    window.location.href = '{$this->session->url}';
}, 3000);
</script>
EOT;
            }
        }

        $this->load->view('Manager/login', [
            'is_login' => ( $this->session->is_login < 2 ) ? false : true,
            'message' => $this->session->message,
            'script' => $script,
        ]);
    }

    public function loginc()
    {
        $name = xss_clean(get('username'));
        $pwd = xss_clean(get('password'));

        if ( $name ) {
            if ( $this->check($name, $pwd) ) {
                $this->session->set_userdata('is_login', 2);
                $this->session->set_userdata('username', $name);
                redirect('manager/login');
            }
        } else {
            $this->session->unset_userdata('is_login', 1);
            redirect('manager/login');
        }

    }

    public function logout()
    {
        if ( isset($this->session->is_login) ) {
            if ( $this->session->is_login == 2 ) {
                $this->session->set_userdata('is_login', 0);
                exit("注销成功<script>setTimeout(function() {window.location.href = '{$this->session->url}';}, 1000);</script>");
            }
        }

        redirect('manager/login');
    }

    protected function userinfo($name)
    {
        $userinfo = $this->db->select(['id', 'name', 'password', 'email'])
            ->where(['name' => $name])
            ->get('user');
        if ( isset($userinfo->result_array()[0]) ) {
            return $userinfo->result_array()[0];
        } else {
            $this->session->set_userdata('is_login', 1);
            $this->session->message = '用户不存在';
            redirect('manager/login');
        }
    }

    protected function check($name, $pwd)
    {
        $user = $this->userinfo($name);

        if ( hash('sha256', $pwd) !== $user['password'] ) {
            $this->session->set_userdata('is_login', 1);
            $this->session->message = '用户名或密码错误';
            redirect('manager/login');
        }

        $this->session->set_userdata('id', '18000' . $user['id']);
        return true;
    }

    public function u($id = '')
    {
        $id = xss_clean($id);
        $id = str_replace('18000', '', $id);

        if ( is_numeric($id) ) {
            $user = $this->db->select(['name'])
                ->where(['id' => $id])
                ->get('user');

            if ( isset($user->result_array()[0]) ) {
                return $this->load->view('manager/u', [
                    'username' => $user->result_array()[0]['name']
                ]);
            }
        }

        redirect('manager/login');
    }
}