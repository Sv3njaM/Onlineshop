<form action="index.php/deliveryAddress/add" method="POST">
  <div class="card">
    <div class="card-header">
      Sign in new address
    </div>
    <div class="card-body">
      <?php if($hasErrors):?>
        <ul class="alert alert-danger">
          <?php foreach($errors as $errorMessage):?>
            <li><?= $errorMessage ?></li>
          <?php endforeach;?>
        </ul>
      <?php endif;?>
      <?php require_once __DIR__.'/deliveryAddressForm.php';?>
      
    </div>
    <div class="card-footer">
      <button class="btn btn-success">Save Address</button>
    </div>
  </div>
</form>
