<?php
$headline = "Product Details";
//gibe out the single parts. In part 3 (Array[2]) is the slug as product name
$routeParts = explode('/', $route);

if(count($routeParts) !== 3){
  echo "URL not existing";
  exit();
}
$slug = $routeParts[2];
if(strlen($slug) === 0){
  echo "Product dont exist";
  exit();
}
$product = getProductBySlug($slug);
if($product === null){
  echo "Product dont exist";
  exit();
}

//bind in the productDetails Template so it is going to be shown
require_once TEMPLATES_DIR.'/productDetails.php';
