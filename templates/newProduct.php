<!--newProduct.php to create a new product and add it into the database
included in actions/product.new.php-->

<?php include __DIR__.'/header.php' //css shown in networkanalysis but not on page?>

<section id="newProduct" class="container">
  <form action="index.php/product/new" method="post">
    <div class="card">
      <div class="card-header">
        Create New Product
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/flashMessage.php'; ?>
        <?php require_once __DIR__.'/errorMessages.php' ?>
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
