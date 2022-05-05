<?php include __DIR__.'/header.php'; ?> 
  <section class="container" id="cartItems">
    <div class="row">
      <h2>Shopping Basket</h2>
      <hr>
    </div>
    <div class="row cartItemHeader">


    </div>
    <?php foreach($cartItems as $cartItem): ?>
    <div class="row cartItem">
      <!--cartItem have the single items for showing -->
      <?php include __DIR__.'/cartItem.php' ?>
    </div>
  <?php endforeach; ?>
    <div class="row">

    </div>
    <div class="row">
      <div class="col-12 text-right">
        In All (<?= $countCartItems; ?> Items): <?= number_format($cartSum/100,2,","," "); ?> €
      </div>

      <div class="row">
        <a href="index.php/confirmOrder" class="btn btn-primary col-12">Buy Now</a>
      </div>
    </div>
  </section>

<?php //require_once __DIR__.'/footer.php' ?>
<script src="assets/js/bootstrap.bundle.js"></script>
 </body>
</html>
