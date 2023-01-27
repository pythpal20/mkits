<?php
include '../../config/connection.php';
// var_dump($_POST);

if(!isset($_POST['searchSku'])){ 
  $fetchData = mysqli_query($connect,"SELECT * FROM master_produk WHERE status = '1' ORDER BY model ASC LIMIT 15");
}else{ 
  $search = $_POST['searchSku'];   
  $fetchData = mysqli_query($connect,"SELECT * FROM master_produk WHERE status = '1' AND model LIKE '%".$search."%' OR barcode LIKE '%".$search."%' LIMIT 15");
} 

$data = array();
while ($row = mysqli_fetch_array($fetchData)) {    
  $data[] = array("id"=>$row['model'], "text"=>$row['model']);
}
//tampil data
echo json_encode($data);
?>