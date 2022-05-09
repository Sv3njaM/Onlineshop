<?php
   //logData("INFO","Start loggin in begin of actions/checkout");
  redirectIfNotLoggedIn('/login');
  
  $headline = "Confirm your order";
  $deliveryAddressId = 0;
  if($_SESSION['deliveryAddressId']){
    $deliveryAddressId = $_SESSION['deliveryAddressId'];
  }
  $userId = getCurrentUserId();
  
  $routeParts = explode('/',$route);
  
  if(count($routeParts) === 3){
    $deliveryAddressId = $routeParts[2];
    $_SESSION['deliveryAddressId'] = $deliveryAddressId;
    //logData("INFO","from routeParts sessionid: ".$_SESSION['deliveryAddressId']);
  }
  $deliveryAddress = getDeliveryAddressForUser($userId, $deliveryAddressId);
  if($deliveryAddressId === 0 AND !$_SESSION['deliveryAddressId']){
    $deliveryAddressId = $deliveryAddress['id'];
    $_SESSION['deliveryAddressId'] = $deliveryAddressId;
    //logData("INFO","after function getDeliveryAddress sessionid: ".$_SESSION['deliveryAddressId']);
  }
  
  $cartItems = getCartItemsForUserId($userId);
  $errors = [];
  $hasErrors = count($errors) > 0;
  //logData("INFO","Start logging BEVOR POST order AddressId: ".$deliveryAddressId."----------------sessionid: ".$_SESSION['deliveryAddressId']);
  if(isPost()){
    //logData("INFO","Start logging AFTER POST order AddressId: ".$deliveryAddressId."----------------sessionid: ".$_SESSION['deliveryAddressId']);
    if(!$deliveryAddress){
      $errors[] = "Delivery Address not found";
    }
    $cartProducts = getCartItemsForUserId(getCurrentUserId());
    if(count($cartProducts) === 0 ){
      $errors[] = "No items in basket";
    }
    if(count($errors) === 0){
      //logData("INFO","Start logging BEVOR FUNCTION order AddressId: ".$deliveryAddressId."----------------");
      $created = createUserOrderInDB($userId, $deliveryAddressId, $cartItems);
      //logData("INFO","Start logging AFTER FUNCTION order AddressId: ".$deliveryAddressId."----------------");
      if($created){
        emptyCart($userId);
        require TEMPLATES_DIR.'/thankYouPage.php';
        exit();
      }
      if(!$created){
        $errors[] = "A problem appeared, order not saved";
      }
      
    }
    $hasErrors = count($errors) > 0;
  }
  $countCartItems = countItemsInCart($userId);
  require TEMPLATES_DIR.'/checkoutOverview.php';
  
    