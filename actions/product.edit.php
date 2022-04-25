<!--The Programming to edit an exitsting product, starting when called
in the routes.php-->
<?php
//check if user have admin status to edit a product
//--------------------

$routeParts = explode('/',$route);

if(count($routeParts) !== 4){
  echo "URL dont exist";
  die();
}
$slug = $routeParts[3];
$product = getProductBySlug($slug);
//check if product exists
if($product === null){
  echo "No matching product for ".$slug;
  die();
}
$productName = $product['title'];
$slug = $product['slug'];
$originalSlug = $slug;
$description = $product['description'];
$price = $product['price'];
$id = $product['id'];
$errors = [];
$hasErrors = false;
$flashMessages = flashMessage();
//counts if any flash messages are available
$hasFlashMessages = count($flashMessages) > 0;
//array for slug names wich are not allowed to use
$blockedSlugs = ['new', 'delete', 'details', 'edit'];


if(isPost()){
  $productName = filter_input(INPUT_POST,'productName',FILTER_SANITIZE_SPECIAL_CHARS);
  $slug = filter_input(INPUT_POST,'slug',FILTER_SANITIZE_SPECIAL_CHARS);
  $description = filter_input(INPUT_POST,'description',FILTER_SANITIZE_SPECIAL_CHARS);
  $price = filter_input(INPUT_POST,'price');

  

  if((bool)$productName === false){
      $errors[] = "Please insert product name";
  }

  if((bool)$productName === true && (bool)$slug === false){
      //square braces to fill in more than one sign
      $slug = str_replace([' ','/'], ['-','-'], $productName);
  }

  if((bool)$slug === true && $slug !== $originalSlug){
      $product = getProductBySlug($slug);
      if($product !== null){
          $errors[] = "Slug dont exist";
      }
    }
  

  if(in_array($slug, $blockedSlugs)){
    $errors[] = "Slug is reserved, please choose another slug name!";
  }
  if((bool)$description === false){
    $errors[] = "Please insert a product description!";
  }
  if($price <= 0){
    $errors[] = "Please insert a product price in cent without comma!";
  }
  
  $hasErrors = count($errors) > 0;
  if($hasErrors === false){
    $created = editProduct($id, $productName, $slug, $description, $price);
    $imageUploadSuccessful = false;
    
    if($created === false){
      $errors[] = "Product not processed!";
      $hasErrors = true;
    }
    if($created === true ){
      flashMessage('Product successfully processed!');
      header("Location: ".BASE_URL."index.php/product/edit/".$slug);
    }
  }

}//end if isPost
require_once TEMPLATES_DIR.'/editProduct.php';
