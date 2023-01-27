<?php
include '../../config/connection.php';
$id = $_POST['id'];

$query = "SELECT b.promo_id, a.promo_name, a.promo_jenis FROM bundle_promo a 
        JOIN bundle_promo_dtl b ON a.promo_id = b.promo_id 
        WHERE b.model LIKE '$id' AND a.promo_status = '1'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl = $mwk->get_result();
if ($resl->num_rows > 0) {
    while ($row = $resl->fetch_assoc()) {
        echo '<option value=""></option>';
        echo '<option value="' . $row['promo_id'] . "|" .  $row['promo_jenis'] . '">' . strtoupper($row['promo_name']) . '</option>';
    }
} else {
    echo '<option value="">Tidak Ada Promo</option>';
}