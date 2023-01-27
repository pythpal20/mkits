<?php
include '../../config/connection.php';

$nama   = $_POST["nmcustomer"];
$idc    = $_POST["idcustomer"];
$noso   = $_POST["noso"];
$tglso  = $_POST["tglorder"];
$noco   = $_POST["noco"];
$tgl_co = $_POST["tglco"];
$tgl_krm = $_POST["tgldelivery"];
$isi     = $_POST["isi"];
$tindakan     = $_POST["tindakan"];
$userx = $_POST['userx'];


$query = "SELECT MAX(kode) AS idArr
FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(komplain_id, 16, 9) AS urutan FROM tb_komplain_hdr) AS tabel_a) AS table_b";
$mwk = $db1->prepare($query);
$mwk->execute();
$res1 = $mwk->get_result();
while ($sb = $res1->fetch_assoc()) {
    $urutan  = $sb['idArr'];
    $urutan = $urutan+1;
    $huruf = "DSO";
    $idPo = $huruf . "-" . "COMP" . date('ymd') ."-". sprintf("%04s", $urutan);
}

$idcomplain = $idPo;
$waktu = time();

$sql = "INSERT INTO tb_komplain_hdr (`komplain_id`, `customer_id`, `nama_customer`, `noso`, `tgl_noso`, `No_Co`, `tgl_Co`, `tgl_delivery`, `txt_komplain`, `txt_tindakan`, `date_created`, `sales`) 
VALUES ('$idcomplain', '$idc', '$nama', '$noso', '$tglso', '$noco', '$tgl_co', '$tgl_krm', '$isi', '$tindakan', '$waktu', '$userx')";
$pcs = $db1->prepare($sql);
$pcs->execute();
$hsl = $pcs->get_result();

$sql_dua = "UPDATE customerorder_hdr_delivery SET komplain = '1' WHERE No_Co = '$noco'";
$pcs = $db1->prepare($sql_dua);
$pcs->execute();
$hsl_dia = $pcs->get_result();

echo $idcomplain;