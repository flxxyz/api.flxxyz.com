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

    }

    /**
     * 登陆
     */
    public function login ()
    {

    }

    /**
     * 登陆验证
     */
    public function loginc ()
    {

    }

    /**
     * 密码验证
     * @param $name
     * @param $pwd
     * @return bool
     */
    protected function check ($name, $pwd)
    {

    }

    /**
     * 注销
     */
    public function logout ()
    {

    }

    /**
     * 用户信息
     * @param $name
     * @return mixed
     */
    protected function userinfo ($name)
    {

    }

    /**
     * 用户中心
     * @param string $id
     * @return mixed
     */
    public function u ($id = '')
    {

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

    public function a() {
        $this->session->state = 0;
        $this->session->unset_userdata('token');
    }
}