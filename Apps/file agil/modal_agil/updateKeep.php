<?php
var_dump($_POST);
include '../../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST)) {
    $id = $_POST['id'];
    $qty_keep = $_POST['qty_keep'];
    $qty_req = $_POST['qty_req'];
    $user = $_POST['user'];
    $status_keep = $_POST['status_keep'];
    $no_keepstock = $_POST['no_keepstock'];
    $date = date("Y-m-d h:i:s");
    
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "UPDATE keepstock SET qty_keep='$qty_keep', status_keep='$status_keep',waktu_keep = '$date',user_keep='$user' WHERE id='$id' ";
  
  if ($db1->query($sql) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>