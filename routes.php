<?php
//$urlParts gives out 'path' => string '/Testshop/index.php' (length=19)
$urlParts = parse_url($_SERVER['REQUEST_URI']);
//$url C:\xampp\htdocs\Testshop\routes.php:7:string '/Testshop/index.php' (length=19)
$url = $urlParts['path'];

$https = $_SERVER['REQUEST_SCHEME'] === 'https';
//$indexPHPPosition: position where index.php starts
$indexPHPPosition = strpos($url, 'index.php');
//sets the baseUrl to '/Testshop/'
$baseUrl = $url;

if($indexPHPPosition){
  //sets the baseUrl to '/Testshop/'
  $baseUrl = substr($url,0,$indexPHPPosition);
}
//put a / in the end of the baseUrl if missing else the route would be wrong
if(substr($baseUrl, -1) !== '/'){
  $baseUrl .= '/';
}
//define the baseUrl as a const
define('BASE_URL', $baseUrl);
//sets the projectUrl to 'http://localhost/Testshop/'
$projectUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$baseUrl;

//declare the route variable for later navigation
$route = null;
//sets the route to an empty string if indexPHPPosition is set
if($indexPHPPosition){
  $route = substr($url, $indexPHPPosition);
  $route = str_replace('index.php', '', $route);
}

//Standard directory if the route is not set direct to index.php
if(!$route){
    require_once __DIR__.'/actions/index.php';
    exit();
  }