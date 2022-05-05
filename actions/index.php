<?php
$isAdmin = isAdmin();
$products = getAllProducts();
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
logData('INFO','Startpage have been called',[
    'actuellUserId'=>$userId,
    'productList'=>$products
]);


require TEMPLATES_DIR.'/main.php';