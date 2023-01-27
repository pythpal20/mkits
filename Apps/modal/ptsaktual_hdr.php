<?php 
    include '../../config/connection.php';
    // var_dump($_POST); die();
    $admin = $_POST['wrh'];
    $idPTS = $_POST['idPTS'];
    
    if (isset($_POST['wrh'])) {
        if ($_POST['jenis'] == '1') { //barang tidak kembali
        
            $times = date('Y-m-d H:m:s');
            $query1 = "UPDATE pts_header SET app_wrh = '1', date_wrh = '$times', wrh = '$admin' WHERE idPts = '$idPTS'";
            $mwk = $db1->prepare($query1);
            $mwk -> execute();
            $resl1 = $mwk->get_result();
            
        } elseif($_POST['jenis'] == '2'){ //tidak kembali
        
            $times = date('Y-m-d H:m:s');
            $query2 = "UPDATE pts_header SET app_wrh = '1', date_wrh = '$times', wrh = '$admin', complete = '1' WHERE idPts = '$idPTS'";
            $mwk = $db1->prepare($query2);
            $mwk -> execute();
            $resl2 = $mwk->get_result();
            
        } elseif($_POST['jenis'] == '3'){ //barang dibeli
        
            $times = date('Y-m-d H:m:s');
            $query3 = "UPDATE pts_header SET app_wrh = '1', date_wrh = '$times', wrh = '$admin' WHERE idPts = '$idPTS'";
            $mwk = $db1->prepare($query3);
            $mwk -> execute();
            $resl3 = $mwk->get_result();
            
        } else { //jika tidak semua nya
            $times = date('Y-m-d H:m:s');
            $query4 = "UPDATE pts_header SET app_wrh = '1', date_wrh = '$times', wrh = '$admin' WHERE idPts = '$idPTS'";
            $mwk = $db1->prepare($query4);
            $mwk -> execute();
            $resl4 = $mwk->get_result();
        }
    }
?>