<?php

require 'connectDB.php';

$username = $_POST['username'];

$sql = "SELECT name, surname, phonenumber, picture_url FROM merchants
WHERE username = '$username' ;";

$result = $conn->query($sql);
if ($result -> num_rows == 1){
    while ($row = $result->fetch_assoc()){
        $output[] = $row;
    }
}

echo json_encode($output);

$conn->close();
?>