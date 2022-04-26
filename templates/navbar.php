<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">Onlineshop</a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <?php if(isLoggedIn()): ?>
        <a class="nav-link" href="index.php/logout">Logout</a>
        <?php endif; ?>
        <?php if(!isLoggedIn()): ?>
        <a class="nav-link" href="index.php/login">Login</a>
        <?php endif; ?>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php/registration">Registrate</a>
        </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="index.php/cart">Welcome <?= $userName ?></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="index.php/cart">My items(amount here)</a>
      </li>
      
    </ul>
  </div>
</nav>