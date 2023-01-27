<?php 
    include '../../config/connection.php';
    $query = "SELECT alasan_cancelsco, cancelsco_by FROM salesorder_hdr WHERE noso = '" . $_POST['id'] . "'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
    // $row = $resl->fetch_assoc();
    while($row = $resl->fetch_assoc()){
        $v = $row['alasan_cancelsco'] . '|' . $row['cancelsco_by'];
    }
    echo $v;
