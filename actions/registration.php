<?php
$headline = "Registration Area";
$username = "";
$email = "";
$emailRepeat = "";
$password = "";
$passwordRepeat = "";
$errors = [];
$hasErrors = false;

if(isPost()){
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password');
  $passwordRepeat = filter_input(INPUT_POST, 'passwordRepeat');
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  $emailRepeat = filter_input(INPUT_POST, 'emailRepeat', FILTER_SANITIZE_SPECIAL_CHARS);

  //check if necessary informations are set
  if((bool)$username === false){
    $errors[] = "Username is empty!";
  }
  if((bool)$password === false){
    $errors[] = "Password is empty!";
  }
  //username need at least 4 chars maximum 10 chars
  if((bool)$username === true){
    if(mb_strlen($username) < 4){
      $errors[] = "Username to short. Need at least 4 characters!";
    }
    if(mb_strlen($username) > 10){
      $errors[] = "Username to long, minimum of 10 characters!";
    }
  }
  //check if username already exists in DB
  $usernameExisting = usernameExists($username);
  if($usernameExisting === true){
    $errors[] = "Username already exist please choose another one!";
  }
  //check the length of the password
  if((bool)$password === true){
    if(mb_strlen($password) < 6){
      $errors[] = "Password need a minimum length of 6!";
    }
  }
  //check if the passwords are equal to each other
  if($passwordRepeat !== $password){
    $errors[] = "Passwords not equal!";
  }
  //check if email is set
  if((bool)$email === false){
    $errors[] = "Email is empty!";
  }
  //check if email can be validated
  if((bool)$email === true){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors[] = "Email can`t be validated!";
    }
    //check if email already exists
    $emailExisting = emailExists($email);
    if($emailExisting === true){
      $errors[] = "Email already exist!";
    }
  }
  //check if the email are the same
  if($emailRepeat !== $email){
    $errors[] = "Email are not the same!";
  }
  //check if there are errors available to show/ if not run the programm
  $hasErrors = count($errors) > 0;

  if($hasErrors === false){
    $created = createAccount($username, $password, $email);
    //check if account have been created else give an error out
    if(!$created){
      $errors[] = "Registration failed, Account have NOT been created!";
    }
    //flash Message and redirect to mainpage if account have been created
    if($created){
      flashMessage("Your registration was successful!");
      header("Location: ".$baseUrl.'index.php');
    }
  }


}//end if isPost

require TEMPLATES_DIR.'/registration.php';
