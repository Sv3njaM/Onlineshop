<!--The Programming to add a product to the cart, starting when called
in the routes.php-->
<?php
$routeParts = explode('/',$route);
$productId = (int)$routeParts[3];
//creates '/Testshop/index.php/cart/add/productId'
$_SESSION['redirectTarget'] = $baseUrl."index.php/cart/add/".$productId;
//var_dump($_SESSION['redirectTarget']);
addProductToCart($userId,$productId);
//redirect to start page
header("Location: ".$baseUrl."index.php");
