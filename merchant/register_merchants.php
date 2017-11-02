<?php

require 'connectDB.php';

$ID_Card =$_POST['id_card'];
$Name =$_POST['name'];
$Surname =$_POST['surname'];
$Phone =$_POST['phone'];
$Username =$_POST['username'];
$PassWord =$_POST['password'];

$sql ="INSERT INTO merchants (name, surname, phonenumber,id_card,username,password)
VALUES ('$Name', '$Surname', '$Phone','$ID_Card','$Username','$PassWord')";

if ($conn->query($sql) === TRUE) {
    echo "Done";
} else {
    echo "False";
}







$conn->close();
?>