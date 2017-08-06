<?php

class Api extends CI_Controller
{
    protected $api;
    protected $apiKey = '';
    protected $secretKey = '';

    public function __construct()
    {
        //$pdo = new PDO('dsn', 'user', 'pwd', 'option');
        $this->apiKey = '';
        $this->secretKey = '';
        $this->api = new CloudXNS\Api();
        $this->api->setApiKey($this->apiKey);
        $this->api->setSecretKey($this->secretKey);
        $this->api->setProtocol(true);
    }

    public function domain($param = 'list')
    {
        //header('Content-type: application/json');

        switch ($param) {
            case 'add':
                echo $this->domainAdd();
                break;
            case 'del':
                $this->domainDel();
                break;
            default:
                echo $this->domainList();
                break;
        }
        //$domainResult= $this->handle();
        //var_dump($domainResult);
    }

    protected function domainList()
    {
        $result = $this->handleListData();
        return json_encode($result);
        //return ($result);
        //var_dump(empty(''));
    }

    protected function domainAdd()
    {

    }

    protected function domainDel()
    {

    }

    protected function handleListData()
    {
        $result = json_decode($this->api->domain->domainList());
        $data = [];
        foreach ( $result->data as $k => $v ) {
            $data[$k][] = $v->id;
            $data[$k][] = $v->domain;
            $data[$k][] = $this->status($v->status);
            $data[$k][] = $this->take_over_status($v->take_over_status);
            $data[$k][] = $v->level;
            $datetime = new DateTime($v->create_time, new DateTimeZone('PRC'));
            $data[$k][] = $this->time_null($datetime->format('Y-m-d H:i:s'));
            $data[$k][] = $this->time_null($v->update_time);
            $data[$k][] = $v->ttl;
        }

        return $data;
    }

    protected function status($state)
    {
        switch ($state) {
            case "ok":
                return '域名正常使用';
                break;
            case "userlock":
                return '用户锁定中';
                break;
            default:
                return '域名异常';
                break;
        }
    }

    protected function take_over_status($state)
    {
        switch ($state) {
            case "Untaken over":
                return '未接管';
                break;
            case "Taken over":
                return '已接管';
                break;
            default:
                return '接管异常';
                break;
        }
    }

    protected function time_null($time) {
        if(empty($time)) {
            return date('Y-m-d H:i:s');
        }

        return $time;
    }

    protected function request($api)
    {
        $domainJson = $api->domain->domainList();
        $result = json_decode($domainJson);
//        $domain['code'] = $result->code;
//        $domain['total'] = $result->total;
//        $domain['message'] = $result->message;
//        $domain['data'] = $result->data;

        return $result;
    }

    public function __destruct()
    {
        $this->dbh = null;
    }

}