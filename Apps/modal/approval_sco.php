<?php 
    include '../../config/connection.php';
    session_start();
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $reslt = $mwk->get_result();
    $data = $reslt->fetch_assoc(); 

    date_default_timezone_set('Asia/Jakarta');
    $updatetime = date('Y-m-d H:i:s');
    
	error_reporting(0);
	// var_dump($_POST);die();
    if(!isset($_POST)){
        echo 'Tidak ada data yang disimpan!';
    } else {
            $sql = "UPDATE salesorder_hdr
            SET status = '2', cancelsco_by = '".$data['user_nama']."' , aproval_date = '$updatetime', alasan_cancelsco='".$_POST['feedback']."'
            WHERE noso = '" . $_POST['id'] . "' ";
            $mwk = $db1 -> prepare($sql);
            $mwk -> execute();
            $resl = $mwk->get_result();
            if($resl->num_rows > 0) {
                echo 'Gagal Pending';
            } else {
                echo 'SCO akan di Pending';
            }
    }
?>