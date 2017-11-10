<?php
require 'connectDB.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM merchants
WHERE username = '$username'
AND password = '$password';";

$result = $conn->query($sql);

if ($result->num_rows == 1) {
	echo '1';
} else {
    echo '0';
}

$conn->close();
?>
