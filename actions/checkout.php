<?php

  redirectIfNotLoggedIn('/login');
  $headline = "Confirm your order";
  $deliveryAddressId = 0;
  $routeParts = explode('/',$route);
  //DeliveryAddressId is 0 at start to choose the standard address from DB
  //with change it can be selected from available addresses in DB
  if(count($routeParts) === 3){
    $deliveryAddressId = $routeParts[2];
  }
  
  $_SESSION['deliveryAddressId'] = $deliveryAddressId;
  $userId = getCurrentUserId();
  $deliveryAddress = getDeliveryAddressForUser($userId, $deliveryAddressId);
  $cartItems = getCartItemsForUserId($userId);
  
  $errors = [];
  $hasErrors = count($errors) > 0;

  if(isPost()){
    
    if(!$deliveryAddress){
      $errors[] = "Delivery Address not found";
    }
    $cartProducts = getCartItemsForUserId(getCurrentUserId());
    if(count($cartProducts) === 0 ){
      $errors[] = "No items in basket";
    }
    if(count($errors) === 0){
      
      $created = createUserOrderInDB($userId, $deliveryAddressId, $cartItems);
      if($created){
        require TEMPLATES_DIR.'/thankYouPage.php';
        exit();
      }
      if(!$created){
        $errors[] = "A problem appeared, order not saved";
      }
      
    }
    $hasErrors = count($errors) > 0;
  }
  require TEMPLATES_DIR.'/checkoutOverview.php';
  
    