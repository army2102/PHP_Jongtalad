<?php
$servername = "localhost";
$username = "cp821884_maxz";
$password = "mwRo3B-w^9mE";
$dbname = "cp821884_jongtalad_production";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,'utf8');

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
