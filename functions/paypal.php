<?php
/*Paypal functions not in use. Will be integrated later when payment is going to be added*/
function getAccessToken():string{

  if(isset($_SESSION['paypalAccessToken']) &&
      isset($_SESSION['paypalAccessTokenExpires']) &&
      $_SESSION['paypalAccessTokenExpires'] > time()){
        return $_SESSION['paypalAccessToken'];
      }

  require_once CONFIG_DIR.'/paypal.php';
  $curl = curl_init();
  $options = [
      //CURLOPT_RETURNTRANSFER need to be true to get a result back
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => PAYPAL_BASE_URL.'/v1/oauth2/token',
      CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Accept-Language: en_US'
            ],
      CURLOPT_USERPWD => PAYPAL_CLIENT_ID.':'.PAYPAL_SECRET,
      //CURLOP_POST need to be activated to use CURLOPT_POSTFIELDS
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => 'grant_type=client_credentials'
  ];

  curl_setopt_array($curl, $options);
  //save response from curl_exec in variable
  $result = curl_exec($curl);
  if(curl_errno($curl)){
    echo curl_error($curl);
    curl_close($curl);

    return "";
  }
  curl_close($curl);
  //return in json have to be changed into an array with json_decode
  //the true is needed for the array
  //json_decode change json data around in an array
  $data = json_decode($result, true);
  $accessToken = $data['access_token'];
  $_SESSION['paypalAccessToken'] = $accessToken;
  $_SESSION['paypalAccessTokenExpires'] = time()+$data['expires_in'];
  return $accessToken;

}

function getMoneyObject(string $value, string $currencyCode = "EUR"):stdClass{
    $object = new stdClass();
    $object->value = number_format($value,2);
    $object->currency_code = $currencyCode;
    return $object;
  }
  
  function productToPayPalItem(array$product):stdClass{
    $item = new stdClass();
    $item->name = $product['title'];
    $price = $product['price'];
    $tax = $price * 0.19;
    $netPrice = ($price - $tax);
  
    $item->unit_amount = getMoneyObject($netPrice/100);
    //$item->unit_amount->currency_code = "EUR";
    //$item->unit_amount->value = number_format($netPrice['price']/100,2);
    //$item->tax = new stdClass();
    $item->tax = getMoneyObject($tax/100);
    //$item->tax->currency_code = "EUR";
    //$item->tax->value = number_format($tax['price']*0.19/100,2);
    $item->quantity = $product['quantity'];
    $item->category = 'PHYSICAL_GOODS';
    $item->description = $product['description'];
  
    return $item;
  }
  
  
  
  function PaypalCreateOrder( array $deliveryAddressData, array $products){
    require_once CONFIG_DIR.'/paypal.php';
    $accessToken = getAccessToken();
    //paypal expects an object with the informations for json
    //stdClass creates a new object
  
  
  
    $payer = new stdClass();
    $payer->name = new stdClass();
    $payer->name->given_name = $deliveryAddressData['recipient'];
    $payer->address = new stdClass();
    $payer->address->address_line_1 = $deliveryAddressData['street'] . " " . $deliveryAddressData['streetNr'];
    $payer->address->admin_area_2 = $deliveryAddressData['city'];
    $payer->address->postal_code = $deliveryAddressData['zipCode'];
    $payer->address->admin_area_1 = $deliveryAddressData['country'];
    $payer->address->country_code = $deliveryAddressData['countryCode'];
  
    $object = new stdClass();
  
  
    $object->items = [];
    $totalValue = 0;
    $itemsTotal = 0;
    $taxTotal = 0;
    foreach($products as $product){
      $item = productToPayPalItem($product);
      $object->items[]= $item;
      $itemsTotal += $item->unit_amount->value * (int)$product['quantity'];
      $taxTotal += $item->tax->value * (int)$product['quantity'];
      $totalValue += (int)$product['price'] * (int)$product['quantity'];
    }
    $totalValue = $totalValue / 100;
    $amountObject = getMoneyObject($totalValue);
    //$amountObject = new stdClass();
    //$amountObject->currency_code = "EUR";
    //$amountObject->value = number_format($totalValue/100,2);
  
    $amountObject->breakdown = new stdClass();
  
    //$amountObject->breakdown->item_total = new stdClass();
    $amountObject->breakdown->item_total = getMoneyObject($itemsTotal);
    //$amountObject->breakdown->item_total->value = $itemsTotal;
    //$amountObject->breakdown->item_total->currency_code = "EUR";
    //$amountObject->breakdown->tax_total = new stdClass();
    $amountObject->breakdown->tax_total = getMoneyObject($taxTotal);
    //$amountObject->breakdown->tax_total->value = $taxTotal;
    //$amountObject->breakdown->tax_total->currency_code = "EUR";
  
  
    $object->amount=$amountObject;
  
    $object->shipping = new stdClass();
    $object->shipping->address = $payer->address;
    $applicationContext = new stdClass();
    $applicationContext->shipping_preference="SET_PROVIDED_ADDRESS";
    $applicationContext->return_url = "http://localhost/shop/index.php/paymentComplete";
    $applicationContext->cancel_url = "http://localhost/shop/index.php/cart";
  
    $data = [
      "payer"=>$payer,
      "application_context"=>$applicationContext,
      "intent"=>"CAPTURE",
      "purchase_units"=>[
        $object
      ]
    ];
  
    //return;
    //change the data into json
    $dataString = json_encode($data);
  
    //return;
  
    $curl = curl_init();
    $options = [
        //CURLOPT_RETURNTRANSFER need to be true to get a result back
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => PAYPAL_BASE_URL.'/v2/checkout/orders',
        CURLOPT_HTTPHEADER => [
                  'Content-Type: application/json',
                  'Authorization: Bearer '.$accessToken
              ],
  
        //CURLOP_POST need to be activated to use CURLOPT_POSTFIELDS
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $dataString
    ];
  
    curl_setopt_array($curl, $options);
    //save response from curl_exec in variable
    $result = curl_exec($curl);
    if(curl_errno($curl)){
      echo curl_error($curl);
      curl_close($curl);
  
      return "";
    }
    curl_close($curl);
    $data = json_decode($result, true);
  
    if($data['status'] !== "CREATED"){
      return "";
    }
  
    setPayPalOrderId($data['id']);
  
    $url = "";
    foreach($data['links'] as $link){
      if($link['rel'] !== "approve"){
        continue;
      }
      $url = $link['href'];
    }
    //echo $url;
  
    header("Location: ".$url);
  }
  //void for no return, function is just setting a string
  function setPayPalOrderId(string $payPalOrderId):void{
    $_SESSION['payPalOrderId'] = $payPalOrderId;
  }
  
  function getPayPalOrderId():?string{
    return isset($_SESSION['payPalOrderId'])?$_SESSION['payPalOrderId']:null;
  }
  
  function setPayPalRequestId(string $payPalRequestId):void{
    $_SESSION['payPalRequestId'] = $payPalRequestId;
  }
  
  function getPayPalRequestId():?string{
    return isset($_SESSION['payPalRequestId'])?$_SESSION['payPalRequestId']:null;
  }
  
  function capturePayment(string $accessToken, string $orderId, string $token){
    require_once CONFIG_DIR.'/paypal.php';
    $data = new stdClass();
  
    $data->payment_source = new stdClass();
    $data->payment_source->token = new stdClass();
    $data->payment_source->token->id = $token;
    $data->payment_source->token->type = "BILLING_AGREEMENT";
    $dataString = json_encode($data);
  
    $curl = curl_init();
    $options = [
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_URL=>PAYPAL_BASE_URL.'/v2/checkout/orders/'.$orderId.'/capture',
          CURLOPT_HTTPHEADER => [
              'Content-Type: application/json',
              'Authorization: Bearer '.$accessToken
              //'PayPal-Request_Id: '.$payPalRequestId
          ],
          CURLOPT_POST=>true,
          CURLOPT_POSTFIELDS=>$dataString
    ];
    curl_setopt_array($curl, $options);
    $result = curl_exec($curl);
    if(curl_errno($curl)){
      echo curl_error($curl);
      curl_close($curl);
  
      return '';
    }
    curl_close($curl);
    $data = json_decode($result, true);
    
  }
  
  /*
  function CreatePayPalOrder(array $deliveryAddressData, array $cartProducts){
    $accessToken = getAccessToken();
    createOrder($accessToken, $deliveryAddressData, $cartProducts);
  }*/
  
  function paypalPaymentComplete($token){
    $accessToken = getAccessToken();
    $payPalOrderId = getPayPalOrderId();
    $payPalRequestId = getPayPalRequestId();
    //$token = filter_input(INPUT_GET,'token', FILTER_SANITIZE_STRING);
    //$payerId = filter_input(INPUT_GET,'PayerID', FILTER_SANITIZE_STRING);
    if($accessToken && $payPalOrderId && $token ){
      capturePayment($accessToken, $payPalOrderId, $token);
    }
  }
  
  function paymentInAdvanceCreateOrder(){
    //To do;
    header("Location: ".BASE_URL."index.php/paymentComplete");
  }
  
  function paymentInAdvancePaymentComplete(){
  
  }
  