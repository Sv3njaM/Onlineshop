<?php require_once __DIR__.'/header.php' ?>

<section class="container" id="selectPaymentMethod">
  <?php if($hasErrors): ?>
    <ul class="alert alert-danger">
      <?php foreach($errors as $errorMessage): ?>
        <li><?= $errorMessage ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form method="POST" action="index.php" >
    <?php foreach($availablePaymentMethods as $value => $text): ?>
    <div class="form-check">
      <input type="radio" class="form-check-input" name="paymentMethod" id="payment<?=$text?>" value="<?=$value?>">
      <label class="form-check-label" for="payment<?=$text ?>">
        <?=$text ?>
      </label>
    </div>
  <?php endforeach ?>

    <button type="submit" class="btn btn-primary">Go to Payment</button>
  </form>
</section>

<?php require_once __DIR__.'/footer.php' ?>
