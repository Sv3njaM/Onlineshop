<!--the card page shows all articles, amount, price and total price
the user have added to the cart, the single products come from the
cartItem.php wich is included here-->
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
  <?php include __DIR__.'/header.php' //css shown in networkanalysis but not on page?>
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
        <a href="index.php/checkout" class="btn btn-primary col-12">Buy Now</a>
      </div>
    </div>
  </section>

<?php //require_once __DIR__.'/footer.php' ?>
<script src="assets/js/bootstrap.bundle.js"></script>
 </body>
</html>
