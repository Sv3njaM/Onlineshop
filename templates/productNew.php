<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Online Shop</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/css/all.css">
  </head>
  <body>
  <?php include __DIR__.'/navbar.php';?>
<header class="jumbotron">
  <div class="container">
    <h1>Welcome to the Test Shop</h1>
  </div>
</header>
<section id="newProduct" class="container">
  <form action="index.php/product/new" method="post">
    <div class="card">
      <div class="card-header">
        Create New Product
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/flashMessage.php'; ?>
        <?php require_once __DIR__.'/errorMessage.php'; ?>
        <div class="form-group">
          <label for="productName">Product Name</label>
          <input class="form-control" type="text" name="productName" value="" id="productName">
        </div>
        <div class="form-group">
          <label for="slug">Product Slug</label>
          <input class="form-control" type="text" name="slug" value="" id="slug">
        </div>
        <div class="form-group">
          <label for="description">Product Description</label>
          <input class="form-control" type="text" name="description" id="description">
        </div>
        <div class="form-group">
          <label for="price">Product Price</label>
          <input class="form-control" type="number" name="price" value="" id="price">
        </div>
      </div>
      <div class="card-footer">
        <a href="index.php" class="btn btn-danger">Cancel</a>
        <button class="btn btn-success" type="submit" name="button">Save</button>
      </div>
    </div>
  </form>
</section>
<?php require_once __DIR__.'/footer.php'; ?>
