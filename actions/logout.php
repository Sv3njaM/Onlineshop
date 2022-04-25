<!--The Programming to run the logout, starting when called
in the routes.php-->
<?php
//needs to be changed to destroy time stamp
session_regenerate_id(true);
session_destroy();
//redirect the target to the start page index.php
$redirectTarget = $baseUrl.'index.php';
if(isset($_SESSION['redirectTarget'])){
  $_SESSION['redirectTarget'] = $redirectTarget;
}
header("Location: ".$redirectTarget);
