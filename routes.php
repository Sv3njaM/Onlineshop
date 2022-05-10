<?php
/*routes.php navigate through the files depends on the value of $routes */
$urlParts = parse_url($_SERVER['REQUEST_URI']);

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
$userId = getCurrentUserId();
$userName = "Guest";
if(isLoggedIn()){
  $userName = getUserName($userId);
}

$countCartItems = countItemsInCart($userId);
$cartSum = getCartSumForUserId($userId);
//Standard directory if the route is not set direct to index.php
if(!$route){
    require_once __DIR__.'/actions/index.php';
    exit();
  }

if(strpos($route,'/cart/add') !== false){
  require_once __DIR__.'/actions/cart.add.php';
  
  exit();
}
if(strpos($route, '/cart') !== false){
  require_once __DIR__.'/actions/cart.php';
  exit();
}
//Directory for the Login
if(strpos($route,'/login') !== false){
  require_once __DIR__.'/actions/login.php';

  exit();
}

//Directory for the Logout
if(strpos($route,'/logout') !== false){
  require_once __DIR__.'/actions/logout.php';
  exit();
}

if(strpos($route,'/checkout') !== false){
  require_once __DIR__.'/actions/checkout.php';
  exit();
}

if(strpos($route,'/selectDeliveryAddress') !== false){
  require_once __DIR__.'/actions/selectDeliveryAddress.php';
  exit();
}

if(strpos($route,'/deliveryAddress/add') !== false){
  require_once __DIR__.'/actions/deliveryAddress.add.php';
  exit();
}
//Directory for the Logout
if(strpos($route,'/registration') !== false){
  require_once __DIR__.'/actions/registration.php';
  exit();
}

//Directory for adding a new product
if(strpos($route,'/product/new') !== false){
  require_once __DIR__.'/actions/product.new.php';
  exit();
}

//Directory to edit an existing product
if(strpos($route,'/product/edit') !== false){
    require_once __DIR__.'/actions/product.edit.php';
    exit();
  }
  
if(strpos($route,'/product') !== false){
   require_once __DIR__.'/actions/product.php';
   exit();
 }