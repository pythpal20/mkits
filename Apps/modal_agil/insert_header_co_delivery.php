<?php
// var_dump($_POST);
date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
// declare
if (isset($_POST)) {
    $noco = $_POST['noco'];
    $noso = $_POST['noso'];
    $nosh = $_POST['nosh'];
    $nobl = $_POST['nobl'];
    $nofa = $_POST['nofa'];
    $customer = $_POST['customer'];
    $customer_id = $_POST['customer_id'];
    $alamat = $_POST['alamat'];
    $alasan = $_POST['alasan'];
    if ($alasan == 0) {
      $alasan = "";
    }else if ($alasan == 1) {
      $alasan = "Customer merasa tidak pesan";
      # code...
    }else if ($alasan == 2) {
      $alasan = "Minta TOP";
      # code...
    }else if ($alasan == 3) {
      $alasan = "SKU/ Barang salah Bawa";
      # code...
    }else if ($alasan ==4) {
      $alasan = "Toko Tutup";
      # code...
    }else if ($alasan == 5) {
      # code...
      $alasan = "Qty Kurang";
    }else  if ($alasan == 6){
      $alasan = "Perubahan pembayaran";
      
    }else  if ($alasan == 7){
      $alasan = "Pengiriman terlalu lama";
      
    }else  if ($alasan == 8){
      $alasan = "Customer tidak ada budget";
      
    }else{
      $alasan = "Tukar Sku Berbeda";

    }
    
    
    $kenek = $_POST['kenek'];
    $nopol = $_POST['nopol'];
    $sopir = $_POST['sopir'];
    $jenis = $_POST['jenis'];
    $status_delivery = "1";
    $tgl_delivery = date("Y-m-d H:i:s");



    if ($alasan != "") {
      $status_delivery = "2";
      $nofa = $nofa."-R";
    } else {
     
    }
}

// Check connection
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
  }
  
  $sql = "INSERT INTO customerorder_hdr_delivery (No_Co, noso, no_sh, no_bl,no_fa, customer_nama, alamat_krm, customer_id, status_delivery, alasan, kenek,sopir, nopol, jenis, tgl_delivery)
  VALUES ('$noco','$noso', '$nosh', '$nobl','$nofa','$customer','$alamat','$customer_id','$status_delivery','$alasan','$kenek','$sopir','$nopol','$jenis','$tgl_delivery')";
   
   $update_hdr_co_existing = "UPDATE customerorder_hdr SET status_delivery='1' WHERE No_Co='$noco' ";
  
  if ($db1->query($update_hdr_co_existing) === TRUE) { 
    echo "update successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }

  if ($db1->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db1->error;
  }
  
  $db1->close();
  
?>