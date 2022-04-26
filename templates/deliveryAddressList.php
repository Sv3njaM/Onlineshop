<div class="row">
  <?php foreach($deliveryAddresses as $deliveryAddress):?>
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
        <a class="card-link" href="index.php/selectDeliveryAddress/<?= $deliveryAddress['id']; ?>">Choose</a>
        </div>
      </div>
    </div>
  <?php endforeach;?>
</div>
