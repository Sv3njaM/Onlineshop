<?php

redirectIfNotLoggedIn('/login');
$standardAddressId = 0;
$oldStandardAdressId = 0;
$routeParts = explode('/',$route);
if(count($routeParts) === 3){
    $standardAddressId = $routeParts[2];
    $oldStandardAddressId = getStandardAddressId($userId);
}
//echo "old: ".$oldStandardAddressId." / new: ".$standardAddressId;
if($oldStandardAdressId !== $standardAddressId
    AND $oldStandardAdressId !== NULL And $oldStandardAdressId !== 0
    AND $standardAddressId !== NULL AND $standardAddressId !== 0){
    changeStandardAddressId($userId, $oldStandardAddressId, $standardAddressId);
}
$headline = "User information overview";
$userId = getCurrentUserId();
$hasErrors = false;
$templatePath = "/Onlineshop/index.php/userInformation";
$userInfo = true;
//echo $userId;
$userData = getUserDataForUserId($userId);
$deliveryAddresses = getAllDeliveryAddressesForUser($userId);
//var_dump($deliveryAddresses);
$username = $userData['username'];
$email = $userData['email'];
//var_dump($_SERVER['PHP_SELF']);

$oldPassword = "";
$newPassword = "";
$repeatPassword = "";
$errors = [];
$hasErrors = false;
$currentPassword = "";
if(isPost()){
    $oldPassword = filter_input(INPUT_POST, 'oldPassword');
    $newPassword = filter_input(INPUT_POST, 'newPassword');
    $repeatPassword = filter_input(INPUT_POST, 'repeatPassword');
    $currentPassword = getPasswordForUser($userId, $oldPassword);
    var_dump($currentPassword);
    if(!password_verify($oldPassword, $currentPassword)){
        $errors[] = "The old passsword dont match";
    }
    if(!(bool)$oldPassword){
        $errors[] = "Old password is not allowed to be empty";
    }
    if(!(bool)$newPassword){
        $errors[] = "New password is not allowed to be empty";
    }
    if(!(bool)$repeatPassword){
        $errors[] = "Repeat password is not allowed to be empty";
    }
    if($newPassword !== $repeatPassword){
        $errors[] = "The new password and the password repeat dont match";
    }

    if(count($errors) === 0 AND $currentPassword !== $newPassword){
        $created = changePasswordForUser($userId, $oldPassword, $newPassword);
        if($created){
            flashMessage("Password successfully changed!");
        }
        if(!$created){
            $errors[] = "A Problem have occured, password not changed!";
        }
    }
    //chek if old and new password dont match each other
    //update in db if no errors 
}//end if isPost
$hasErrors = count($errors) > 0;
require TEMPLATES_DIR.'/userInformationOverview.php';