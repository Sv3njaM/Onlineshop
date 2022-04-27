<!--The Programming to show the products on the cart, starting when called
in the routes.php-->
<?php
$cartItems = getCartItemsForUserId($userId);
$cartSum = getCartSumForUserid($userId);
$productId = "";
$quantity = 0;
$error = "";

if(isPost()){  
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $data = getCartDataForProductId($productId, $userId);
    
    $oldQuantity = $data['quantity'];
    
    if($quantity == 0){
        $complete = deleteProductInCart($productId, $userId);
    } 
    if($quantity > 0){
        $complete = changeQuantityInCart($productId, $userId, $quantity);
    }
    
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
