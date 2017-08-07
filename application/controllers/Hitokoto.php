<?php

class Hitokoto
{
    public $data, $protocol, $encode;

    public function index()
    {
        $hostname = hostname();
        $script = <<<EOT
  $(function () {
      $('input.url') . focus(function () {
        $(this) . select()
        });
      $('.btn') . click(function () {
          $('input.url') . val($('.protocol') . val() + "://{$hostname}/hitokoto/api?encode=" + $('.version') . val()) . select();
        })
    })
EOT;
        $this->load->view('Layout/header.php');
        $this->load->view('Hitokoto/index.php');
        $this->load->view('Layout/footer.php', ['script' => $script]);
    }

    public function api()
    {
        $file = FCPATH . 'static/hitokoto.json';
        $json = file_get_contents($file);
        $this->data = json_decode($json, true);
        $this->protocol = is_https() ? 'https' : 'http';
        $this->encode = get('encode');

        echo self::init();
    }

    protected function init()
    {
        $data = $this->data;
        if ( count($data) != 0 ) {
            $this->data = $data[array_rand($data)];
        } else {
            exit('{"id":"","hitokoto":"","cat":"","catname":"","author":"","source":"","date":""}');
        }

        return self::encode();
    }

    protected function encode()
    {
        $data = $this->data;

        switch ($this->encode) {
            case 'xml':
                return self::xml();
                break;
            case 'js':
                return self::js();
                break;
            default:
                return self::json();
                break;
        }
    }

    protected function xml()
    {
        $data = $this->data;

        return <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<data>
  <id>{$data['id']}</id>
  <hitokoto>{$data['hitokoto']}</hitokoto>
  <cat>{$data['cat']}</cat>
  <catname>{$data['catname']}</catname>
  <author>{$data['author']}</author>
  <source>{$data['source']}</source>
  <date>{$data['date']}</date>
</data>
EOT;
    }

    protected function js()
    {
        $data = $this->data;

        header("content-type:charset:utf-8;");
        return "var hitokoto = function(){document.getElementById('hitokoto').innerHTML='{$data['hitokoto']}'}";
    }

    protected function json()
    {
        $data = $this->data;

        header("content-type:application/json;charset:utf-8;");
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}