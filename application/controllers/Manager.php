<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller
{
    //　state 4种状态
    //　0 初始状态，用户刚进入
    //　1 操作有误
    //　2 用户在线
    //　3 成功登陆

    /**
     * 首页
     */
    public function index ()
    {
        if(isset($this->session->state)) {
            if($this->session->state === 3) {
                redirect('manager/u/' . $this->session->id);
            } else if($this->session->state === 2) {
                $this->session->message = '当前用户在线，是否要继续登陆？';
            }
        }

        redirect('manager/login');
    }

    /**
     * 登陆
     */
    public function login ()
    {
        // 处理登陆提示消息
        if(isset($this->session->state)) {
            if($this->session->state === 0) {
                $this->session->unset_userdata('message');
            }
        }

        $token = get('token');
        $script = '/static/js/manager/success.js';

        if(!($this->session->sess_id !== session_id() and $this->session->state > 1)) {
            if($this->session->state === 2) {
                // 用户在线
                $script = '/static/js/manager/online.js';
                $this->session->message = "当前用户在线，是否要继续登陆？<input type='hidden' class='csf' value='{$this->session->sess_id}'>";

                if($token === $this->session->sess_id) {
                    $this->session->state = 3;
                    $this->session->message = '登陆成功, <span id="time">3</span>秒后跳转';
                    // 登陆成功更新token
                    $this->db->set(['online' => 1, 'token' => session_id()])
                        ->select('online', 'token')
                        ->where(['id' => str_replace('18000', '', $this->session->id)])
                        ->update('user');
                    $script = '/static/js/manager/success.js';
                }else if($token === 'quit') {
                    $this->session->state = 0;
                    $this->session->unset_userdata('message');
                }
            }else if($this->session->state === 3) {
                // 成功登陆
            }
        }

        $this->load->view('Manager/login', [
            'state' => ( $this->session->state < 2 ) ? false : true,
            'message' => $this->session->message,
            'username' => $this->session->username,
            'script' => $script,
            'script_val' => "var url = '{$this->session->url}'",
            'csrf' => [
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
            ],
            ]);
    }

    /**
     * 登陆验证
     */
    public function loginc ()
    {
        // 处理xss攻击
        $name = xss_clean(post('username'));
        $pwd = xss_clean(post('password'));
        $csrf = xss_clean(post('csrf_token_name'));

        if($name) {
            if(1 < $state = $this->check($name, $pwd)) {
                // 用户在线
                if($state === 2) {
                    $this->session->state = 2;
                    redirect('manager/login');
                } else {
                    $this->session->state = 3;
                }
            }
        } else {
            $this->session->state = 1;
            $this->session->message = '请输入用户名或密码';
        }


        redirect('manager/login');
    }

    /**
     * 密码验证
     * @param $name
     * @param $pwd
     * @return bool
     */
    protected function check ($name, $pwd)
    {
        $user = $this->userinfo($name);

        // 效验密码
        if(hash('sha256', "$name:$pwd") !== $user['password']) {
            $this->session->state = 1;
            $this->session->message = '用户名或密码错误';
            return 1;
        }

        // 预设信息
        $this->session->username = $user['name'];
        $this->session->id = '18000' . $user['id'];
        $this->session->sess_id = session_id();
        $this->session->message = '登陆成功, <span id="time">3</span>秒后跳转';
        $this->session->url = site_url('manager/u/') . $this->session->id;

        // 检查在线
        if($user['online']) {
            return 2;
        }

        // 用户不在线更新token
        if(session_id() !== $user['token']) {
            $this->db->set(['online' => 1, 'token' => session_id()])
                ->select('online', 'token')
                ->where(['id' => $user['id']])
                ->update('user');
        }

        return 3;
    }

    /**
     * 注销
     */
    public function logout ()
    {
        if(isset($this->session->state)) {
            $this->db->set(['online' => 0, 'token' => ''])
                ->select('online', 'token')
                ->where(['id' => str_replace('18000', '', $this->session->id)])
                ->update('user');

            // 清空当前登陆会话
            $this->session->unset_userdata('url');
            $this->session->unset_userdata('id');
            $this->session->unset_userdata('sess_id');
            $this->session->unset_userdata('token');
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('message');
            $this->session->state = 0;
            $url = base_url('manager/login');

            if($this->session->state === 3) {
                exit("注销成功<script>setTimeout(function() {window.location.href = '$url';}, 2000);</script>");
            } else if($this->session->state === 2) {
                exit("退出成功<script>setTimeout(function() {window.location.href = '$url';}, 2000);</script>");
            }
        }

        redirect('manager/login');
    }

    /**
     * 用户信息
     * @param $name
     * @return mixed
     */
    protected function userinfo ($name)
    {
        $userinfo = $this->db->select(['id', 'name', 'password', 'email', 'online', 'token'])
            ->where(['name' => $name])
            ->get('user');

        if(isset($userinfo->result_array()[0])) {
            return $userinfo->result_array()[0];
        } else {
            $this->session->state = 1;
            $this->session->message = '用户不存在';
        }

        return [];
    }

    /**
     * 用户中心
     * @param string $id
     * @return mixed
     */
    public function u ($id = '')
    {
        // 重复登陆
        $user = $this->userinfo($this->session->username);
        if(session_id() !== $user['token']) {
            // 当前不等于数据库数据为其它账号登陆
            if($this->session->sess_id !== $user['token']) {
                $this->session->message = '该账号在其它位置登陆';
            }else {
                $this->session->message = '登陆超时，请重新登陆';
                $this->db->set(['online' => 0])
                    ->select('online')
                    ->where(['id' => str_replace('18000', '', $this->session->id)])
                    ->update('user');
            }

            $this->session->state = 1;

            redirect('manager/login');
        }

        $id = xss_clean($id);
        $id = str_replace('18000', '', $id);

        if(is_numeric($id)) {
            $user = $this->db->select(['name'])
                ->where(['id' => $id])
                ->get('user');

            if(isset($user->result_array()[0])) {
                $this->session->state = 3;
                return $this->load->view('manager/u', [
                    'username' => $user->result_array()[0]['name']
                ]);
            }
        }

        redirect('manager');
    }

    public function captcha ()
    {
        $vals = array(
            'img_path'  => FCPATH . 'static/img/captcha/',
            'img_url'   => 'http://api.dev/static/img/captcha/',
            'font_path' => FCPATH . 'system/fonts/texb.ttf',
            'img_width' => 120,
            'img_height'    => 32,
            'expiration'    => 3600,
            'word_length'   => 4,
            'font_size' => 16,
            'img_id'    => 'Imageid',
            'pool'      => '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors'    => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
//        var_dump($cap);
        //echo $cap['image'];
        echo json_encode($cap);
    }
}