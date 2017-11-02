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

// เช็คว่าล็อกว่างหรือไม่ถ้าไม่ว่าง ให้ทำการโหลดข้อมูลล็อกมาแสดงผลแบบ JSON 
if (isLockEmpty()){
    echo 0;
} else {
    $market_lock_id = getMarketLockId();

    $sql = "SELECT market_locks.name AS lockName, merchants.name AS merchantName, merchants.phonenumber, product_types.name AS productType
    FROM market_lock_reservations
    JOIN market_locks ON market_lock_reservations.market_lock_id = market_locks.market_lock_id
    JOIN merchants ON market_lock_reservations.merchant_id = merchants.merchant_id
    JOIN product_types ON market_lock_reservations.product_type_id = product_types.product_type_id
    WHERE market_lock_reservations.market_lock_id = $market_lock_id
    AND market_lock_reservations.sale_date = '$saleDate';";

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $output[] = $row;
    }
    echo json_encode($output);
}
$conn->close();
?>