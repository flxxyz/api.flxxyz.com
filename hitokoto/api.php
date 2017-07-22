<?php

require_once dirname(__DIR__).'/function.php';

$encode = isset($_GET['encode'])?$_GET['encode']:'';
hitokoto($encode);





// $id = 1;
// $hitokoto = "123";
// $cat = "p";
// $catname = "来自";
// $author = "FLX";
// $source = "aaa";
// $time = time();

// $tmpArray = array(
//     'id' => "$id",
//     'hitokoto' => "$hitokoto",
//     'cat' => "$cat",
//     'catname' => "$catname",
//     'author' => "$author",
//     'source' => "$source",
//     'date' => "$time"
// );

// foreach($array as $k1 => $v1) {
//     foreach ($v1 as $k2 => $v2) {
//         //if($k2 == $id)
//         echo "$k2 ---- $v2<br>";
//     }
//     echo "<br>";
// }

?>