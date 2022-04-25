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

//get a product slug out of the //DB
function getProductBySlug(string $slug):?array{
  $sql = "SELECT id,title,description,price,slug
          FROM products
          WHERE slug = :slug
          LIMIT 1";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return null;
  }
  $statement->execute([':slug'=>$slug]);
  if($statement->rowCount() === 0){
    return null;
  }
  return $statement->fetch();
}

//insert a new product into DB
function createNewProduct(string $productName, string $slug, string $description, int $price):bool{
  $sql = "INSERT INTO products SET
          title = :productName, slug = :slug, description = :description, price = :price";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  $statement->execute([
        ':productName'=>$productName,
        ':slug'=>$slug,
        ':description'=>$description,
        ':price'=>$price
  ]);
  $lastId = getDB()->lastInsertId();
  return $lastId > 0;
}