<?php 
include '../../config/connection.php';
$model = $_POST['sku4'];
$ambil_sku ="SELECT harga FROM master_produk WHERE model LIKE '$model' " ;
$hasil_sku = mysqli_query($connect, $ambil_sku);
$html=[];
while ($row = mysqli_fetch_array($hasil_sku)) {
    array_push($html, $row['harga']);
}
echo json_encode($html) ;