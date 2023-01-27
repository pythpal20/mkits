<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
include '../config/connection.php';
?>
<!DOCTYPE html>
<html>
<body>
	<style>
	table {
		font-size:0.850em
	}
	.t-table {
		border: 1px solid black; height: 430px; border-collapse: collapse;
	}
	.t-table td {
		border-left: 1px solid black;
		border-right: 1px solid black;
	}
	.t-table th {
		border: 1px solid black;
	}
	.t-table td:empty {
		border-left: 0;
		border-right: 0;
	}
</style>
<?php
	$id = $_GET['id'];
	$query = "SELECT  a.no_sh, a.tgl_order, a.customer_nama, a.alamat_krm, c.pic_nama, c.customer_telp, c.pic_kontak, a.ongkir, b.atasnama, b.nama_pt, a.noso, a.No_Co, a.no_fa, a.tgl_inv, b.nama_bank, b.rekening
	FROM customerorder_hdr a
	JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
	JOIN master_customer c ON a.customer_id = c.customer_id
	WHERE a.No_Co = '$id'";
	$mwk = $db1->prepare($query);
	$mwk -> execute();
	$resl = $mwk->get_result();
	$row = $resl->fetch_assoc();

	$qry = "SELECT SUM(amount) AS tAmt, SUM(ppn) AS tPjk, SUM(diskon) AS tDsc, SUM(harga_total) AS total FROM customerorder_dtl WHERE No_Co = '$id'";
	$mwk = $db1->prepare($qry);
	$mwk -> execute();
	$hsl = $mwk->get_result();
	$dtl = $hsl->fetch_assoc();

	$qryst = "SELECT a.noso_ref FROM salesorder_hdr a
	JOIN customerorder_hdr b ON a.noso = b.noso
	WHERE b.No_Co = '$id'";
	$mwk = $db1->prepare($qry);
	$mwk -> execute();
	$hsls = $mwk->get_result();
	$dtq = $hsls->fetch_assoc();

	$sqlquery = "SELECT * FROM customerorder_dtl a JOIN master_produk b ON a.model = b.model WHERE a.No_Co ='$id'";
	$mwk = $db1->prepare($sqlquery);
	$mwk->execute();
	$sql_hasil = $mwk->get_result();

?>
<table border = "0" width="100%">
	<tr>
		<td width="50%" style="text-align: left;vertical-align:top; ">
			<h3><?= $row['atasnama'] ; ?></h3>
		</td>
		<td width="50%" style="text-align: right;vertical-align:top; ">
			<p>
				<b>Invoice</b><br>
				<b>Ref. : <?php echo substr($row['no_fa'],4); ?></b><br>
				Invoice date : <?= date_format(date_create($row['tgl_inv']), "d/m/Y") ; ?><br><br>
				Ref. order / Ref. Shipment : <?= substr($row['No_Co'],4) . '/' . substr($row['no_sh'],4) ; ?><br>
				Order Date / Date sending Order : <?= date_format(date_create($row['tgl_order']), "d/m/Y") .'/'.date_format(date_create($row['tgl_order']), "d/m/Y") ; ?></p>
			</td>
		</tr>
		<tr>
			<td width="50%">From :</td>
			<td width="50%">To :</td>
		</tr>
		<tr>
			<td width="50%" style="text-align:left; vertical-align:top;">
				<b><?= $row['atasnama']; ?></b><br>
				Jl. Garuda 75-77<br>
				40183 Bandung<br><br>
				Phone : 0226031070<br>
				Fax : 0226038229
			</td>
			<td width="50%" style="text-align:left; vertical-align:top; border:1px solid black; border-collapse: collapes; padding: 5px">
				<b><?= $row['customer_nama'] ; ?></b><br>
				<?= $row['alamat_krm']; ?><br><br>
				UP : <?= $row['pic_nama'] ; ?><br>
				<?= $row['customer_telp'].'/'.$row['pic_kontak']; ?><br>
				PO : <?= $dtq['noso_ref'] ; ?>
			</td>
		</tr>  
	</table><br>
	<div>
		<table class="t-table" width="100%">
			<thead>
				<tr>
					<th align="left">Description</th>
					<th>Sales Tax</th>
					<th>U.P (net)</th>
					<th> Qty </th>
					<th align="right">Total (Net of Tax)</th>
				</tr>
			</thead>
			<tbody style="font-size;0.820em;">
				<?php while ($itm = $sql_hasil->fetch_assoc()) { ?>
				<tr style="border:1px;" border="1">
					<td style="vertical-align : top; "><?= $itm['model'] . '/' . $itm['deskripsi']; ?></td>
					<td style="vertical-align : top; "><?= $itm['ppn']; ?></td>
					<td style="vertical-align : top; "><?= $itm['price']; ?></td>
					<td style="vertical-align : top; " align="center"><?= $itm['qty_kirim']; ?></td>
					<td style="vertical-align : top; "><?= $itm['amount']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>     
		<table width="100%">
			<tbody>
				<tr>
					<td align="left" rowspan="5" width="40%" colspan="2"><?= $row['atasnama'] ;?><br> No. Rek <?= $row['nama_bank'] ; ?>: <?=  $row['rekening']; ?>
				</td>
			</tr>
			<?php if ($dtl['tDsc'] !=0) {  ?>
				<tr>
					<td align="right" width="75%">Discount</td>
					<td align="right"><?= number_format($dtl['tDsc'],2,".",",") ; ?></td>
				</tr>
			<?php } ?> 
			<?php if($dtl['tPjk'] !=0) { ?>
				<tr>
					<td align="right" width="75%">Tax</td>
					<td align="right"><?= number_format($dtl['tPjk'],2,".",",") ; ?></td>
				</tr>
			<?php } ?>
			<?php if($row['ongkir'] != 0) {  ?>
				<tr>
					<td align="right" width="75%">shipping cost</td>
					<td align="right"><?= number_format($row['ongkir'],2,".",",") ; ?></td>
				</tr>';
			<?php } ?> 
			<tr>
				<td align="right" width="75%">Total (net of tax)</td>
				<td align="right"><?= number_format($dtl['tAmt'],2,".",",") ; ?></td>
			</tr>
			<tr>
				<td align="right" width="75%">Total (inc. tax)</td>
				<td align="right"><?= number_format($dtl['total']+$row['ongkir'],2,".",",") ; ?></td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<thead>
			<tr>
				<td style="height : 70px; vertical-align : top; " align="left"><b>Approve By :</b></td>
				<td width="30%"></td>
				<td style="height : 70px; vertical-align : top; margin-right:15px" align="center"><b>Customer :</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td align="left"><b>Stephanie A</b></td>
				<td width="30%"></td>
				<td align="center">( . . . . . . . . . . )</td>
			</tr>
			<tr style="font-size:0.820em">
				<td colspan="3" align="right"><b>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.<br>
				Komplain kualitas dan kuantitas maksimal 1x24 jam setalah barang diterima</b>
			</td>
		</tr>
	</tbody>
</table>
</body>
<script>
    window.print();
</script>