<?php

redirectIfNotLoggedIn('/checkout');
  //redirectIfNotLoggedIn('/login');

  $recipient = "";
  $city = "";
  $street = "";
  $streetNr = "";
  $zipCode = "";
  $country = "";
  $countryCode = "";
  $recipientIsValid = true;
  $cityIsValid = true;
  $streetIsValid = true;
  $streetNrIsValid = true;
  $zipCodeIsValid = true;
  $countryIsValid = true;
  $countryCodeIsValid = true;
  //$isPost = isPost();
  $errors = [];
  $hasErrors = count($errors) > 0;
  $deliveryAddresses = getAllDeliveryAddressesForUser($userId);

  require TEMPLATES_DIR.'/selectDeliveryAddress.php';
  