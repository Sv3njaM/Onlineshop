<!--All functions wich are needed to a user like get Userinformation, change or delete,
registrate new user or check if informations are existing or matching-->
<?php
//get the current userId out of the SESSION['userId']
function getCurrentUserId():?int{
  //if userid is null a random is created so putting in cart can work
  //without being logged in
  $userId = null;
  if(!isset($_SESSION['userId'])){

    logData("Failure","isloggedin: ".isLoggedIn());
    $userId = random_int(0,time());
    $_SESSION['userId'] = $userId;
    logData("Failure","session userid after random: ".$_SESSION['userId']);
  }
  if(isset($_SESSION['userId'])){
    $userId = (int)$_SESSION['userId'];
  }
  return $userId;
}

function getUserName(int $userId):string{
  $sql = "SELECT username FROM user WHERE user_id = :userId";
  $result = getDB()->prepare($sql);
  
  $result->execute([ ':userId'=>$userId]);
  
  $row = $result->fetch();
  
  $userName = $row['username'];
  if($row === null){
    return "";
  }
  return $userName;
}

//get the user information out of DB with the username
function getUserDataForUsername(string $userName):array{
    $sql = "SELECT user_id,password,email,CONCAT_WS('-','KD',SUBSTRING(username,0,3),user_id) AS customerId,activationKey,userRights
            FROM user
            WHERE username = :userName";
    $statement = getDB()->prepare($sql);
    if(!$statement){
      return [];
    }
    $statement->execute([
          ':userName'=>$userName
    ]);
    if($statement->rowCount() === 0){
      return [];
    }
    $row = $statement->fetch();
    return $row;
  }
  //get the user informations out of DB with userId
  function getUserDataForUserId(?int $userId):array{
    if($userId === null){
      return [];
    }
    //
    $sql = "SELECT username,password,email,CONCAT_WS('-','KD',SUBSTRING(username,0,3),user_id) AS customerId,activationKey,userRights
            FROM user
            WHERE user_id = :userId";
    $statement = getDB()->prepare($sql);
    if($statement === false){
      return [];
    }
    $statement->execute([
          ':userId'=>$userId
    ]);
    if($statement->rowCount() === 0){
      return [];
    }
    $row = $statement->fetch();
    return $row;
  }

  //check if the $_SESSION['userRights'] is set and is Admin
function isAdmin():bool{
    return isset($_SESSION['userRights']) && $_SESSION['userRights'] === 'ADMIN';
  }

//check if the userId exists in database
function userIdExists(?int $userId):bool{
    if($userId){
      $sql = "SELECT user_id
              FROM user
              WHERE user_id = :userId";
      $statement = getDB()->prepare($sql);
      if(!$statement){
        return false;
      }
      $statement->execute([':userId'=>$userId]);
      return (bool)$statement->fetchColumn();
    }
    return false;
  
  }
 
//check if the username exists in database
function usernameExists(string $username):bool{
  $sql = "SELECT * FROM user WHERE username=:username";
  $statement = getDB()->prepare($sql);
  if($statement){
    return false;
  }
  $statement->execute([
      ':username'=>$username
  ]);
  return (bool)$statement->fetchColumn();

}  

//check if the email already exists in database
function emailExists(string $email):bool{
  $sql = "SELECT * FROM user WHERE email=:email";
  $statement = getDB()->prepare($sql);
  if($statement){
    return false;
  }
  $statement->execute([
      ':email'=>$email
  ]);
  return (bool)$statement->fetchColumn();

}

//get the password from database
function getPasswordForUser(int $userId, string $oldPassword):string{
  $sql = getDB()->prepare("SELECT password FROM user WHERE user_id=:userId");
  $sql->execute([':userId'=>$userId]);
  $result = $sql->fetchColumn();
  return $result;

}

//check in SESSION['userId'] if user is logged in if value exists
function isLoggedIn():bool{
    return (isset($_SESSION['userId']) && userIdExists($_SESSION['userId']));
  }

//create an account after Registration
function createAccount(string $username, string $password, string $email):bool{
  $password = password_hash($password, PASSWORD_DEFAULT);
  $userRights = 'USER';
  //check if there is already registrated user, if not the first get admin rights
  if(getAccountsTotal() === 0){
    $userRights = 'ADMIN';
  }
  $sql = "INSERT INTO user
          SET username = :username,
              password = :password,
              email = :email,
              activationKey = :activationKey,
              userRights = :userRights";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  $activationKey = getRandomHash(8);
  $statement->execute([
        ':username'=>$username,
        ':password'=>$password,
        ':email'=>$email,
        ':activationKey'=>$activationKey,
        ':userRights'=>$userRights
  ]);
  $affectedRows = $statement->rowCount();
  if($affectedRows === 0){
    return false;
  }
  return $affectedRows > 0;
}

//check if it is the first user registrated at all
function getAccountsTotal():?int{
  $sql = "SELECT COUNT(user_id)
          FROM user";
  $statement = getDB()->query($sql);
  if($statement === false){
    return null;
  }
  return (int)$statement->fetchColumn();
}

function changePasswordForUser(int $userId, string $oldPassword, string $newPassword):bool{
  $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  $sql = "UPDATE user SET password = :newPassword WHERE user_id = :userId";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  $statement->execute([
    ':newPassword'=>$newPassword,    
    ':userId'=>$userId
  ]);
  $affectedRows = $statement->rowCount();
  if($affectedRows === 0){
    return false;
  }
  return $affectedRows > 0;
}