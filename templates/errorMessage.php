<!-- errorMessages.php gives out errors directly on the page where included
and have been seperated for it is used more than one time-->
<?php if($hasErrors): ?>
  <ul class="alert alert-danger">
    <?php foreach($errors as $errorMessage): ?>
      <li><?= $errorMessage ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
