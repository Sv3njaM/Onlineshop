<?php
//redirectIfNotLoggedIn('/checkout');
  $errors = [];
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  
  $deliveryAddresses = getAllDeliveryAddressesForUser($userId);
  $deliveryAddressId = $_SESSION['deliveryAddressId'];
  $deliveryAddress = getDeliveryAddressForUser($userId);
  
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
  require TEMPLATES_DIR.'/confirmOrder.php';
    