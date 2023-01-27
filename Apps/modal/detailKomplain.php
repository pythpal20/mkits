<?php

include '../../config/connection.php';

$id = $_POST["intid"];
$model = $_POST["sku"];
$qty = $_POST["qty"];
$idcomplain = $_POST["idcomplain"];
$norut = $_POST["no_urut"];

if(isset($_POST['intid'])) {
    $sql = "INSERT INTO tb_komplain_dtl (`komplain_id`, `model`, `qty`, `sort`) 
    VALUES ('$idcomplain', '$model', '$qty', '$norut')";
    $pcs = $db1->prepare($sql);
    $pcs->execute();
    $hsl = $pcs->get_result();
}
