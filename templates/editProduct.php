<!--the editProduct.php is made for editing an existing product and
is included in actions/product.edit.php ?>-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Shop</title>
    <base href="<?php echo $baseUrl; ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
  </head>
  <body>

  <header class="jumbotron">
    <div class="container">

    </div>
  </header>

<section class="container" id="newProduct">
  <form action="index.php/product/edit/<?= $slug ?>" method="post" enctype="multipart/form-data">
    <div class="card">
      <div class="card-header">
        Edit Product
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/flashMessage.php'; ?>
        <?php require_once __DIR__.'/errorMessage.php' ?>
        <div class="form-group">
          <label for="productName">Product Name</label>
          <input type="text" name="productName" value="<?= escape($productName)?>" id="productName" class="form-control">
        </div>
        <div class="form-group">
          <label for="slug">Product Slug</label>
          <input type="text" name="slug" value="<?= escape($slug)?>" id="slug" class="form-control">
        </div>
        <div class="form-group">
          <label for="description">Product Description</label>
          <textarea class="form-control" name="description" id="description" rows="3"><?=escape($description)?></textarea>
        </div>
        <div class="form-group">
          <label for="price">Product Price</label>
          <input type="number" name="price" value="<?= escape($price)?>" id="price" class="form-control">
        </div>
        
      <div class="card-footer">
        <a href="index.php" class="btn btn-danger">Cancel</a>
        <button type="submit" name="button" class="btn btn-success">Save</button>
      </div>
    </div>
  </form>
</section>

<?php require_once __DIR__.'/footer.php'; ?>
