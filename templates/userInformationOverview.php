<?php require_once __DIR__.'/header.php'?>
<section id="userInformation" class="container">
  <form class="" action="index.php/registration" method="POST">
    <div class="card">
      <div class="card-header">
        Personal Data
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/errorMessage.php' ?>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" value="<?=$username?>" name="username" id="username">
          <label for="email">Email</label>
          <input type="email" class="form-control" value="<?=$email?>" name="email" id="email">
        </div>
      </div>
      <div class="card-footer">
        
      </div>
    </div>
  </form>
</section>
<section id="userInformation" class="container">
  <form class="" action="index.php/userInformation" method="POST">
    <div class="card">
      <div class="card-header">
        Personal Data
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/errorMessage.php' ?>
        <div class="form-group">
          <label for="password">Old Password</label>
          <input type="password" class="form-control" value="<?=$oldPassword?>" name="oldPassword" id="oldPassword">
          <label for="password">New Password</label>
          <input type="password" class="form-control" value="<?=$newPassword?>" name="newPassword" id="newPassword">
          <label for="password">Repeat Password</label>
          <input type="password" class="form-control" value="<?=$repeatPassword?>" name="repeatPassword" id="repeatPassword">
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-success" type="submit" name="button">Change Password</button>
      </div>
    </div>
  </form>
</section>
<section class="container" id="selectDeliveryAddress">
  <?php require_once __DIR__.'/deliveryAddressList.php'; ?>
</section>
<?php require_once __DIR__.'/footer.php' ?>