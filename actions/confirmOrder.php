<?php
redirectIfNotLoggedIn('/checkout');
$errors = [];
/*
  if(!isset($_SESSION['paymentMethod'])){
    //header("Location: ".$baseUrl."index.php/selectPayment");
    header("Location: ".$baseUrl."index.php/checkout");
    exit();
  }*/
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  
  $deliveryAddresses = getAllDeliveryAddressesForUser($userId);
  $deliveryAddressId = $_SESSION['deliveryAddressId'];
  $deliveryAddress = getDeliveryAddressForUser($userId, 0);

  if(isPost()){
    $deliveryAddressData = getDeliveryAddressForUser(getCurrentUserId(), $_SESSION['deliveryAddressId']);
    if(!$deliveryAddressData){
      $errors[] = "Delivery Address not found";
    }
    $cartProducts = getCartItemsForUserId(getCurrentUserId());
    if(count($cartProducts) === 0 ){
      $errors[] = "No items in basket";
    }
    if(count($errors) === 0){
      $created = createUserOrderInDB($userId, $paymentMethod, $cartItems, $deliveryAddressData);
      if($created){
        require TEMPLATES_DIR.'/thankYouPage.php';
        exit();
      }
      if(!$created){
        $errors[] = "A problem appeared, order not saved";
      }
      var_dump($created);
    }
    $hasErrors = count($errors) > 0;
  }
  
  require TEMPLATES_DIR.'/confirmOrder.php';
    //require TEMPLATES_DIR.'/thankYouPage.php';
    //exit();
//}