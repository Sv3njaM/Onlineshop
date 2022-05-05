<?php include __DIR__.'/header.php'; ?> 
<section class="container">
  <?php require_once __DIR__.'/flashMessage.php'; ?>
  <div class="row">
    <!--check if Admin rights are available to create a new product-->
    <?php if($isAdmin): ?>
    <div class="col">
      <!--part with a plus to add a new product into the shop database-->
      <div class="card" id="newProduct">
        <div class="card-body text-center">
          <a href="index.php/product/new">
            <i class="fa-solid fa-square-plus"></i>
          </a>
        </div>
      </div>
    </div>
    <?php endif;?>
    <!-- In this part the card.php is included and the products shown -->
    <?php foreach($products as $product):?>
    <div class="col-3">
      <?php include('card.php') ?>
    </div>
  <?php endforeach; ?>
  </div>
</section>
<?php require_once __DIR__.'/footer.php' ?>