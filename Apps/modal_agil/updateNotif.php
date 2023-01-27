<?php
var_dump($_POST);
include '../../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST)) {
    $notif = $_POST['notif'];
    $noso = $_POST['noso'];
    
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "UPDATE keepstock SET notif='$notif' WHERE noso='$noso' ";
  
  if ($db1->query($sql) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>