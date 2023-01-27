<?php
var_dump($_POST);
include '../../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST)) {
    $id = $_POST['id'];
    $alasan = $_POST['alasan'];
    $user = $_POST['user'];
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "UPDATE keepstock SET  status_keep='3', user_cancel='$user', alasan_cancel='$alasan' WHERE no_keepstock='$id' ";
  
  if ($db1->query($sql) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>