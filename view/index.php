<?php

require_once dirname(__DIR__).'/function.php';




$arr = array(
    'startdate' => '123',
    'enddate'   => '456',
    'imageurl'  => '789',
    'copyright' => array(
        'abc' => '321',
        'def' => '654'
        )
    );

$keys1 = array_keys($arr);
$str = '<?xml version="1.0" encoding="utf-8"?><data>';
$m = 0;
foreach($keys1 as $v1) {
    if( is_array($arr[$v1]) ) {
        $keys2 = array_keys($arr[$v1]);
        $str .= "<$v1>";
        foreach($keys2 as $v2) {
            //$str .= "<$v2>$arr[$v1][$v2]</$v2>";
            $str .= "<$v2>" . $arr[$v1][$v2] . "</$v2>";
        }
        $str .= "</$keys1[$m]>";
    }else
        $str .= "<$v1>$arr[$v1]</$v1>";
    $m++;
}
$str .= '</data>';

header("content-type:application/xml;charset:utf-8;");
echo $str;
