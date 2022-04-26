<!--The Programming to show the products on the cart, starting when called
in the routes.php-->
<?php
$cartItems = getCartItemsForUserId($userId);
//var_dump($cartItems);
$cartSum = getCartSumForUserid($userId);
require TEMPLATES_DIR.'/cartPage.php';
