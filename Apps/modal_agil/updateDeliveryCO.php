<?php
include '../../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST)) {
    $bl = $_POST['bl'];
    $date = date("Y-m-d", strtotime($_POST['tanggal']));
    
 
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
//   status 2 reschedule
  $sql = "UPDATE customerorder_hdr SET status_delivery='2', tgl_rescedhule='$date' WHERE no_bl='$bl' ";
  
  if ($db1->query($sql) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();