<?php
error_reporting(0);
include '../../config/connection.php';
$awal = $_POST['tglawal'];
$akhir = $_POST['tglakhir'];
$no = 1;
$query = "SELECT * FROM master_fpp mf
	JOIN fpp_detail fd ON mf.fpp_id = fd.fpp_id
	JOIN master_customer mc ON mf.customer_id = mc.customer_id
	JOIN master_wilayah mw ON mc.customer_kota = mw.wilayah_id
	WHERE mf.fpp_tanggal BETWEEN '$awal' AND '$akhir'
	ORDER BY mf.fpp_tanggal";
$mwk = $db1->prepare($query);
$mwk -> execute();
$resl = $mwk->get_result();
$data_html = '<h5>Data Pengajuan Perubahan PO '.$awal.' Sampai '.$akhir.'</h5>
<table border="1">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. FPP</th>
			<th>Tgl. FPP</th>
			<th>No. SO</th>
			<th>Tgl. SO</th>
			<th>Nama Customer</th>
			<th>Kota</th>
			<th>Sales</th>
			<th>SKU</th>
			<th>Qty</th>
			<th colspan="8">Alasan Perubahan</th>
			<th colspan="6">Tindak Lanjut Perubahan PO</th>
			<th>Catatan</th>
			<th>Tgl. Aproval</th>
		</tr>
	</thead>
	<tbody>';
if ($resl->num_rows > 0) {
	while ($row=$resl->fetch_assoc()) {
$data_html .="
<tr>
	<td>".$no++."</td>
	<td>".$row['fpp_id']."</td>
	<td>".$row['fpp_tanggal']."</td>
	<td>".$row['noso']."</td>
	<td>".$row['tgl_po']."</td>
	<td>".$row['customer_nama']."</td>
	<td>".$row['wilayah_nama']."</td>
	<td>".$row['inputby']."</td>
	<td>".$row['model']."</td>
	<td>".$row['qty']."</td>
	<td>".$row['alasan1']."</td>
	<td>".$row['alasan2']."</td>
	<td>".$row['alasan3']."</td>
	<td>".$row['alasan4']."</td>
	<td>".$row['alasan5']."</td>
	<td>".$row['alasan6']."</td>
	<td>".$row['alasan7']."</td>
	<td>".$row['alasan_lain']."</td>
	<td>".$row['proses1']."</td>
	<td>".$row['proses2']."</td>
	<td>".$row['proses3']."</td>
	<td>".$row['proses4']."</td>
	<td>".$row['proses5']."</td>
	<td>".$row['proses_lain']."</td>
	<td>".$row['catatan']."</td>
	<td>".$row['tgl_aprove']."</td>
</tr>";
}
} else {
$data_html .='<tr>
	<td colspan="26">Data tidak ditemukan</td>
</tr>';
}
$data_html .="</tbody></table>";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data FPP ".$awal." sampai ".$akhir.".xls");
echo $data_html;