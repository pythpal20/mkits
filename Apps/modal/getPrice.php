<?php 
include '../../config/connection.php';
// $connect = mysqli_connect("localhost", "root", "", "db_customer");
$model = $_POST['sku4'];
$ambil_sku ="SELECT harga FROM master_produk WHERE model = '$model' " ;
$hasil_sku = mysqli_query($connect, $ambil_sku);
$html=[];
while ($row = mysqli_fetch_array($hasil_sku)) {
    array_push($html, $row['harga']);
}
echo json_encode($html) ;
	// $sumber = 'http://horekadepot.com/stokgudang/API/get_data.php';
	// $response = file_get_contents($sumber);
	// $arr = json_decode($response, true);
	// $html=[];
	// foreach($arr as $key){
	// 	if($key['sku']==$model){
	// 		array_push($html, $key['harga']);
	// 	}
	// }
	// echo json_encode($html);
?>