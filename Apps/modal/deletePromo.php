<?php 
// var_dump($_POST);
error_reporting(0);
include '../../config/connection.php';

$kueri = "UPDATE bundle_promo SET promo_status = '0' WHERE promo_id = '" . $_POST['id'] . "'";
$pcs = $db1->prepare($kueri);
$pcs-> execute();
$result = $pcs->get_result();
if($result->num_rows < 0) {
    echo '1';
} else {
    echo '0';
}