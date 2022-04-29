<?php
echo "page confirm Order";
redirectIfNotLoggedIn('/checkout');
/*
  if(!isset($_SESSION['paymentMethod'])){
    //header("Location: ".$baseUrl."index.php/selectPayment");
    header("Location: ".$baseUrl."index.php/checkout");
    exit();
  }*/
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
/*
  $functionName = $_SESSION['paymentMethod'].'PaymentComplete';
  $parameter = [];
  if($_SESSION['paymentMethod'] === 'paypal'){
    $parameter = [
          $_SESSION['paypalOrderToken']
    ];
  }*/

  //call_user_func_array($functionName,$parameter);
  /*if(!isset($_SESSION['deliveryAddressId'])){
    header("Location: ".$baseUrl."index.php/");
    exit();
  }

  $deliveryAddressData = getDeliveryAddressForUser($_SESSION['deliveryAddressId'], $userId);


  $created = createUserOrderInDB($userId,  $cartItems, $deliveryAddressData);

  if($created){
    clearCartForUser($userId);
    $invoiceId = invoiceId();
    $invoiceUrl = $projectUrl.'/invoice/'.$invoiceId;
    createPdfFromUrl($invoiceUrl, STORAGE_DIR.'/invoices/invoice-'.$invoiceId.'.pdf');
    require TEMPLATES_DIR.'/thankYouPage.php';
    exit();
  }
*/
  $deliveryAddressData = getDeliveryAddressForUser($_SESSION['deliveryAddressId'], $userId);
  /*if(createUserOrderInDB($userId,$cartItems,$deliveryAddressData)){
    clearCartForUser($userId);
    $invoiceId = invoiceId();
    $invoiceUrl = $projectUrl.'index.php/invoice/'.$invoiceId;
   */
   
  require TEMPLATES_DIR.'/confirmOrder.php';
    //require TEMPLATES_DIR.'/thankYouPage.php';
    //exit();
//}