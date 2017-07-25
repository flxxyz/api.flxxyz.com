<?php

class Api extends CI_Controller
{
    protected $apiKey = '';
    protected $secretKey = '';

    public function __construct()
    {
        $this->apiKey = '2d14279f45191c85f5604911bc50b7e9';
        $this->secretKey = '5b8f72263ce2923d';
    }

    public function domain($param = 'list')
    {
        echo '<pre>';
        switch ($param) {
            case 'add':
                $this->domainAdd();
                break;
            case 'del':
                $this->domainDel();
                break;
            default:
                $this->domainList();
                //$this->ajaxReturn(1, '', $data);
                break;
        }
        //$domainResult= $this->handle();
        //var_dump($domainResult);
    }

    protected function domainList()
    {
        return $this->handle();
    }

    protected function domainAdd()
    {

    }

    protected function domainDel()
    {

    }

    protected function handle()
    {
        $api = new CloudXNS\Api();
        $api->setApiKey($this->apiKey);
        $api->setSecretKey($this->secretKey);
        $api->setProtocol(true);

        $result = $this->request($api);
        $result->data = $this->handleData($result->data);
        return $result;
    }

    protected function handleData($data)
    {
        $domainList = [];

        foreach ( $data as $k1 => $v1 ) {
            $domain = [];
            $id = '';
            foreach ( $v1 as $k2 => $v2 ) {
                /*if($k2 === 'id') {
                    $id = $v2;
                    $domain[$id] = [];
                }else {
                    $domain[$id][$k2] = $v2;
                }*/
                $domain[$k2] = $v2;
            }
            //$domainList;
            array_push($domainList, $domain);
        }
        //var_dump($domainList);

        return $domainList;
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

}