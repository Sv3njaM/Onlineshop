<?php

redirectIfNotLoggedIn('/confirmOrder');

  if(!isset($_SESSION['deliveryAddressId'])){
    header("Location: ".$baseUrl."index.php/selectDeliveryAddress");
    exit();
  }

  $errors = [];
  $availablePaymentMethods = [
          "paypal"=>"PayPal"
  ];
  //check if a post request have been send to go on with paypal

  if(isPost()){

    $paymentMethod = filter_input(INPUT_POST,'paymentMethod', FILTER_UNSAFE_RAW);
    $_SESSION['paymentMethod'] = $paymentMethod;
    //check if the paymentMethod have been set
    if(!$paymentMethod){
      $errors[] = "Please choose a payment method";
    }
    //check if the choosen payment Method is valid/protection of typing in own name in radio button
    if($paymentMethod && !in_array($paymentMethod, array_keys($availablePaymentMethods))){
      $errors[] = "Incorrect choice";
    }
    $deliveryAddressData = getDeliveryAddressForUser(getCurrentUserId(), $_SESSION['deliveryAddressId']);
    if(!$deliveryAddressData){
      $errors[] = "Delivery Address not found";
    }
    $cartProducts = getCartItemsForUserId(getCurrentUserId());
    if(count($cartProducts) === 0 ){
      $errors[] = "No items in basket";
    }


    if(count($errors) === 0){
      //part to call the function for the payment
      $functionName = $paymentMethod.'createOrder';

      //$_SESSION['paymentMethod'] = $paymentMethod;

      //call_user_func_array create and call the function depending on the choosen payment
      call_user_func_array($functionName,[$deliveryAddressData, $cartProducts]);
    
    }
  }
  //$hasErrors in routes.php so it can be used in the template selectPayment.php
  $hasErrors = count($errors) > 0;

  require TEMPLATES_DIR.'/confirmOrder.php';