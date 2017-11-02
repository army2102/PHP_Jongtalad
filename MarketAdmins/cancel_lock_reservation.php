<?php

require_once "connectDB.php";

// ข้อมูลจากฝั่ง Android
// ข้อมูลเกี่ยวกับล็อก
$marketName = $_POST['marketName']; 
$lockName = $_POST['lockName'];
$saleDate = $_POST['saleDate'];

// Function list
///////////////////////////////////////////

function getMarketId(){
    global $conn, $marketName;

    $sql = "SELECT market_id FROM markets
    WHERE name = '$marketName';";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
        $market_id = $row["market_id"];
    }
    return $market_id;
}

function getMarketLockId(){
    global $conn, $lockName;
    $market_id = getMarketId();

    $sql = "SELECT market_lock_id FROM market_locks
    WHERE market_id = $market_id
    AND name = '$lockName';";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
        $market_lock_id = $row["market_lock_id"];
    }
    return $market_lock_id;
}

function isLockEmpty(){
    global $conn, $saleDate;
    $market_lock_id = getMarketLockId();

    $sql = "SELECT reservation_status FROM market_lock_reservations
    WHERE market_lock_id = $market_lock_id
    AND sale_date = '$saleDate';";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $reservation_status = $row["reservation_status"];
    }

    if ($reservation_status == 1){
        return true;
    } else {
        return false;
    }
}

///////////////////////////////////////////

// เช็คว่าล็อกว่างหรือไม่ถ้าไม่ว่างให้ทำการยกเลิกการจองได้
if (isLockEmpty()){
    echo 0;
} else {
    $market_lock_id = getMarketLockId();

    // ทำการเปลี่ยนสถานะล็อกเป็น "ยกเลิก"
    $sql = "UPDATE market_lock_reservations
    SET reservation_status = 5
    WHERE market_lock_id = $market_lock_id
    AND sale_date = '$saleDate';";
    $conn->query($sql);

    // ทำการเพิ่ม Record ของล็อกเข้าไปใหม่เพื่อให้สามารถจองได้ใหม่
    $sql = "INSERT INTO market_lock_reservations (market_lock_id, sale_date, reservation_status)
    VALUES ($market_lock_id, '$saleDate', 1);";
    $conn->query($sql);

    echo 1;
}




?>