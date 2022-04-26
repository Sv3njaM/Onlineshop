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

<?php require_once __DIR__.'/header.php'; ?>

<section class="container" id="selectDeliveryAddress">
  <?php require_once __DIR__.'/deliveryAddressList.php'; ?>
</section>

<section class="container" id="newDeliveryAddress">
  <?php require_once __DIR__.'/deliveryAddressForm.php'; ?>
</section>


<?php require_once __DIR__.'/footer.php'; ?>
