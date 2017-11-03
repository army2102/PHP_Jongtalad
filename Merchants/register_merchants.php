<?php

require 'connectDB.php';

// ข้อมูลจากฝั่ง Android
// ข้อมูลของพ่อค้า / แม่ค้า
$idCard =$_POST['idCard'];
$name =$_POST['name'];
$surname =$_POST['surname'];
$phonenumber =$_POST['phonenumber'];
$username =$_POST['username'];
$password =$_POST['password'];

// Function list
///////////////////////////////////////////
function isUserInDatabase(){
    global $conn, $username;

    $sql = "SELECT username FROM merchants
    WHERE username = '$username';";
    $result = $conn->query($sql);
    if($result->num_rows >= 1){
        return true;
    } else {
        return false;
    }
}

function setMerchant(){
    global $conn, $name, $surname, $phonenumber, $idCard, $username, $password;

    $sql ="INSERT INTO merchants (name, surname, phonenumber,id_card,username,password)
    VALUES ('$name', '$surname', '$phonenumber','$idCard','$username','$password')";

    $conn->query($sql);
}


///////////////////////////////////////////

// ตรวจเช็คว่ามี Username นี้อยู่ใน Database แล้วหรือยังถ้ายังให้ทำการสมัครสมาชิกได้ (if)
// หากมี Username นี้อยู่ในระบบอยู่แล้วให้ ส่งค่า 0 กลับไปให้เลือก Username อื่น (else)
if (!isUserInDatabase()) {
    setMerchant();
    echo '1';
} else {
    echo '0';
}
$conn->close();
?>