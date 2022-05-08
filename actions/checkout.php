<?php
  redirectIfNotLoggedIn('/login');
  var_dump(isLoggedIn());
  $headline = "Confirm your order";
  $deliveryAddressId = 0;
  $errors = [];
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  $hasErrors = count($errors) > 0;
  $deliveryAddress = [];
  $recipient = "";
  $city = "";
  $street = "";
  $streetNr = "";
  $zipCode = "";
  $country = "";
  /*if($_SESSION['deliveryAddressId']){
    $deliveryAddressId = $_SESSION['deliveryAddressId'];
  }*/
  
  
    $deliveryAddress = getDeliveryAddressForUser($userId);
    $deliveryAddressId = $deliveryAddress['id'];
    $_SESSION['deliveryAddressId'] = $deliveryAddressId;
  
    //$deliveryAddresses = getAllDeliveryAddressesForUser($userId);

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
    