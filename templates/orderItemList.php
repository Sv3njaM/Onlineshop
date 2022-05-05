<div class="row">
  <?php foreach($cartItems as $cartItem):?>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <strong class="product-title"><?= $cartItem['title']; ?></strong>
          <p class="product-description">
          <?= $cartItem['description']?>
          </p>
          <p class="product-quantity">
          <?= $cartItem['quantity']?>
          </p>
          <p class="product-price">
          <?= $cartItem['price']?> / <?= $cartItem['price']*$cartItem['quantity'];?>
          </p>
        
        </div>
      </div>
    </div>
  <?php endforeach;?>
</div>
