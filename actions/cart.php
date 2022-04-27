<!--The Programming to show the products on the cart, starting when called
in the routes.php-->
<?php
$cartItems = getCartItemsForUserId($userId);
//var_dump($cartItems);
$cartSum = getCartSumForUserid($userId);
$productId = "";
$quantity = 0;
if(isPost()){
    foreach($_POST as $key => $value) 
{
echo $key . " => " . $value;
}  
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $data = getCartDataForProductId($productId, $userId);
    
    $oldQuantity = $data['quantity'];
    var_dump($oldQuantity . $quantity);
    if($oldQuantity === $quantity || $quantity !== 0){
        exit();
    }
    if($quantity !== $oldQuantity || $quantity !== 0){
        //update cart
    }
    if($quantity === 0){
        //delete from cart
    }
    
    
    
    

}
//var_dump($productId . $quantity);
require TEMPLATES_DIR.'/cartPage.php';
