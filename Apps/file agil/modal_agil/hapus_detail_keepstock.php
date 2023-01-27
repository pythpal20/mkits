<?php
// var_dump($_POST);
include '../../config/connection.php';
// declare
if (isset($_POST)) {
    $id = $_POST['id'];
   
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "DELETE  FROM keepstock WHERE id ='$id'";
   
  if ($db1->query($sql) === TRUE) {
    echo "1";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>