<?php

require_once dirname(__DIR__).'/function.php';

$type   = isset($_GET['t'])&&(@ $_GET['t'] != '')?$_GET['t']:'url';
$day    = isset($_GET['d'])&&(@ $_GET['d'] != '')?$_GET['d']:'1';
$encode = isset($_GET['encode'])&&(@ $_GET['encode'] != '')?$_GET['encode']:'json';
initBing($type ,$day ,$encode );