<!--The Programming to show the products on the cart, starting when called
in the routes.php-->
<?php
$cartItems = getCartItemsForUserId($userId);
//var_dump($cartItems);
$cartSum = getCartSumForUserid($userId);
$productId = "";
$quantity = 0;
$error = "";
var_dump(isPost());
if(isPost()){  
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $error = "after the post variables";
    $data = getCartDataForProductId($productId, $userId);
    
    $oldQuantity = $data['quantity'];
    $error = "after oldQuantity";
    if($quantity === 0){
        $complete = deleteProductInCart($productId, $userId);
        $error = "after the delete function";
    }
    if($quantity !== $oldQuantity && $quantity !== 0){
        $complete = changeQuantityInCart($productId, $userId, $quantity);
    }

    
    
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
//var_dump($productId . $quantity);
var_dump($quantity);
var_dump($error);  
require TEMPLATES_DIR.'/cartPage.php';
