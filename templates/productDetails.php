<?php require_once __DIR__.'/header.php'?> 
<section class="container" id="productDetails">
  <div class="card">
    <div class="card-header">
      <h2><?= $product['title']?></h2>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-4">
          <img src="index.php/product/image/<?= $product['slug']?>/1.jpg" class="card-img-top" alt="<?= $product['slug']?>">
        </div>
      </div>
      <div class="col-8">
        <div>
          Preis:
          <b>
            <?= number_format($product['price']/100,2,","," ") ?>
            €
          </b>
        </div>
        <hr/>
        <div>
          <?= $product['description']?>
        </div>
      </div>
    </div>
    <div class="card-footer">
            <a href="index.php" class="btn btn-primary btn-sm">Return to shop</a>
            <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-success btn-sm">Put in curv</a>
        </div>
  </div>
</section>
<?php require_once __DIR__.'/footer.php' ?>