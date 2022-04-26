<!-- flashMessages.php gives out Messages directly on the page where included
and have been seperated because it is used more than one time-->
<?php if($hasFlashMessages): ?>
  <div class="alert alert-success" role="alert">
    <?php foreach($flashMessages as $message): ?>
      <p><?= $message ?></p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
