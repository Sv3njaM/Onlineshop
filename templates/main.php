<?php require_once __DIR__.'/header.php' ?>
<section class="container">
  <div class="row">
      <!--check if Admin rights are available to create a new product-->
    <!-- In this part the card.php is included and the products shown -->
    <?php foreach($products as $product):?>
    <div class="col-3">
      <?php include('card.php') ?>
    </div>
  <?php endforeach; ?>
  </div>
</section>
<?php require_once __DIR__.'/footer.php' ?>