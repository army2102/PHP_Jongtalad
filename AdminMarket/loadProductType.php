<?php
require 'connectDB.php';

$sql= "SELECT * FROM product_types;";

$result = $conn->query($sql);
if($result->num_rows > 0){
  while ($row = $result->fetch_assoc()) {
    # code...
    $output[] = $row;
  }
}

echo json_encode($output);

$conn->close();
?>
