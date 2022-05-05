<?php

redirectIfNotLoggedIn('/checkout');
  if(!isset($_SESSION['paymentMethod'])){
    header("Location: ".$baseUrl."index.php/confirmOrder");
    exit();
  }
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);

  if($_SESSION['paymentMethod'] === 'paypal'){
    //gets the token from the get variable in the search bar
    $_SESSION['paypalOrderToken'] = filter_input(INPUT_GET, 'token', FILTER_UNSAFE_RAW);
  }
  require TEMPLATES_DIR.'/checkoutOverview.php';