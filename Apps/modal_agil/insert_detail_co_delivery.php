<?php
// var_dump($_POST);die();
date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
// declare
if (isset($_POST)) {
    $ppn = $_POST['ppn'];
    $diskon = $_POST['diskon'];
    $no_urut = $_POST['no_urut'];
    $qty_request = $_POST['qty_request'];
    $qty_kirim = $_POST['qty_kirim'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $harga_total = $_POST['harga_total'];
    $No_Co = $_POST['No_Co'];
    $model = $_POST['model'];
    $tgl_delivery = date("Y-m-d H:i:s");
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "INSERT INTO customerorder_dtl_delivery (No_Co, model, qty_request, qty_kirim,price, diskon, ppn,amount,harga_total,no_urut,tgl_delivery)
  VALUES ('$No_Co','$model', '$qty_request', '$qty_kirim','$price','$diskon','$ppn','$amount','$harga_total','$no_urut','$tgl_delivery')";
   
  if ($db1->query($sql) === TRUE) {
    echo "detail successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>