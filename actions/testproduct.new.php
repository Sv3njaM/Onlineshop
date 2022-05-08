<?php
echo "Page for new product";
$productName = "";
$slug = "";
$description = "";
$price = 0;
$errors = [];
$hasErrors = false;
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
//blocked Slugs are reserved words wich cant be used
$blockedSlugs = ['new','delete','details','edit'];

if(isPost()){
    $productName = filter_input(INPUT_POST,'productName',FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = filter_input(INPUT_POST,'slug',FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST,'description',FILTER_SANITIZE_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST,'price');
  
    //check if the required informations are set
    if((bool)$productName === false){
      $errors[] = "Please insert a product name";
    }
    
    if((bool)$productName === true && (bool)$slug === false){
      //the slug is created out of the product name if not available and
      //get - instead of space between the words created as array so it can be expanded
      $slug = str_replace([' ','/'],['-','-'],$productName);
    }
    
    if((bool)$slug === true){
      //check with function getProductBySlug if the slug already exists in DB
      $product = getProductBySlug($slug);
      if($product !== null){
        $errors[] = "Slug already exist, please chose another one";
      }
    }
    
    //the array with blocked slugs includes slugs with reserved words wich cant be used
    if(in_array($slug, $blockedSlugs)){
      $errors[] = "Slug is reserved, please choose another one";
    }
    //description need to be available
    if((bool)$description){
      $errors[] = "Please insert a description";
    }
  
    //price need to be available
    if($price <= 0){
          $errors[] = "Please insert a price";
    }

  }//end isPost
  
  $hasErrors = count($errors) > 0;
  
  if($hasErrors === false){
      $created = createNewProduct($productName, $slug, $description, $price);
    if($created === false){
      $errors[] = "Product have not been created";
      $hasErrors = true;
    }
    if($created === true){
        flashMessage('Product successfully created');
      //header("Location: ".BASE_URL."index.php/product/new");
      //header("Location: ".BASE_URL."index.php/product");
    }
    
  }
  var_dump(BASE_URL."index.php/product/new");
require_once TEMPLATES_DIR.'/productNew.php';