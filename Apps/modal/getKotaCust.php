<?php
include '../../config/connection.php';
$id = $_POST['nama'];
// var_dump($_POST);

$query = "SELECT b.wilayah_nama, a.customer_alamat FROM master_customer a 
JOIN master_wilayah b ON a.customer_kota = b.wilayah_id
WHERE a.customer_nama = '$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl=$mwk->get_result();
while ($row=$resl->fetch_assoc()) {
	$data = array(
			'wilayah_nama'	=> $row['wilayah_nama'],
            'alamat'        => $row['customer_alamat']);
}
//tampil data
echo json_encode($data);
?>