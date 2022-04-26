<!--the form page for the registration with needed input fields
registration link is set in the navbar.php and the route.php includes
the route to the register.php wich run the php part -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Shop</title>
    <base href="<?php echo $baseUrl; ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
  </head>
  <body>

  <header class="jumbotron">
    <div class="container">

    </div>
  </header>
  <?php include __DIR__.'/header.php' //css shown in networkanalysis but not on page?>

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
