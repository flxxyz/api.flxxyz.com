<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller
{
    /**
     * 首页
     */
    public function index()
    {
        if ( isset($this->session->is_login) ) {
            $this->session->unset_userdata('message');
            redirect('manager/u/' . $this->session->username);
        } else {
            redirect('manager/login');
        }
    }

    /**
     * 登陆
     */
    public function login()
    {
        $script = '';

        // 处理登陆提示消息
        if ( isset($this->session->is_login) ) {
            if ( !$this->session->is_login ) {
                $this->session->unset_userdata('message');
            }
        }

        // 验证通过
        if ( isset($this->session->is_login) ) {
            if ( $this->session->is_login === 2 ) {
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
            'username' => $this->session->username,
            'script' => $script,
        ]);
    }

    /**
     * 登陆验证
     */
    public function loginc()
    {
        // 处理xss攻击
        $name = xss_clean(get('username'));
        $pwd = xss_clean(get('password'));

        if ( $name ) {
            if ( $this->check($name, $pwd) ) {
                $this->session->is_login = 2;
            }
        } else {
            $this->session->is_login = 1;
        }

        redirect('manager/login');
    }

    /**
     * 注销
     */
    public function logout()
    {
        if ( isset($this->session->is_login) ) {
            if ( $this->session->is_login == 2 ) {
                // 清空当前登陆会话
                $this->session->unset_userdata('url');
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('is_login');
                $url = base_url('manager/login');
                exit("注销成功<script>setTimeout(function() {window.location.href = '$url';}, 2000);</script>");
            }
        }

        redirect('manager/login');
    }

    /**
     * 用户信息
     * @param $name
     *
     * @return mixed
     */
    protected function userinfo($name)
    {
        $userinfo = $this->db->select(['id', 'name', 'password', 'email'])
            ->where(['name' => $name])
            ->get('user');
        if ( isset($userinfo->result_array()[0]) ) {
            return $userinfo->result_array()[0];
        } else {
            $this->session->is_login = 1;
            $this->session->message = '用户不存在';
            redirect('manager/login');
        }
    }

    /**
     * 密码验证
     * @param $name
     * @param $pwd
     *
     * @return bool
     */
    protected function check($name, $pwd)
    {
        $user = $this->userinfo($name);

        if ( hash('sha256', $pwd) !== $user['password'] ) {
            $this->session->is_login = 1;
            $this->session->message = '用户名或密码错误';
            redirect('manager/login');
        }

        $this->session->username = $user['name'];
        $this->session->id = '18000' . $user['id'];
        $this->session->url = site_url('manager/u/') . $this->session->id;
        $this->session->message = '登陆成功, <span id="time">3</span>秒后跳转';
        return true;
    }

    /**
     * 用户中心
     * @param string $id
     *
     * @return mixed
     */
    public function u($id = '')
    {
        if ( !isset($this->session->is_login) ) {
            if(is_null($this->session->is_login)) {
                $this->session->message = '登陆超时，请重新登陆';
                redirect('manager/login');
            }

            if($this->session->is_login !== 2) {
                redirect('manager/login');
            }
        }

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