<?php
// SQL hapus
	error_reporting(0);
	include '../config/connection.php';
	$id = $_POST['id'];
	$query="UPDATE master_user SET status='0' WHERE user_id='$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$res1 = $mwk->get_result();
    // jika gagal
    if ($res1->num_rows > 0){
    	echo $db1->error;
    } else {
    	echo "OK, User berhasil dihapus..";
    }
?>