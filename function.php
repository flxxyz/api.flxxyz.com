<?php

/*  公用函数  */
function getNetData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
    ob_start();
    $return_content = ob_get_contents();
    $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    $result = curl_exec($ch);
    ob_end_clean();
    curl_close($ch);
    if($code != '404' && $result)
        return $result;
    else
        return false;
}

//获取客户端IP
function getClientIp() {
    if( getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown") )
        $ip = getenv("HTTP_CLIENT_IP");
    else if( getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown") )
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if( getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown") )
                $ip = getenv("REMOTE_ADDR");
            else if( isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown") )$ip = $_SERVER['REMOTE_ADDR'];
                else
                    $ip = "unknown";
    return $ip;
}

//返回数据结构
function dataStructure($data ,$encode = 'json' ) {
    if($encode == 'xml') {
        $keys1 = array_keys($data);

        $str = '<?xml version="1.0" encoding="utf-8"?><data>';
        $m = 0;
        foreach($keys1 as $v1) {
            if( is_array($data[$v1]) ) {
                $keys2 = array_keys($data[$v1]);
                $str .= "<$v1>";
                foreach($keys2 as $v2) {
                    $str .= "<$v2>" . $data[$v1][$v2] . "</$v2>";
                }
                $str .= "</$keys1[$m]>";
            }else
                $str .= "<$v1>$data[$v1]</$v1>";
            $m++;
        }
        $str .= '</data>';

        header("content-type:application/xml;charset:utf-8;");
        return $str;
    }else {
        header("content-type:application/json;charset:utf-8;");
        echo json_encode($data ,JSON_UNESCAPED_UNICODE );
    }
}

//创建数据库连接
function initDB() {
    $con = mysqli_connect('127.0.0.1', 'api_flxxyz', 'ctJRcjSN53', 'api_flxxyz', '3306');
    if(!$con) {
        exit('database connect error');
    }
    mysqli_set_charset($con ,'utf8mb4' );
    return $con;
}

//记录调用次数
function view($domain ,$name ) {
    $time = @date('Y-m-d H:i:s');
    //$str = "{$time}  {$ip}  {$address}  {$content}\r\n";
    //file_put_contents($filename ,$str ,FILE_APPEND );
    $db = initDB();
    mysqli_close($db);
}

// 产生两位随机数
function token() {
    return mt_rand(1,9).mt_rand(0,9);
}



/*
 *    Bing壁纸相关函数
 */
function bing($id) {
    $url  = "http://cn.bing.com/HPImageArchive.aspx?idx=" . $id . "&n=1";
    $html = file_get_contents($url);

    function getData($re,$html) {
        if(preg_match($re,$html,$matches))
            $url = $matches[1];
        else
            $url = "";
        return $url;
    }
    $array = array(
        'startdate' => getData("/<startdate>(.+?)<\/startdate>/ies" ,$html ),
        'enddate'   => getData("/<enddate>(.+?)<\/enddate>/ies" ,$html ),
        'imageurl'  => 'http://cn.bing.com'.getData("/<url>(.+?)<\/url>/ies" ,$html ),
        'copyright' => getData("/<copyright>(.+?)<\/copyright>/ies" ,$html )
    );
    return $array;
}

function showImage($data) {
    header('Content-Type: image/jpeg');
    @ob_end_clean();
    echo getNetData($data['imageurl']);
    @ob_flush();@flush();
    exit();
}

function toggleType($type) {
    return $type == 'bg' ? true : false ;
}

function initBing($type = 'url' ,$day = '1' ,$encode = 'json') {
    $data = bing($day);
    //var_dump($data);
    if(toggleType($type))
        showImage($data);
    else
        echo dataStructure($data ,$encode );
}



/*
 *   一言相关函数
 */
function hitokoto($encode = 'json') {
    $data  = dirname(__FILE__) . '/hitokoto/data/hitokoto.json';
    $json  = file_get_contents($data);
    $arr = json_decode($json, true);
    $count = count($arr);

    if($count != 0)
        $hitokoto = $arr[array_rand($arr)];
    else
        exit('{"id":"","hitokoto":"","cat":"","catname":"","author":"","source":"","date":""}');

    if($encode === 'xml') {
        $str = <<<EOT
<?xml version="1.0" encoding="utf-8"?>

<data>
  <id>{$hitokoto['id']}</id>
  <hitokoto>{$hitokoto['hitokoto']}</hitokoto>
  <cat>{$hitokoto['cat']}</cat>
  <catname>{$hitokoto['catname']}</catname>
  <author>{$hitokoto['author']}</author>
  <source>{$hitokoto['source']}</source>
  <date>{$hitokoto['date']}</date>
</data>
EOT;
        header("content-type:application/xml;charset:utf-8;");
        exit($str);
    }else if($encode == 'js') {
        header("content-type:charset:utf-8;");
        exit("var hitokoto = function(){document.getElementById('hitokoto').innerHTML='{$hitokoto['hitokoto']}'}");
    }else {
        header("content-type:application/json;charset:utf-8;");
        header("Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8");
        exit(json_encode($hitokoto ,JSON_UNESCAPED_UNICODE ));
    }
}


/**
 *  IP查询相关函数
 */
//启动IP查询
function initIP($ip ,$source = 'baidu' ,$encode = 'json' ) {
    $data = getIP($ip ,$source );
    echo dataStructure($data ,$encode );
}

//获取网络来源查询信息
function getIP($ip ,$source ) {

    if( $source == 'ip.cn' ) {
        $url = "http://www.ip.cn/index.php?ip=".$ip;
        $html = getNetData($url);
        $re = "/<div class=\"well\"><p>您查询的 IP：<code>(.*?)<\/code><\/p><p>所在地理位置：<code>(.*?)<\/code>/";

        if(preg_match_all($re,$html,$matches)) {
            $origip = $matches[1][0];
            $location = $matches[2][0];
        }else {
            $origip = '0.0.0.0';
            $location = "未知IP";
        }
    }else {
        $url = "";
        $html = getNetData($url);
        $obj = json_decode($html);
        $origip   = $obj->data[0]->origip;
        $location = $obj->data[0]->location;
    }
    return array(
            'location'    => $location,
            'origip'      => $origip,
            'origipquery' => $ip,
            'source'      => $source
            );
}