<?php
	error_reporting(0);
	include '../../config/connection.php';
	//select.php  
	if (isset($_POST["id"])) {
		$output = '';
		$query = "SELECT * FROM temp_customer WHERE ID = '" . $_POST["id"] . "'";
		$result = mysqli_query($connect, $query);
		$row = mysqli_fetch_array($result);

		$kota = "SELECT wilayah_nama AS kotas FROM master_wilayah WHERE wilayah_id = '" . $row["kota"] . "'";
		$hs_kota = mysqli_query($connect, $kota);
		$kt = mysqli_fetch_array($hs_kota);

		$prov = "SELECT wilayah_nama AS provf FROM master_wilayah WHERE wilayah_id = '" . substr($row["kota"],0,2) . "'";
		$hs_prov = mysqli_query($connect, $prov);
		$pv = mysqli_fetch_array($hs_prov);

		$output .= '
		<div class="table-responsive"> 
			<table class="table table-borderless">
                <tr>
					<th>ID Register</th>
					<td>:</td>
					<td>'. $row['customer_idregister'] . '</td>
				</tr>
				<tr>
					<th>Nama Customer</th>
					<td>:</td>
					<td>'. $row['customer_nama'] . '</td>
				</tr>
				<tr>
					<th>Kategori</th>
					<td>:</td>
					<td>'. $row['jenis_usaha'] . '</td>
				</tr>
				<tr>
					<th>PIC</th>
					<td>:</td>
					<td>'. $row['pic'] . '</td>
				</tr>
				<tr>
					<th>Kontak</th>
					<td>:</td>
					<td>'. $row['notelp'] . ' / '. $row["nohp"] .'</td>
				</tr>
                <tr>
					<th>Alamat</th>
					<td>:</td>
					<td>'. $row['detail_alamat'] . '</td>
				</tr>
				<tr>
					<th>Kota</th>
					<td>:</td>
					<td>'. $kt['kotas'] . '</td>
				</tr>
				<tr>
					<th>Provinsi</th>
					<td>:</td>
					<td>'. $pv['provf'] . '</td>
				</tr>';
		$output .= '</table></div>';
		echo $output;
	}
?>