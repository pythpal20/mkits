<?php
// var_dump($_POST);
date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
// declare
if (isset($_POST)) {
    $noso = $_POST['noso'];
    $qty_req = $_POST['jml'];
    $qty_po = $_POST['qty_po'];
    $sku = $_POST['sku'];
    $no_keep = $_POST['no_keep'];
    $ket_qty = $_POST['ket'];
    $customer = $_POST['customer'];
    $sales = $_POST['sales'];
    $telegramSales = $_POST['telegramSales'];
    $user = $_POST['user'];
    $duedate = date("y-m-d",strtotime($_POST['duedate']));
    $date = date("Y-m-d H:i:s");
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "INSERT INTO keepstock (noso, qty_po, qty_req, model,no_keepstock, customer, sales, telegramsales, user, duedate, keterangan_qty, waktu_req)
  VALUES ('$noso','$qty_po', '$qty_req', '$sku','$no_keep','$customer','$sales','$telegramSales','$user' ,'$duedate','$ket_qty' ,'$date')";
   
  if ($db1->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>