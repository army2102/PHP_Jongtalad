<?php


Require_once 'connectDB.php';
$merchantUsername = $_POST['username'];
$merchantPicture = $_POST['pictureUrl'];

// Function list
/////////////////////////////////////////////////

function getMerchantId() {
    global $conn, $merchantUsername;
    
      $sql =
      "SELECT merchant_id FROM merchants
      WHERE username = '$merchantUsername';";
    
      $result =  $conn->query($sql);
      if($result->num_rows == 1){
          while($row = $result->fetch_assoc()){
              $merchant_id = $row["merchant_id"]; 
          } 
          return $merchant_id;
      } else {
          return 0;
      }
}

/////////////////////////////////////////////////



if(getMerchantId() != 0){
    $merchant_id = getMerchantId();

    $sql = "UPDATE merchants
    SET picture_url = '$merchantPicture'
    WHERE merchant_id = '$merchant_id'";

    if($conn->query($sql) == true){
        echo '1';
    } else {
        echo '0';
    }

} else {
    echo "This username ('$merchantUsername') doesn't in the  database";
}


$conn->close();
?>