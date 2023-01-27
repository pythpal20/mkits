<?php
	include '../../config/connection.php';
	if (isset($_POST["id"])) {
		error_reporting();
		$output = '';
		$hdr = "SELECT * FROM master_fpp mf
		JOIN master_customer mc ON mf.customer_id = mc.customer_id
		JOIN master_wilayah mw ON mc.customer_kota = mw.wilayah_id
		WHERE fpp_id ='" . $_POST["id"] . "'";
		$mwk = $db1->prepare($hdr);
		$mwk->execute();
		$r_hdr = $mwk->get_result();
		$rh = $r_hdr->fetch_assoc();

		$no=1;
		$dtl = "SELECT * FROM fpp_detail WHERE fpp_id = '" . $_POST["id"] . "'";
		$mwk = $db1->prepare($dtl);
		$mwk->execute();
		$r_dtl = $mwk->get_result();

		$output .= '
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>SKU</th>
						<th>Qty</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>';
		while($rd=$r_dtl->fetch_assoc()) {
			$output .= '
					<tr>
						<td>'.$no++.'</td>
						<td>'.$rd['model'].'</td>
						<td>'.$rd['qty'].'</td>
						<td>'.$rd['keterangan'].'</td>
					</tr>';
		}
			$output .= '
				</tbody>
			</table>';
			$output .= '
			<table class="table table-bordered">
				<tr>
					<th colspan="2" style="text-align: center;">Alasan Perubahan PO</th>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan1"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Spesifikasi barang tidak sesuai (salah SKU)</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan2"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Kualitas Barang tidak sesuai (rusak)</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan3"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Informasi order dari Sales/ Marketing tidak sesuai</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan4"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Waktu pengadaan barang terlalu lama</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan5"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Pengiriman barang terlalu lama</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan6"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Jumlah pesanan tidak sesuai (Kurang/ Lebih)</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan7"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Kesalahan Input ke Dolibar</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["alasan_lain"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Lainnya :<br> <em>'.$rh['alasan_lain'].'</em></td>
				</tr>
			</table>
			<table class="table-bordered" width="100%">
				<tr>
					<th class="text-center" colspan="3">Tindak Lanjut Perubahan PO</th>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["proses1"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Cancel</td>
					<th>Catatan : </td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["proses2"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Revisi Invoice</td>
					<td rowspan = "5">'.$rh['catatan'].'</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["proses3"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Lengkapi kekurangan Jumlah</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["proses4"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Tukar SKU yang sama</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["proses5"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Tukar SKU yang berbeda</td>
				</tr>
				<tr>
					<td width="10%"><input type="checkbox" disabled=""';
					if($rh["proses_lain"] !== '') {
						$output .=' checked>';
					}
					$output .='
					</td>
					<td>Lainnya :<br> <em>'.$rh['proses_lain'].'</em></td>
				</tr>
			</table>
		</div>';
		echo $output;	
	}
?>