<?php
    include '../../config/connection.php';
    if (isset($_POST['id'])){
        // var_dump($_POST['id']);
        $noso   = $_POST['id'];
        $hdr = "DELETE FROM customerorder_hdr_pending WHERE noso = '$noso'";
        $mwk = $db1->prepare($hdr);
        $mwk -> execute();
        $resl = $mwk->get_result();
        if ($resl->num_rows > 0){
            echo "<script>alert('".$db1->error."');window.location.href = '../scomasuk.php';</script>";
        }else {
            $dtl = "DELETE FROM customerorder_dtl_pending WHERE noso = '$noso'";
            $mwk = $db1->prepare($dtl);
            $mwk -> execute();
            $res = $mwk-> get_result();
        }
    }
?>