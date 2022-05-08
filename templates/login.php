<!-- the login.php is the login area of the page and is included in
actions/login.php-->
<section class="container" id="loginForm">
  <form action="index.php/login" method="post">
    <div class="card">
      <div class="card-header">
        Login
      </div>
      <div class="card-body">
        <?php require_once __DIR__.'/errorMessage.php' ?>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" value="" id="username" class="form-control">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" value="" id="password" class="form-control">
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-success" type="submit">Login</button>
      </div>
    </div>
  </form>
</section>

<script src="assets/js/bootstrap.bundle.js"></script>
 </body>
</html>
