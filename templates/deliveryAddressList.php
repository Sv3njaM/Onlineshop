<div class="row">
  <?php foreach($deliveryAddresses as $deliveryAddress):?>
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <!--for showing the standard addres in userInformation, else it is not needed to be seen-->
          <?php if($deliveryAddress['first_choice'] === 1):?>
            <div class="card-header">Standard Address</div>
          <?php endif;?>
          <?php if($deliveryAddress['first_choice'] === 0):?>
            <div class="card-header">Other</div>
          <?php endif;?>
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
          <?php if($userInfo):?>
            <a class="card-link" href="index.php/userInformation/<?= $deliveryAddress['id']; ?>">Choose as standard</a>
          <?php endif; ?>
          <?php if(!$userInfo):?>
            <a class="card-link" href="index.php/checkout/<?= $deliveryAddress['id']; ?>">Choose</a>
          <?php endif; ?>
        
        </div>
      </div>
    </div>
  <?php endforeach;?>
</div>
