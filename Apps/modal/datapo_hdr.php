<?php
include '../../config/connection.php';
date_default_timezone_set('Asia/Jakarta');
$cekTgl = date('ymd');

$query = "SELECT MAX(kode) AS idArr
FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(noso, 10, 9) AS urutan FROM salesorder_hdr) AS tabel_a) AS table_b";
$mwk = $db1->prepare($query);
$mwk->execute();
$res1 = $mwk->get_result();
while ($sb = $res1->fetch_assoc()) {
    $urutan  = $sb['idArr'];
    $urutan = $urutan+1;
    $huruf = "SO";
    $idPo = $huruf . $cekTgl ."-". sprintf("%03s", $urutan);
}
$nopo = $idPo;
$customer = $_POST['customer'];
if ($_POST['jTrans'] == 'SHOWROOM') {
    $tanggal = date('Y-m-d');
    $waktu = date('H:i:s');
} elseif ($_POST['jTrans'] == 'MARKETPLACE') {
    $getwaktu = date('H:i');
    if ($getwaktu > '16:15') {
        $tanggal = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
        $waktu = '08:15:00';
    } else {
        $tanggal=date('Y-m-d');
        $waktu = date('H:i:s');
    }
} else {
    $getwaktu = date('H:i');
    if ($getwaktu > '14:55') {
        $tanggal = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
        $waktu = '08:15:00';
    } else {
        $tanggal=date('Y-m-d');
        $waktu = date('H:i:s');
    }
}

if(isset($_POST['pengajuan'])){
    $pnj = '1';
} else {
    $pnj = '0';
}

$alamat_kirim = $_POST['alamatKirim'];
$perusahaan = $_POST['jenisPerusahaan'];
$nopo_ref = $_POST['nopo_ref'];
$sales = $_POST['sales'];
$ongkir = $_POST['ongkir'];
$keterangan = $_POST['keterangan'];
$term = $_POST['top'];
$tgl_krm = $_POST['tglkirim'];
$jTrans = $_POST['jTrans'];
$statcust = $_POST['statcust'];
$method = $_POST['method'];

$sql = "UPDATE master_customer SET status = '$statcust' WHERE customer_id ='$customer'";
$result_sql =mysqli_query($connect,$sql);

$nama = "SELECT customer_nama FROM master_customer WHERE customer_id = '$customer'";
$mwk = $db1->prepare($nama);
$mwk -> execute();
$res = $mwk->get_result();
$dtn = $res->fetch_assoc();
$nama_customer = $dtn['customer_nama'];

$query = "INSERT INTO salesorder_hdr ( noso, tgl_po,customer_id,alamat_krm, id_perusahaan, term, noso_ref, sales, ongkir, keterangan, tgl_krm, jenis_transaksi, wkt_po, req_harga, method)
   VALUES
   ( '$nopo', '$tanggal','$customer','$alamat_kirim','$perusahaan', '$term', '$nopo_ref','$sales','$ongkir','$keterangan', '$tgl_krm', '$jTrans', '$waktu', '$pnj', '$method')";
$hasil = mysqli_query($connect, $query);

echo $nopo."|".$nama_customer;
?>