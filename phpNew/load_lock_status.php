<?php

require_once "connectDB.php";
// ค่าจากฝั่ง Android
//ส่งค่าสถานะล็อคที่ต้องการทราบ
$reservationStatus =$_POST['reservationStatus'];
$saleDate =$_POST['saleDate'];
$marketName =$_POST['marketName'];

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

///////////////////////////////////////////

$market_id = getMarketId();

$sql = "SELECT market_locks.name FROM market_lock_reservations
JOIN market_locks ON market_lock_reservations.market_lock_id = market_locks.market_lock_id
WHERE market_lock_reservations.reservation_status = '$reservationStatus'
AND market_locks.market_id = '$market_id'
AND market_lock_reservations.sale_date = '$saleDate';";


$result =$conn->query($sql);
while($row = $result->fetch_assoc()){
    $output[] = $row;
}

echo json_encode($output);


$conn->close();
?>