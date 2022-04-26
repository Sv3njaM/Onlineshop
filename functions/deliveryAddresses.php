<?php


function getAllDeliveryAddressesForUser(int $userId):array{
  $sql = "SELECT id,recipient,city,street,streetNr,zipCode,country
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