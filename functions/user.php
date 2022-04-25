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

//get the user information out of DB with the username
function getUserDataForUsername(string $username):array{
    $sql = "SELECT user_id,password,CONCAT_WS('-','KD',SUBSTRING(username,0,3),user_id) AS customerId,activationKey,userRights
            FROM user
            WHERE username = :username";
    $statement = getDB()->prepare($sql);
    if(!$statement){
      return [];
    }
    $statement->execute([
          ':username'=>$username
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
    $sql = "SELECT username,password,CONCAT_WS('-','KD',SUBSTRING(username,0,3),id) AS customerId,activationKey,userRights
            FROM user
            WHERE user_id = :userId";
    $statement = getDB()->prepare($sql);
    if($statement === false){
      return [];
    }
    $statement->execute([
          ':user_id'=>$userId
    ]);
    if($statement->rowCount === 0){
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
  
//check in SESSION['userId'] if user is logged in if value exists
function isLoggedIn():bool{
    return (isset($_SESSION['userId']) && userIdExists($_SESSION['userId']));
  }