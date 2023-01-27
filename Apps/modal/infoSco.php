<?php 
    include '../../config/connection.php';
    $query = "SELECT ar_feedback, aproval_by FROM salesorder_hdr WHERE noso = '" . $_POST['id'] . "'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
    $row = $resl->fetch_assoc();
?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <i class="fa fa-warning"></i> SCO Pending!
    </div>
    <div class="panel-body">
        <p><?= $row['ar_feedback'] ?></p>
        <p>Pending oleh : <?= $row['aproval_by'] ?></p>
    </div>
</div>