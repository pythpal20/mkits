<?php 
include '../../config/connection.php';


$ambil_sku ="SELECT fpp_id FROM master_fpp" ;
$hasil_sku = mysqli_query($connect, $ambil_sku);
$html=[];
while ($row = mysqli_fetch_array($hasil_sku)) {
    array_push($html, $row['fpp_id']);
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($html) ;
?>