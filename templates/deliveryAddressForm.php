<!--Template with a form to insert a new delivery address-->
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
      <div class="form-group">
        <label for="recipient">recipient</label>
        <input name="recipient" value="<?= escape($recipient) ?>" class="form-control <?= $recipientIsValid?'':'is-invalid'?>" id="recipient">
      </div>
      <div class="form-group">
        <label for="city">City</label>
        <input name="city" value="<?= escape($city) ?>" class="form-control <?= $cityIsValid?'':'is-invalid'?>" id="city">
      </div>
      <div class="form-group">
        <label for="zipCode">ZipCode</label>
        <input name="zipCode" value="<?= escape($recipient) ?>" class="form-control <?= $zipCodeIsValid?'':'is-invalid'?>" id="zipCode">
      </div>
      <div class="form-group">
        <label for="street">Street</label>
        <input name="street" value="<?= escape($street) ?>" class="form-control <?= $streetIsValid?'':'is-invalid'?>" id="street">
      </div>
      <div class="form-group">
        <label for="streetNr">Housenumber</label>
        <input name="streetNr" value="<?= escape($streetNr) ?>" class="form-control <?= $streetNrIsValid?'':'is-invalid'?>" id="streetNr">
      </div>
      <div class="form-group">
        <label for="country">Country</label>
        <input name="country" value="<?= escape($country) ?>" class="form-control <?= $countryIsValid?'':'is-invalid'?>" id="country">
      </div>
      
    </div>
    <div class="card-footer">
      <button class="btn btn-success">Save Address</button>
    </div>
  </div>
</form>
