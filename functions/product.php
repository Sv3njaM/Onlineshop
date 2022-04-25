<!--All functions wich are needed for the productcs like get information, delete, change or create
 a product and so on-->

 <?php
//get all products from the DB
function getAllProducts(){
  $sql = "SELECT id,title,description,price,slug,product_status
          FROM products";
  $result = getDB()->query($sql);
  If(!$result){
    return [];
  }
  $products = [];
  while($row = $result->fetch()){
    $products[] = $row;
  }
  return $products;
}