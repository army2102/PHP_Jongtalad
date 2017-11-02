<?php
require 'connectDB.php';

$UserName =$_POST['username'];
$PassWord =$_POST['password'];

$sql= "SELECT * FROM merchants
WHERE username = '$UserName'
AND password = '$PassWord';";

$result =$conn->query($sql);

if ($result->num_rows==1 ) {
   echo '1';
} else {
    echo '0';
}

$conn->close();


?>