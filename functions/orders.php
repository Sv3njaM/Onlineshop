<?php

function createUserOrderInDB(int $userId, int $deliveryAddressId, array $cartItems, string $orderStatus = 'new'):int{
    foreach($cartItems as $cartItem){
      $data = [
        ':userId'=>$userId,
        ':orderDate'=>date('Y-m-d H:i:s'),
        ':deliveryAddressId'=>$deliveryAddressId,
        ':productId'=>$cartItems['product_id'],
        ':orderQuantity'=>$cartItems['quantity'],
        ':orderStatus'=>$orderStatus
      ];
      $created = $statement->execute($data);
      if(false === $created){
        echo printDBErrorMessage;
        break;
      }
    }
  
  
  
/*
  $data = [
        ':orderId'=>$orderId,
        ':recipient'=>$deliveryAddressData['recipient'],
        ':city'=>$deliveryAddressData['city'],
        ':street'=>$deliveryAddressData['street'],
        ':streetNr'=>$deliveryAddressData['streetNr'],
        ':zipCode'=>$deliveryAddressData['zipCode']
  ];
  $created = $statement->execute($data);
  if(false === $created){
    echo printDBErrorMessage;
    return false;
  }

  $sql = "INSERT INTO orderProducts SET
          title = :title,
          quantity = :quantity,
          price = :price,
          taxInPercent = :taxInPercent,
          order_id = :orderId,
          user_id = :userId
      ";
  $statement = getDB()->prepare($sql);
  if(false === $statement){
    echo printDBErrorMessage;
    return false;
  }
  //loop needs a break if something is wrong to jump out
  foreach($cartItems as $cartItem){
    $taxInPercent = 19;
    $price = $cartItem['price'];
    $netPrice = (1.0 - ($taxInPercent/100))*$price;
    $data = [
      ':title'=>$cartItem['title'],
      ':quantity'=>$cartItem['quantity'],
      ':price'=>$netPrice,
      ':taxInPercent'=>19,
      ':orderId'=>$orderId,
      ':userId'=>$userId
    ];
    $created = $statement->execute($data);
    if(false === $created){
      echo printDBErrorMessage;
      break;
    }
  }
  //return not just true but the boolean of the loop, if programm comes to
  //the loop and finish it $created is true else it is false
  return $created;
  */
}

function getOrderSumForUser(int $orderId, int $userId):?array{
  $sql = "SELECT SUM(price*quantity) AS sumNet,
    CONVERT(SUM(price*quantity)*(1+taxInPercent/100), SIGNED integer) AS sumBrut,
    CONVERT((SUM(price*quantity)*(1+taxInPercent/100))-(SUM(price*quantity)), SIGNED integer) AS taxes
    FROM orderproducts op
    INNER JOIN orders o ON(op.order_id = o.id)
    WHERE op.user_id = :userId
    AND order_id = :orderId";
  $statement = getDB()->prepare($sql);
  if(false === $statement){
    echo printDBErrorMessage;
    return NULL;
  }
  $statement->execute([
      ':userId'=>$userId,
      ':orderId'=>$orderId
  ]);
  if(0 === $statement->rowCount()){
    return NULL;
  }
  return $statement->fetch();
}

function ivoiceId(?int $invoiceId = null){
  static $id = null;
  if(!incvoiceId){
    return $id;
  }
  $id = $invoiceId;
}

//?int $userId = null makes parameter optional
function getOrderForUser(int $orderId, ?int $userId = null):?array{

  $sql = "SELECT orderDate,deliveryDate, status, user_id, id
          FROM orders
          WHERE id=:orderId";
  $data = [
    ':orderId'=>$orderId
  ];
  
  if($userId){
    $data[':userId']=$userId;
    $sql .= " AND user_id = :userId";
    
  }
  $sql .= " LIMIT 1";
  $statement = getDB()->prepare($sql);
  if(false === $statement){
    echo printDBErrorMessage;
    return null;
  }
  $statement->execute($data);
  if(0 === $statement->rowCount()){
    return null;
  }
  $orderData = $statement->fetch();
  $orderDate = date_create($orderData['orderDate']);
  $deliveryDateFormatted = 'have not been created';
  if($orderData['deliveryDate'] !== "0000-00-00"){
    $deliveryDate = date_create($orderData['deliveryDate']);
    $deliveryDateFormatted = date_format($deliveryDate, 'd.m.Y');

  }
  $orderData['deliveryDateFormatted'] = $deliveryDateFormatted;
  $orderData['orderDateFormatted'] = date_format($orderDate, 'd.m.Y');
  $orderData['products'] = [];
  $orderData['deliveryAddressData'] = [];

  $sql = "SELECT recipient,street,streetNr,city,zipCode,type
          FROM order_addresses
          WHERE order_id=:orderId
          LIMIT 1";

  $statement = getDB()->prepare($sql);
  if(false === $statement){
    echo printDBErrorMessage;
    return NULL;
  }
  $data = [
      ':orderId'=>$orderId
  ];
  $statement->execute($data);

  if(0 === $statement->rowCount()){
    return NULL;
  }

  $orderData['deliveryAddressData'] = $statement->fetch();


  $sql = "SELECT id,title,quantity,price,taxInPercent
          FROM orderProducts
          WHERE order_id = :orderId
          ";
  $statement = getDB()->prepare($sql);
  if(false === $statement){
    echo printDBErrorMessage;
    return NULL;
  }
  $statement->execute([
      ':orderId'=>$orderId
  ]);
  if(0 === $statement->rowCount()){
    return NULL;
  }

  $whilecheck = [];
  while($row = $statement->fetch()){
    $orderData['products'][]=$row;
    $whilecheck[]= $row;
  }
  
  return $orderData;
}
