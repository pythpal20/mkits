<?php
// var_dump($_POST);
date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
// declare
if (isset($_POST)) {
    $noso = $_POST['noso'];
    $qty_req = $_POST['jml'];
    $sku = $_POST['sku'];
    $no_keep = $_POST['no_keep'];
    $customer = $_POST['customer'];
    $user = $_POST['user'];
    $duedate = date("y-m-d",strtotime($_POST['duedate']));
   
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "INSERT INTO keepstock (noso, qty_req, model,no_keepstock, customer, user, duedate)
  VALUES ('$noso', '$qty_req', '$sku','$no_keep','$customer','$user' ,'$duedate')";
   
  if ($db1->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>