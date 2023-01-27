<?php
include '../../config/connection.php';
$id = $_POST['idcust'];
// var_dump($_POST);

$query = "SELECT customer_alamat, term, method FROM master_customer
WHERE customer_id = '$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl=$mwk->get_result();
while ($row=$resl->fetch_assoc()) {
	$data = array(
			'alamat'	=> $row['customer_alamat'],
			'term'		=> $row['term'],
			'method'	=> $row['method']);
}
//tampil data
echo json_encode($data);
?>