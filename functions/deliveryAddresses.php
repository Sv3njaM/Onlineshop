<?php

function saveDeliveryAddressForUser(int $userId, string $recipient, string $city, string $zipCode, string $street, string $streetNr, string $country, string $countryCode = "DE"):int{
  $sql = "INSERT INTO delivery_addresses
          SET user_id=:userId, recipient=:recipient, city=:city, zipcode=:zipCode, street=:street, streetnr=:streetNr, country=:country, countryCode=:countryCode";


  $statement = getDB()->prepare($sql);
  if(false === $statement){
    return 0;
  }
  $statement->execute([
    ':userId'=>$userId,
    ':recipient'=>$recipient,
    ':city'=>$city,
    ':zipCode'=>$zipCode,
    ':street'=>$street,
    ':streetNr'=>$streetNr,
    ':country'=>$country,
    ':countryCode'=>$countryCode
  ]);
  return (int)getDB()->lastInsertId();
}

function getDeliveryAddressForUser( int $userId, ?int $deliveryAddressId = 0):array{
  if($deliveryAddressId === 0){
    logData("INFO","in first choice part: ".$deliveryAddressId);
    $sql = "SELECT id,recipient,city,street,streetNr,zipCode,country,countryCode
          FROM delivery_addresses
          WHERE user_id = :userId
          AND first_choice = 1
          LIMIT 1";
  }
  if($deliveryAddressId >0){
    logData("INFO","in part with deliveryAddressId: ".$deliveryAddressId);
    $sql = "SELECT id,recipient,city,street,streetNr,zipCode,country,countryCode
          FROM delivery_addresses
          WHERE user_id = :userId
          AND id = :deliveryAddressId
          LIMIT 1";
  }
  

  $statement = getDB()->prepare($sql);

  if(false === $statement){
    return [];
  }
  $address = [];
  if(!$deliveryAddressId){
    $statement->execute([':userId'=>$userId]);
  }
  if($deliveryAddressId){
    $statement->execute([':userId'=>$userId, ':deliveryAddressId'=>$deliveryAddressId]);
  }
  
  $address = $statement->fetch();
  return $address;
}

function getAllDeliveryAddressesForUser(int $userId):array{
  $sql = "SELECT id,recipient,city,street,streetNr,zipCode,country,countryCode,first_choice
          FROM delivery_addresses
          WHERE user_id = :userId";

  $statement = getDB()->prepare($sql);
  if(false === $statement){
    return [];
  }
  $addresses = [];

  $statement->execute([':userId'=>$userId]);

  while($row = $statement->fetch()){
    $addresses[]=$row;
  }

  return $addresses;
}

function getStandardAddressId($userId):int{
  $sql = getDB()->prepare("SELECT id FROM delivery_addresses WHERE first_choice = 1 AND user_id = :userId");
  $sql->execute([':userId'=>$userId]);
  $id = $sql->fetchColumn();
  return $id;
}

function deliveryAddressBelongToUser(int $deliveryAddressId, int $userId):bool{
  $sql = "SELECT id
          FROM delivery_addresses
          WHERE user_id = :userId AND id = :deliveryAddressId";

  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  $statement->execute([
        ':userId'=>$userId,
        ':deliveryAddressId'=>$deliveryAddressId
  ]);
  return (bool)$statement->rowCount();
}

function changeStandardAddressId(int $userId, int $oldId, int $newId):bool{
  $sql = "UPDATE delivery_addresses 
  SET first_choice = 0 
  WHERE user_id = :userId AND id = :oldId";
  $statement = getDB()->prepare($sql);
  if($statement === false){
    return false;
  }
  if($statement){
    $sql = "UPDATE delivery_addresses 
    SET first_choice = 1 
    WHERE user_id = :userId AND id = :newdId";
    $statement = getDB()->prepare($sql);
    if($statement === false){
      return false;
    }
  }
  return (bool)$statement->rowCount();
}