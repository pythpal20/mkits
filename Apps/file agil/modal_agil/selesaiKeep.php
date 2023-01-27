<?php
var_dump($_POST);
date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
// declare
if (isset($_POST)) {
    $id = $_POST['id'];
    $user = $_POST['user'];
    $sh = $_POST['sh'];
    $date = date("Y-m-d h:i:s");
    
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "UPDATE keepstock SET  status_keep = '2',waktu_selesai = '$date', no_sh = '$sh', user_selesai='$user' WHERE no_keepstock='$id' ";
  
  if ($db1->query($sql) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>