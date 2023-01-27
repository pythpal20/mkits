<?php
include '../../config/connection.php';
$id = $_POST['idcust'];
// var_dump($_POST);

$query = "SELECT detail_alamat, pic, CONCAT(notelp, ' / ', nohp) AS kontak FROM temp_customer
WHERE ID = '$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl=$mwk->get_result();
while ($row=$resl->fetch_assoc()) {
	$data = array(
			'alamat'	=> $row['detail_alamat'],
			'pic'		=> $row['pic'],
            'kontak'    => $row['kontak']);
}
//tampil data
echo json_encode($data);
?>