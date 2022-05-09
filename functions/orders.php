<?php

function createUserOrderInDB(int $userId, int $deliveryAddressId, array $cartItems):?int{
    logData("INFO","Delivery Id in function createOrder: ".$deliveryAddressId);
    $orderStatus = "NEW";
    $paymentStatus = "OPEN";
    $orderDate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO orders SET
            order_status = :orderStatus,
            order_date = :orderDate,
            user_id = :userId,
            delivery_address_id = :deliveryAddressId,
            payment_status = :paymentStatus
            ";
    $statement = getDB()->prepare($sql);
    
    $created = $statement->execute([
            ':orderStatus'=>$orderStatus,
            ':orderDate'=>$orderDate,
            ':userId'=>$userId,
            ':deliveryAddressId'=>$deliveryAddressId,
            ':paymentStatus'=>$paymentStatus
    ]);
    if($created === false){
      echo printDBErrorMessage;
      return false;
    }
    
    $orderId = getDB()->lastInsertId('id');
    
    $sql = "INSERT INTO order_products SET
            product_id = :product_id,
            order_id = :order_id,
            quantity = :quantity";
    foreach($cartItems as $cartItem){
      $data = [
            ':product_id'=>$cartItem['product_id'],
            ':order_id'=>$orderId,
            ':quantity'=>$cartItem['quantity']
      ];
      $statement = getDB()->prepare($sql);
      $created = $statement->execute($data);
      if($created === false){
        echo printDBErrorMessage;
        break;
      }
    }
    return $created;
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
