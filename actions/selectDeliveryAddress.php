<?php
$headline = "Address Area";
redirectIfNotLoggedIn('/selectDeliveryAddress');
  /*if(!isLoggedIn()){
    $_SESSION['redirectTarget'] = $baseUrl.'index.php/checkout';
    header("Location: ".$baseUrl."index.php/login");
    exit();
  }*/
  $routeParts = explode('/',$route);
  $deliveryAddressId = (int)$routeParts[2];
  if(deliveryAddressBelongToUser($deliveryAddressId, $userId)){
    $_SESSION['deliveryAddressId'] = $deliveryAddressId;
    header("Location: ".$baseUrl."index.php/confirmOrder");
    exit();

  }
  header("Location: ".$baseUrl."index.php/checkout");