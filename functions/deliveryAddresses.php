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

function getDeliveryAddressForUser(int $deliveryAddressId, int $userId):array{
  $sql = "SELECT id,recipient,city,street,streetNr,zipCode,country,countryCode
          FROM delivery_addresses
          WHERE user_id = :userId
          AND id = :deliveryAddressId
          LIMIT 1";

  $statement = getDB()->prepare($sql);

  if(false === $statement){
    return null;
  }

  $statement->execute([':userId'=>$userId, ':deliveryAddressId'=>$deliveryAddressId]);
  $address = $statement->fetch();
  return $address;
}

function getAllDeliveryAddressesForUser(int $userId):array{
  $sql = "SELECT id,recipient,city,street,streetNr,zipCode,country,countryCode
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
