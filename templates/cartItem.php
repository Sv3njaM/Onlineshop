<!--cartItems.php is like card.php a html construct wich gives out the
products a user have add to the cart and included in cartPage.php
where it is called in a loop -->
<div class="col-3">
  <img class="productPicture" src="storage/productPictures/not-found.jpg" alt="<?= $cartItem['slug']?>">
</div>
<div class="col-7">
  <div><?= $cartItem['title']; ?></div>
  <div>Product Id: <?= $cartItem['product_id']; ?></div>
  <div><?= $cartItem['description']; ?></div>
  <!--insert the quantity and make it able to be changed--->
  <div><?= $cartItem['quantity'] ?></div>
  <form action="index.php/cart" method="post">
    <input type="text" name="product_id" value="<?= $cartItem['product_id'] ?>">
    <input type="number" name="quantity" value="<?= $cartItem['quantity'] ?>">
    <button class="btn btn-success" type="submit" name="button">change Quantity</button>   
  </form>
</div>
<div class="col-3 text-right">

</div>
<div class="col-4 text-right">
  <span class="price">Price: <?= number_format($cartItem['price']/100,2,","," ");?>€</span>
</div>
<hr>
