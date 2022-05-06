<?php require_once __DIR__.'/header.php'?>
<section id="registration" class="container">
  <form class="" action="index.php/registration" method="POST">
    <div class="card">
      <div class="card-header">
        Registration
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/errorMessage.php' ?>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" value="<?=$username?>" name="username" id="username">
          <label for="email">Email</label>
          <input type="email" class="form-control" value="<?=$email?>" name="email" id="email">
          <label for="emailRepeat">Email Repeat</label>
          <input type="email" class="form-control" value="<?=$emailRepeat?>" name="emailRepeat" id="emailRepeat">
          <label for="passwordt">Password</label>
          <input type="password" class="form-control" value="<?=$password?>" name="password" id="password">
          <label for="password">Password Repeat</label>
          <input type="password" class="form-control" value="<?=$passwordRepeat?>" name="passwordRepeat" id="passwordRepeat">
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-success" type="submit" name="button">Create Account</button>
      </div>
    </div>
  </form>
</section>
<?php require_once __DIR__.'/footer.php' ?>
