<!--orderConfirmItem.php is like the cartItems called in a loop in page
templates/checkout.php to show all items the user have in cart -->
<div class="col-3">
  <img class="productPicture" src="storage/productPictures/not-found.jpg" alt="<?= $cartItem['slug']?>">
</div>
<div class="col-3">
  <div><?= $cartItem['title']; ?></div>
  <div>Product Id: <?= $cartItem['product_id']; ?></div>
  <div><?= $cartItem['description']; ?></div>
  <!--insert the quantity and make it able to be changed--->
  <div><?= $cartItem['quantity'] ?></div>
  
  </div>
</div>
<div class="col-3 text-right">

</div>
<div class="col-4 text-right">
  <span class="price">Price: <?= number_format($cartItem['price']/100,2,","," ");?>€</span>
</div>
<hr>
