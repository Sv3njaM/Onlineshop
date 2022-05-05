<?php
$isAdmin = isAdmin();
$products = getAllProducts();
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;

var_dump($userName);

require TEMPLATES_DIR.'/main.php';