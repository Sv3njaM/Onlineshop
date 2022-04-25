<!--The card.php in templates is a html construct to show a single element
in the shop and is called in a loop and is included in the main.php.
The products are shown on the start page (index.php).-->
<div class="card <?= $product['product_status'] ?>">
  <div class="card-title <?= $product['title'] ?>"></div>
  <img src="storage/productPictures/not-found.jpg" alt="<?= $product['slug']?>">
  <div class="card-body">
    <?= $product['description'] ?>
    <hr>
    <!--price is in cent in the DB and need to be changed to be shown with comma-->
    <?= number_format($product['price']/100,2,","," ") ?>
  </div>
  <div class="card-footer">
    <a href="index.php/product/<?= $product['slug'] ?>" class="btn btn-primary btn-sm">Details</a>
    <!--the php after add/ add the product id to the string, needed for the routeParts in actions cart.add.php -->
    <a href="index.php/cart/add/<?php echo $product['id']?>" class="btn btn-success btn-sm">Add to Basket</a>
    <!--check if Admin rights are available to edit a product-->
    <?php if($isAdmin): ?>
    <a href="index.php/product/edit/<?= $product['slug']?>" class="btn btn-warning btn-sm">Edit</a>
    <?php endif; ?>
  </div>
</div>