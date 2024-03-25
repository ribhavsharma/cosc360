<?php
// session_start();

require __DIR__ . "/../core/init.php";

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode('/', $url);

$page_name = trim($url[0]);
$filename = "../pages/".$page_name.".php";

$PAGE = get_paginations();

if(file_exists($filename)){
    require_once __DIR__ . '/' . $filename;
}else{
    require_once __DIR__ . "/../pages/404.php";
}

?>
