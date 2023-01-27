<?php

include '../../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
$query_alasan = "";
$query_duedate="";
if (isset($_POST)) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    if (isset($_POST['alasan'])) {
      $alasan = $_POST['alasan'];
      $query_alasan=", alasan_qty_sisa='$alasan'";
    }
    $duedate = null;
    if (isset($_POST['duedate'])) {
      $duedate = date("Y-m-d", strtotime($_POST['duedate']));
      $query_duedate = "duedate_kembali='$duedate',";
    } 
    
    $qty_sisa_diterima = $_POST['qty_sisa_diterima'];
    
    
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "UPDATE customerorder_dtl_delivery SET status_gudang='$status',  $query_duedate  qty_sisa_diterima='$qty_sisa_diterima' $query_alasan WHERE id='$id' ";
  
  if ($db1->query($sql) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();


?>