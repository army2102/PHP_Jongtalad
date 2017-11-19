<?php

require_once "connectDB.php";

//ข้อมูลจากฝั่ง Android
//ข้อมูลเกี่ยวกับพ่อค้า, แม่ค้า
$username = $_POST['username'];


//ข้อมูลเกี่ยวกับการจอง
$marketName = $_POST['marketName'];
$lockName = $_POST['lockName'];
$productTypeName = $_POST['productTypeName'];
$saleDate = $_POST['saleDate'];
$MAXIMUN_RESERVED = 3;

//Function list
///////////////////////////////////////////

function getMarketLockId(){
    global $conn, $marketName, $lockName;
    $sql = "SELECT market_id FROM markets
    WHERE name = '$marketName';";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $market_id = $row["market_id"];
    }
    
    $sql = "SELECT market_lock_id FROM market_locks
    WHERE market_id = $market_id
    AND name = '$lockName';";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $market_lock_id = $row["market_lock_id"];
    }

    return $market_lock_id;
}

function getMerchantId() {
    global $conn, $username;
    
      $sql =
      "SELECT merchant_id FROM merchants
      WHERE username = '$username';";

      $result =  $conn->query($sql);
      if($result->num_rows == 1){
          while($row = $result->fetch_assoc()){
              $merchant_id = $row["merchant_id"]; 
          } 
          return $merchant_id;
      } else {
          return 0;
      }
}


function getProductTypeId(){
    global $conn, $productTypeName;
    $sql = "SELECT product_type_id FROM product_types
    WHERE name = '$productTypeName';";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $product_type_id = $row["product_type_id"];
    }
    return $product_type_id;
}

function isLockEmpty() {
    global $conn, $saleDate;
    $market_lock_id = getMarketLockId();


    $sql =
    "SELECT reservation_status FROM market_lock_reservations
    WHERE market_lock_id = $market_lock_id
    AND sale_date = '$saleDate';";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $reservation_status = $row["reservation_status"];
    }

    if($reservation_status == 1){
        return true;
    } else {
        return false;
    }
}

function isMaximumMarketReserved(){
    global $conn, $MAXIMUN_RESERVED, $saleDate; 
    
    $merchant_id = getMerchantId();
    
    $sql = "SELECT count(*) FROM
    market_lock_reservations
    WHERE merchant_id = '$merchant_id'
    AND sale_date ='$saleDate';";
    
    $result = $conn->query($sql);
    return $result->num_rows;
    if ($result->num_rows > $MAXIMUN_RESERVED){
        return true;
    }  else {
        return false;
    }
}   
///////////////////////////////////////////  

$test = isMaximumMarketReserved();

echo $test;
// if(isMaximumMarketReserved()){
//     echo 2;
// }
// // เช็คว่าล็อคว่างหรือไม่ ถ้าว่างให้ดำเนินการจองได้
// else if (isLockEmpty() && getMerchantId() != 0){
//     $market_lock_id = getMarketLockId();
//     $merchant_id = getMerchantId();
//     $product_type_id = getProductTypeId();

//     $sql = "UPDATE market_lock_reservations
//     SET reservation_status = 2
//     , merchant_id = $merchant_id
//     , product_type_id = $product_type_id
//     WHERE market_lock_id = $market_lock_id
//     AND sale_date = '$saleDate';";
//     if($conn->query($sql)){
//         echo 1; 
//     } else {
//         echo 'query error';
//     }
    
   
// } else {
//     echo 0;
// }

$conn->close();
?>