<?php 
    include '../../config/connection.php';
    $sql1 = "SELECT COUNT(noso) AS unprocessed FROM salesorder_hdr WHERE status = '1' AND aproval_finance = '0'";
    $mwk = $db1->prepare($sql1);
    $mwk -> execute();
    $res1 = $mwk->get_result();
    while ($row1 = $res1->fetch_assoc()) {
        $data = array(
                'dataun'	=> $row1['unprocessed']);
    }
    //tampil data
    echo json_encode($data);
?>