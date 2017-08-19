<?php
/**
 * Created by PhpStorm.
 * User: fff
 * Date: 2017/8/17
 * Time: 18:09
 */

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Qr extends CI_Controller
{
    public $info = [
        'code' => 100,
        'status' => '',
        'message' => '',
        'result' => []
    ];

    public function index()
    {
        $qr = new QrCode('4');
        $this->monitor('qrcode');
        $result = $this->db->select('id, name, value')
            ->get('qrcode');
        var_dump($result->result());
        //header('Content-Type: ' . $qr->getContentType());
        //echo $qr->writeString();
    }

    public function api($param = '')
    {
        echo $param;
    }

    /**
     * @param string $parem
     */
    public function image($param = '') {
        $query = $this->db->where('name', $param)
            ->or_where('nick', $param)
            ->get('qrcode');
        if($query->result_id->num_rows > 0) {
            $value = $query->result()[0]
                ->value;
            $text = $value;
        }else {
            $text = '对不起, 你查找的二维码 tan°90';
        }

        $size = get('s') ? get('s') - 20 : 180;

//        $config = [
//            'method' => 'aes-256-cfb',
//            'pass' => '12345678',
//            'host' => '127.0.0.1',
//            'port' => '31313'
//        ];
//        $ss = 'ss://' . base64_encode("{$config['method']}:{$config['pass']}@{$config['host']}:{$config['port']}");

//        $qr = new QrCode($text);
//        $qr->setWriterByName('png');
//        $qr->setSize($size)
//            ->setEncoding('utf-8')
//            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
//            //->setLogoPath(__DIR__ . '/../../static/img/23333.160.gif')
//            //->setLogoWidth(intval($qr->getSize() / 6))
//            //->setValidateResult(false);
//
//        header('Content-Type: ' . $qr->getContentType());
//        echo $qr->writeString();
    }

    public function get() {
        $content = get('c') ? get('c') : '';

        if(empty($content)) {
            exit($this->message(100, 'error', '参数不正确'));
        }

        // 简单过滤字符串
        $value = htmlspecialchars($content, ENT_QUOTES);

        $this->db->where('value', $value);
        $query = $this->db->get('qrcode');
        if($query->result_id->num_rows > 0) {
            var_dump($query);
            $result = $query->result();
            $value = $result[0]->value;
            $text = $value;
        }else {
            $text = '对不起, 你查找的二维码 tan°90';
        }
        echo $text;

    }

    public function message($code = 0, $status = '', $message = '', $result = []) {
        return json_encode([
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'result' => $result
        ]);
    }
}