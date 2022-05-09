<?php

redirectIfNotLoggedIn('/deliveryAddress/add');
  $userId = getCurrentUserId();
  $recipient = "";
  $city = "";
  $street = "";
  $streetNr = "";
  $zipCode = "";
  $recipientIsValid = true;
  $cityIsValid = true;
  $streetIsValid = true;
  $streetNrIsValid = true;
  $zipCodeIsValid = true;
  $isPost = isPost();
  $errors = [];
  //$deliveryAddressId = 0;
  $deliveryAddresses = getAllDeliveryAddressesForUser($userId);
  //$hasErrors = false;
  var_dump($userId);
  if($isPost){
    $recipient = filter_input(INPUT_POST,'recipient',FILTER_SANITIZE_SPECIAL_CHARS);
    $recipient = trim($recipient);
    $city = filter_input(INPUT_POST,'city',FILTER_SANITIZE_SPECIAL_CHARS);
    $city = trim($city);
    $street = filter_input(INPUT_POST,'street',FILTER_SANITIZE_SPECIAL_CHARS);
    $street = trim($street);
    $streetNr = filter_input(INPUT_POST,'streetNr',FILTER_SANITIZE_SPECIAL_CHARS);
    $streetNr = trim($streetNr);
    $zipCode = filter_input(INPUT_POST,'zipCode',FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode = trim($zipCode);
    $country = filter_input(INPUT_POST,'country',FILTER_SANITIZE_SPECIAL_CHARS);
    $country = trim($country);
    

    if(!$recipient){
      $errors[] = "Please set a recipient";
      $recipientIsValid = false;
    }
    if(!$city){
      $errors[] = "Please set a city";
      $cityIsValid = false;
    }
    if(!$street){
      $errors[] = "Please set a street";
      $streetIsValid = false;
    }
    if(!$streetNr){
      $errors[] = "Please set a street number";
      $streetNrIsValid = false;
    }
    if(!$zipCode){
      $errors[] = "Please set a zipcode";
      $zipCodeIsValid = false;
    }
    if(!$country){
      $errors[] = "Please set a country";
      $countryIsValid = false;
    }
    
    if(count($errors) === 0){
      $deliveryAddressId = saveDeliveryAddressForUser($userId,$recipient,$city,$zipCode,$street,$streetNr,$country);
      var_dump($deliveryAddressId > 0);
      var_dump($deliveryAddressId);
      if($deliveryAddressId > 0){
        
        $_SESSION['deliveryAddressId'] = $deliveryAddressId;
        
        flashMessage("Your address have been saved");
        header("Location: ".$baseUrl."index.php/checkout");
        exit();
      }
      $errors[]="A problem appeared during saving. Address not saved"; 
    }
  }
  $hasErrors = count($errors) > 0;

  require TEMPLATES_DIR.'/selectDeliveryAddress.php';
  
