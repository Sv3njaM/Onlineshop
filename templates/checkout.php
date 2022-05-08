<!--the card page shows all articles, amount, price and total price
the user have added to the cart, the single products come from the
cartItem.php wich is included here-->
  <?php include __DIR__.'/header.php' //css shown in networkanalysis but not on page?>

  <!--This part shows the items wich needed to be confirmed to be bought-->
  <section class="container" id="cartItems">
    <div class="row">
      <h2>Shopping Basket</h2>
      <hr>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <strong class="recipient"><?= $deliveryAddress['recipient']; ?></strong>
          <p class="street">
          <?= $deliveryAddress['street']?> <?= $deliveryAddress['streetNr']; ?>
          </p>
          <p class="city">
          <?= $deliveryAddress['zipCode']?> <?= $deliveryAddress['city'];?>
          </p>
          <p class="country">
          <?= $deliveryAddress['countryCode']?> <?= $deliveryAddress['country'];?>
          </p>
        <a class="card-link" href="index.php/selectDeliveryAddress">Change</a>
        </div>
      </div>
    </div>
  
  <section class="container" id="orderItemList">
    <?php require_once __DIR__.'/orderItemList.php'; ?>
  </section>
  <section>
    <!--Part to show all items to confirm-->
    <div class="row">
      <div class="col-12 text-right">
        In All (<?= $countCartItems; ?> Items): <?= number_format($cartSum/100,2,","," "); ?> €
      </div>
    </div>
    <!--Part to choose an address for delivery-->
    <!--This part is for confirm the order-->
    <div class="row">
    <form action="index.php/checkout" method="post">
      <a class="btn btn-danger" href="index.php">Cancel</a>  
      <button class="btn btn-success" type="submit">Confirm Order</button>
    </form>
    </div>
  </section>

<?php //require_once __DIR__.'/footer.php' ?>
<script src="assets/js/bootstrap.bundle.js"></script>
 </body>
</html>
