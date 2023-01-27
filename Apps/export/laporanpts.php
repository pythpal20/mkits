<?php
    error_reporting();
	include '../../config/connection.php';

    $awal = $_POST['tglawal'];
	$akhir = $_POST['tglakhir'];
	$status = $_POST['status'];
    $no = 1;

    $sts = '%' . $status . '%';
    $tglawal = '%' . $awal . '%';
    $tglakhir = '%' . $akhir . '%';
	$query = "SELECT a.idPts, a.tgl_create, REPLACE(REPLACE(REPLACE(a.status,'1','Kembali'),'2','Tidak Kembali'),'3', 'Dibeli') AS statuss, a.tgl_ambil, a.tgl_kembali,
	    a.keterangan_beli, a.customer_nama, a.alamat, a.kota, b.model, b.qty, b.harga, b.amount, a.sales, a.keterangan, c.deskripsi
    FROM pts_header a
    JOIN pts_detail b ON a.idPts = b.idPts
    JOIN master_produk c ON b.model = c.model
    WHERE a.status LIKE '$sts' AND app_admin = '1' AND app_akunting = '1' AND a.tgl_create BETWEEN '$awal' AND '$akhir'
	ORDER BY a.idPts DESC, a.tgl_create DESC";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$reslt = $mwk->get_result();
$html = '<table style="border: 1px solid black" border="1" width="100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Sales</th>
            <th>Code Barang</th>
            <th>No. PTS</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Perusahaan</th>
            <th>Tanggal Ambil</th>
            <th>Jatuh tempo</th>
            <th>Realisasi</th>
            <th>Keterangan</th>
            <th>SK/BK</th>
        </tr>
    </thead>
    <tbody>';
    while($row = $reslt->fetch_assoc()) { 
        $html .= '<tr>
            <td>' .  $no++  . '</td>
            <td>' .  $row["sales"]  . '</td>
            <td>' .  $row["model"]  . '</td>
            <td>' .  $row["idPts"]  . '</td>
            <td>' .  $row["deskripsi"]  . '</td>
            <td>' .  $row["qty"]  . '</td>
            <td>' .  $row["customer_nama"]  . '</td>
            <td>' .  date_format(date_create($row["tgl_ambil"]), "d F Y")  . '</td>
            <td>' .  $row["tgl_kembali"]  . '</td>
            <td></td>
            <td>' .  $row["statuss"]  . '</td>
            <td></td>
        </tr>';
    }
$html .= '</tbody>
</table>';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data FULL ".$awal." sampai ".$akhir.".xls");
echo $html;
?>