<?php 
    include '../../config/connection.php';
    session_start();
    $modul = $_SESSION['moduls'];
    // var_dump($modul);
    if ($modul == '2') {
        $sql1 = "SELECT COUNT(a.idPts) AS unprocessed FROM pts_header a 
        JOIN pts_detail b ON a.idPts = b.idPts 
        WHERE app_akunting = '0' AND amount IS NOT NULL";
        $mwk = $db1->prepare($sql1);
        $mwk -> execute();
        $res1 = $mwk->get_result();
        while ($row1 = $res1->fetch_assoc()) {
            $data = array(
                    'countID'	=> $row1['unprocessed']);
        }
    } elseif($modul == '3') {
        $sql1 = "SELECT COUNT(a.idPts) AS unprocessed FROM pts_header a 
        JOIN pts_detail b ON a.idPts = b.idPts 
        WHERE app_admin = '0' AND amount IS NOT NULL";
        $mwk = $db1->prepare($sql1);
        $mwk -> execute();
        $res1 = $mwk->get_result();
        while ($row1 = $res1->fetch_assoc()) {
            $data = array(
                    'countID'	=> $row1['unprocessed']);
        }
    } elseif ($modul == '1') {
        $sql1 = "SELECT COUNT(noso) AS unprocessed FROM salesorder_hdr WHERE status = '0' ";
        $mwk = $db1->prepare($sql1);
        $mwk -> execute();
        $res1 = $mwk->get_result();
        while ($row1 = $res1->fetch_assoc()) {
            $data = array(
                    'countID'	=> $row1['unprocessed']);
        }
    }
    //tampil data
    echo json_encode($data);
?>