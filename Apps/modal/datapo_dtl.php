<?php 
include '../../config/connection.php';
date_default_timezone_set('Asia/Jakarta');
$jTrans  = $_POST['jTrans'];
if ($_POST['jTrans'] == 'SHOWROOM') {
   $tanggal = date('Y-m-d');
} elseif ($_POST['jTrans'] == 'MARKETPLACE') {
   $getwaktu = date('H:i');
   if ($getwaktu > '16:15') {
       $tanggal = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
   } else {
       $tanggal=date('Y-m-d');
   }
} else {
   $getwaktu = date('H:i');
   if ($getwaktu > '14:55') {
       $tanggal = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
   } else {
       $tanggal=date('Y-m-d');
   }
}
$nopo = $_POST['nopo'];
$sku = $_POST['sku'];
$prdHarga = $_POST['prdHarga'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$amount = $_POST['amount'];
$diskon = $_POST['nominal_discount'];
$harga_total = $_POST['harga_total'];
$ppn = $_POST['hitungan_ppn'];
$ket = $_POST['ket'];
$no_urut = $_POST['no_urut'];
$hrg_pengajuan = $_POST['hrg_pengajuan'];

$idprom = $_POST['dsopromo'];
$dsopromo = explode("|", $idprom)[0];
var_dump($dsopromo);

$query = "INSERT INTO salesorder_dtl ( noso, tgl_po,harga_ref,model,qty,price,amount,ppn,harga_total,diskon, keterangan, no_urut, harga_request, promo_id)
   VALUES
   ( '$nopo', '$tanggal','$prdHarga','$sku','$qty','$harga','$amount','$ppn','$harga_total','$diskon', '$ket', '$no_urut', '$hrg_pengajuan', '$dsopromo')";
mysqli_query($connect, $query);

?>