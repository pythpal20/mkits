<?php
include '../../config/connection.php';

$id = $_POST["id"];

$sql = "UPDATE tb_komplain_hdr SET status = '1' WHERE komplain_id = '$id'";
$pcs = $db1->prepare($sql);
$pcs->execute();
$hsl = $pcs->get_result();
