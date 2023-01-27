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
        if($_POST['sts'] == 1){
            $sql = "UPDATE salesorder_hdr 
            SET aproval_finance = '" . $_POST['sts'] ."', aproval_by = '".$data['user_nama']."' , aproval_date = '$updatetime'
            WHERE noso = '" . $_POST['id'] . "' ";
            $mwk = $db1 -> prepare($sql);
            $mwk -> execute();
            $resl = $mwk->get_result();
            if($resl->num_rows > 0) {
                echo 'Gagal Approval';
            } else {
                echo 'Approval Berhasil';
            }
        } elseif($_POST['sts'] == 2) {
            $sql = "UPDATE salesorder_hdr
            SET aproval_finance = '" . $_POST['sts'] ."', aproval_by = '".$data['user_nama']."' , aproval_date = '$updatetime', ar_feedback='".$_POST['feedback']."'
            WHERE noso = '" . $_POST['id'] . "' ";
            $mwk = $db1 -> prepare($sql);
            $mwk -> execute();
            $resl = $mwk->get_result();
            if($resl->num_rows > 0) {
                echo 'Gagal Pending';
            } else {
                echo 'SCO akan di Pending';
            }
        } elseif($_POST['sts'] == 3) {
            $sql = "UPDATE salesorder_hdr
            SET aproval_finance = '" . $_POST['sts'] ."', aproval_by = '".$data['user_nama']."' , aproval_date = '$updatetime', ar_feedback='".$_POST['feedback']."'
            WHERE noso = '" . $_POST['id'] . "' ";
            $mwk = $db1 -> prepare($sql);
            $mwk -> execute();
            $resl = $mwk->get_result();
            if($resl->num_rows > 0) {
                echo 'Gagal Cancel';
            } else {
                echo 'Cancel Berhasil';
            }
        } else {
            echo 'Tidak ada Data yang diproses';
        }
    }
?>