<?php
include '../../config/connection.php';
$id = $_POST['id'];
$sku = $_POST['sku'];

$query = "SELECT * FROM bundle_promo_dtl
WHERE promo_id = '$id' AND model = '$sku'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl = $mwk->get_result();
while ($row = $resl->fetch_assoc()) {
	$data = array(
		'hargadef'	=> $row['harga_default'],
		'discount'		=> $row['diskon'],
		'harga_disc'	=> $row['harga_promo'],
		'disc_percent'  => $row['disc_percent'],
		'qty_min'   	=> $row['promo_qty'],
	);
}
//tampil data
echo json_encode($data);