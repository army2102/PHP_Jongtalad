<?php

require_once "connectDB.php";

// ข้อมูลจากฝั่ง Android
// ข้อมูลของผู้ดูแลตลาด
$name = $_POST['name'];
$surname = $_POST['surname'];
$phonenumber = $_POST['phonenumber'];

// ข้อมูลของตลาด
$marketName = $_POST['marketName']; 
$marketAddress = $_POST['marketAddress'];

// Function list
///////////////////////////////////////////

function getMarketAdminId() {
    global $conn, $name, $surname, $phonenumber;
    
      $sql =
      "SELECT market_admin_id FROM market_admins
      WHERE name = '$name'
      AND surname = '$surname'
      AND phonenumber = '$phonenumber';";
    
      $result =  $conn->query($sql);
      if($result->num_rows == 1){
          while($row = $result->fetch_assoc()){
              $market_admin_id = $row["market_admin_id"]; 
          } 
          return $market_admin_id;
      } else {
          return 0;
      }
}

function setMarketAdminId(){
    global $conn, $name, $surname, $phonenumber;
    $sql = "INSERT INTO market_admins (name, surname, phonenumber)
    VALUES ('$name', '$surname', '$phonenumber');";
    $conn->query($sql);
}

function getMarketId() {
    global $conn, $marketName, $marketAddress;
    
      $sql =
      "SELECT market_id FROM markets
      WHERE name = '$marketName'
      AND address = '$marketAddress';";
    
      $result =  $conn->query($sql);
      if($result->num_rows == 1){
          while($row = $result->fetch_assoc()){
              $market_id = $row["market_id"]; 
          } 
          return $market_id;
      } else {
          return 0;
      }
}

function setMarketId(){
    global $conn, $marketName, $marketAddress;
    $sql = "INSERT INTO markets (name, address)
    VALUES ('$marketName', '$marketAddress');";
    $conn->query($sql);
}

///////////////////////////////////////////

// เช็คว่ามีตลาดที่ทำการสมัครมาอยู่ใน Database หรือไม่ถ้าไม่มีให้ทำการ Insert (if)
// แต่ถ้าหากตลาดนี้มีอยู่ใน Database แล้วให้ส่งค่ากลับไปว่าตลาดนี้มีอยู่ในระบบแล้ว อยู่ในสถานะ "รอลงพื้นที่" (else)
if (getMarketId() == 0){
    if(getMarketAdminId() == 0){
        setMarketAdminId();
    }
    setMarketId();
    $market_id = getMarketId();
    $market_admin_id = getMarketAdminId();
    
    $sql= "INSERT INTO market_admin_markets (market_id, market_admin_id)
    VALUES ($market_id, $market_admin_id);";
    $conn->query($sql);
    echo 1;
} else {
    echo 0;
}
$conn->close();
?>