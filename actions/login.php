<!--The Programming to run the login, starting when called
in the routes.php-->
<?php
//sets $isPost to  $_SERVER['REQUEST_METHOD']
$isPost = isPost();

$username = "";
$password = "";
$errors = [];
$hasErrors = false;
$_SESSION['isPost'] = $isPost;
if($isPost){
  //username should not have special chars and get filtered
  $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
  //no filter in password because special chars are welcome here
  $password = filter_input(INPUT_POST,'password');
  //check if username and password are set
  if(!(bool)$username){
    $errors[] = "Username is empty!";
  }
  if(!(bool)$password){
    $errors[] = "Password is empty!";
  }
  $userData = getUserDataForUsername($username);

  //if username is set but DB result is null user dont exist in DB
  if((bool)$username && count($userData) === 0){
    $errors[] = "Username dont exist!";
  }
  //if username and activationKey are set but activationKey is not null then account is not activated yet
  if((bool)$username && isset($userData['activationKey']) && is_null($userData['activationKey']) === false){
    $errors[] = "Account not activated yet!";
    logData("Failure",$userData['activationKey']);
  }
  //if the password is set and ther is one in $userData but the password verifying gives false
  //then the password wich have been put in dont fit to the one in DB
  if(!(bool)$password && isset($userData['password']) && password_verify($password,$userData['password']) === false){
    //info just for testing, need to be changed into username and password not correct later
    $errors[] = "Password not correct!";
  }
  
  //if there are no errors then the logininformations are ok and the login can be set
  if(count($errors) === 0){
    $_SESSION['userId'] = (int)$userData['user_id'];
    $_SESSION['userName'] = $userData['username'];
    //userRights to give rights for product edit or new
    $_SESSION['userRights'] = $userData['userRights'];
    $redirectTarget = $baseUrl.'index.php';
    if(isset($_SESSION['redirectTarget'])){
      $redirectTarget = $_SESSION['redirectTarget'];
    }
    header("Location: ".$redirectTarget);
    exit();
  }

}//if isPost end
//sets hasErrors true if errors not empty
$hasErrors = count($errors) > 0;
require TEMPLATES_DIR.'/login.php';