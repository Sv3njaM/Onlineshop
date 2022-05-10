<!--function/cart.php stores all functions important to run
everything from cart like add a product, get items for a user, the sum of Items
delete and so on-->
<?php
//add a product into the DB in table cart with the userid for showing in basket
//and further order process
function addProductToCart(int $userId, int $productId, int $quantity=1){
  //updates the quantity if product already exists in cart, else create new
  $sql = "INSERT INTO cart
          set quantity = 1, user_id = :userId, product_id = :productId
          ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
  $statement = getDB()->prepare($sql);
  $statement->execute([
        ':userId'=>$userId,
        ':productId'=>$productId,
        ':quantity'=>$quantity
  ]);
}

function getCartItemsForUserId(?int $userId):array{
  if($userId === null){
    return [];
  }
  $sql = "SELECT product_id,products.title,products.description,products.price,products.slug,quantity
          FROM cart
          JOIN products ON (products.id = cart.product_id)
          WHERE user_id = $userId";
  $results = getDB()->query($sql);
  if($results === false){
    return [];
  }
  $found = [];
  while($row = $results->fetch()){
    $found[] = $row;
  }
  return $found;
}

function countItemsInCart(?int $userId):?int{
  if( $userId === null){
    return 0;
  }
  $sql = "SELECT SUM(quantity)
          FROM cart
          WHERE user_id = :userId";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return 0;
  }
  $statement->execute([':userId'=>$userId]);
  $cartItemsSum = $statement->fetchColumn();
  if($cartItemsSum === null){
    $cartItemsSum = 0;
  }
  return $cartItemsSum;
}
// function get the sum for all items in cart
function getCartSumForUserId(?int $userId): int{
  if($userId === null){
    return 0;
  }
  $sql = "SELECT SUM(products.price * cart.quantity)
          FROM cart
          JOIN products ON products.id = cart.product_id
          WHERE user_id = ".$userId;
  $result = getDB()->query($sql);
  if($result === false){
    return 0;
  }
  return (int)$result->fetchColumn();
}

function getCartDataForProductId(int $productId, int $userId):array{
  $sql = "SELECT id, quantity, created 
          FROM cart
          WHERE product_id=:productId
          AND user_id=:userId";
  $statement = getDB()->prepare($sql);
  if(!$statement){
    return [];
  }
  $statement->execute([
        ':productId'=>$productId,
        ':userId'=>$userId
  ]);
  if($statement->rowCount() === 0){
    return [];
  }
  $row = $statement->fetch();
  return $row;

}

function changeQuantityInCart(int $productId, int $userId, int $quantity):bool{
  $sql = "UPDATE cart
          SET quantity = :quantity
          WHERE user_id = :userId 
          AND product_id = :productId";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  $statement->execute([
      ':quantity'=>$quantity,
      ':productId'=>$productId,
      ':userId'=>$userId
  ]);
  $rowCount = $statement->rowCount();
  return (bool)$rowCount > 0;
}
//function for the user to delete single products in cart
function deleteProductInCart(int $productId, int $userId):bool{
 
 $sql = "DELETE FROM cart
          WHERE user_id = :userId 
          AND product_id = :productId";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  $statement->execute([
      ':productId'=>$productId,
      ':userId'=>$userId
  ]);
  $rowCount = $statement->rowCount();
  $return = (bool)$rowCount > 0;
  logData("Info", "return of delete function = ".$return);
  return $return;
}
//function to empty cart fully
function emptyCart(int $userId):bool{
 
  $sql = "DELETE FROM cart
           WHERE user_id = :userId";
   $statement = getDB()->prepare($sql);
   if($statement === false){
     return false;
   }
   $statement->execute([
       ':userId'=>$userId
   ]);
   $rowCount = $statement->rowCount();
   $return = (bool)$rowCount > 0;
   logData("Info", "return of delete function = ".$return);
   return $return;
 }

