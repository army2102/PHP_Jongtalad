<?php

require_once 'connectDB.php';

$sql = "SELECT * FROM markets;";

$result = $conn->query($sql);

if ($result->num_rows >= 1){
    while($row = $result->fetch_assoc()){
        $output[] = $row;
    }
}

echo json_encode($output);

?>