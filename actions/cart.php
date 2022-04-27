<!--The Programming to show the products on the cart, starting when called
in the routes.php-->
<?php
$cartItems = getCartItemsForUserId($userId);
//var_dump($cartItems);
$cartSum = getCartSumForUserid($userId);
$productId = "";
$quantity = 0;
$error = "";
if(isPost()){  
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $data = getCartDataForProductId($productId, $userId);
    
    $oldQuantity = $data['quantity'];
    if($quantity === 0){
        $complete = deleteProductInCart($productId, $userId);
        $error = "after the delete function";
    }
    //if($quantity !== $oldQuantity && $quantity !== 0){
        //$complete = changeQuantityInCart($productId, $userId, $quantity);
    //}

    
    
    //$cartItems = getCartItemsForUserId($userId);
    //if no items in cart left redirect to main page
    $cartQuantity = countItemsInCart($userId);
   
    if($cartQuantity === 0){
        header("Location: ".$baseUrl."index.php");
        exit();
    }  
    var_dump($error);  
    header("Location: ".$baseUrl."index.php/cart");
    exit();
       

}
//var_dump($productId . $quantity);
require TEMPLATES_DIR.'/cartPage.php';
