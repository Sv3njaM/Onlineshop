<!--The Programming to show the products on the cart, starting when called
in the routes.php-->
<?php
$cartItems = getCartItemsForUserId($userId);
//var_dump($cartItems);
$cartSum = getCartSumForUserid($userId);
$productId = "";
$quantity = 0;
$error = "";
$isPost = isPost();

if(isPost()){  
    logData('Info', "RETRY");
    logData('Info', "in isPost part");
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $data = getCartDataForProductId($productId, $userId);
    
    $oldQuantity = $data['quantity'];
    logData('Info', "Quantity = ".$quantity." and OldQuantity = ".$oldQuantity);
    if($quantity == 0){
        $complete = deleteProductInCart($productId, $userId);
        logData('Info', "after delete funtion: complete = ".$complete);
    } 
    if($quantity > 0){
        $complete = changeQuantityInCart($productId, $userId, $quantity);
        logData("Info", "QuantityChange complete = ".$complete);
    }
    
    /*if($quantity === 0){
        $complete = deleteProductInCart($productId, $userId);
    }
    if($quantity !== $oldQuantity && $quantity !== 0){
        $complete = changeQuantityInCart($productId, $userId, $quantity);
    }*/

    
    
    //$cartItems = getCartItemsForUserId($userId);
    //if no items in cart left redirect to main page
    $cartQuantity = countItemsInCart($userId);
   
    if($cartQuantity === 0){
        header("Location: ".$baseUrl."index.php");
        exit();
    }  
    
    header("Location: ".$baseUrl."index.php/cart");
    exit();
       

}
 
require TEMPLATES_DIR.'/cartPage.php';
