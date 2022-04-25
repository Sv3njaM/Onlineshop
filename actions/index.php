<?php
$isAdmin = isAdmin();
$products = getAllProducts();

logData('INFO','Startpage have been called',[
    'actuellUserId'=>$userId,
    'productList'=>$products
]);

require TEMPLATES_DIR.'/main.php';