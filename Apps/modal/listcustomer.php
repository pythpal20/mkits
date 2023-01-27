<?php 
include '../../config/connection.php';


$ambil_sku ="SELECT customer_nama FROM master_customer" ;
$hasil_sku = mysqli_query($connect, $ambil_sku);
$html=[];
while ($row = mysqli_fetch_array($hasil_sku)) {
    array_push($html, $row['customer_nama']);
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($html) ;
?>