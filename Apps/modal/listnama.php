<?php 
include '../../config/connection.php';


$ambilNama ="SELECT customer_nama FROM temp_customer" ;
$hasilNama = mysqli_query($connect, $ambilNama);
$html=[];
while ($row = mysqli_fetch_array($hasilNama)) {
    array_push($html, $row['customer_nama']);
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($html) ;
?>