<?php
	error_reporting(0);
	include '../../config/connection.php';
	//select.php  
	if (isset($_POST["id"])) {
		$output = '';
		$query = "SELECT * FROM master_customer WHERE customer_id = '" . $_POST["id"] . "'";
		$result = mysqli_query($connect, $query);
		$row = mysqli_fetch_array($result);

		$sales = "SELECT user_nama FROM master_user WHERE user_id = '" . $row["customer_sales"] . "'";
		$mwk = $db1->prepare($sales);
		$mwk->execute();
		$resales = $mwk->get_result();
		$rs = $resales->fetch_assoc();

		$kota = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id = '" . $row["customer_kota"] . "'";
		$hs_kota = mysqli_query($connect, $kota);
		$kt = mysqli_fetch_array($hs_kota);

		$prov = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id = '" . $row["customer_provinsi"] . "'";
		$hs_prov = mysqli_query($connect, $prov);
		$pv = mysqli_fetch_array($hs_prov);

		$kecc = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id = '" . $row["customer_kecamatan"] . "'";
		$hs_kecc = mysqli_query($connect, $kecc);
		$kc = mysqli_fetch_array($hs_kecc);

		$output .= '
		<div class="table-responsive"> 
			<table class="table table-hover table-stripped" width="100%" style="border:1px solid black">
				<tr>
					<td>ID Register</td>
					<td>:</td>
					<th colspan="7">' . $row["customer_idregister"]. '</th>
				</tr>
				<tr>
					<td>Customer</td>
					<td>:</td>
					<th>' . $row["customer_nama"] . '</th>

					<td>Kategori</td>
					<td>:</td>
					<th>' . $row["customer_kategori"] . '</th>

					<td>Sales</td>
					<td>:</td>
					<th>' . $rs["user_nama"] . '</th>
				</tr>
				<tr>
					<td>No. Telp</td>
					<td>:</td>
					<th>' . $row["customer_telp"] . '</th>

					<td>No. HP</td>
					<td>:</td>
					<th>' . $row["customer_nohp"] . '</th>

					<td>E-Mail</td>
					<td>:</td>
					<th>' . $row["customer_email"] . '</th>
				</tr>
				<tr>
					<td>Term</td>
					<td>:</td>
					<th>' . $row["term"] . '</th>

					<td>Payment Method</td>
					<td>:</td>
					<th>' . $row["method"] . '</th>

					<td>Spesialisasi</td>
					<td>:</td>
					<th>' . $row["customer_spesialisasi"] . '</th>
				</tr>
				<tr>
					<td>Provinsi</td>
					<td>:</td>
					<th>' . $pv["wilayah_nama"] . '</th>

					<td>Kota/ Kabupaten</td>
					<td>:</td>
					<th>' . $kt["wilayah_nama"] . '</th>

					<td>Kecamatan</td>
					<td>:</td>
					<th>' . $kc["wilayah_nama"] . '</th>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td colspan="7">' . $row["customer_alamat"] . '</td>
				</tr>
				<tr>
					<td>Alamat Kirim</td>
					<td>:</td>
					<td colspan="7">' . $row["customer_alamat_krm"] . '</td
				</tr>
				<tr>
					<td>Kode POS</td>
					<td>:</td>
					<th>' . $row["customer_pos"] . '</th>

					<td>No. FAX</td>
					<td>:</td>
					<th>' . $row["customer_fax"] . '</th>

					<td>Website</td>
					<td>:</td>
					<th>http://' . $row["customer_web"] . '</th>
				</tr></table>';
		$output .= '<table class="table table-hover table-stripped" width="100%" style="border:1px solid black">
			<tr class="table-info">
				<th colspan="12" style="text-align: center;">Penanggung Jawab</th>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<th>' . $row["pic_nama"] . '</th>

				<td>Jabatan</td>
				<td>:</td>
				<th>' . $row["pic_jabatan"] . '</th>

				<td>Kontak</td>
				<td>:</td>
				<th>' . $row["pic_kontak"] . '</th>

				<td>Email</td>
				<td>:</td>
				<th>' . $row["pic_email"] . '</th>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<th colspan="10">' . $row["pic_alamat"] . '</th>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<th>' . $row["pic_nama2"] . '</th>

				<td>Jabatan</td>
				<td>:</td>
				<th>' . $row["pic_jabatan2"] . '</th>

				<td>Kontak</td>
				<td>:</td>
				<th>' . $row["pic_kontak2"] . '</th>

				<td>Email</td>
				<td>:</td>
				<th>' . $row["pic_email2"] . '</th>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<th colspan="10">' . $row["pic_alamat2"] . '</th>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<th>' . $row["pic_nama3"] . '</th>

				<td>Jabatan</td>
				<td>:</td>
				<th>' . $row["pic_jabatan3"] . '</th>

				<td>Kontak</td>
				<td>:</td>
				<th>' . $row["pic_kontak3"] . '</th>

				<td>Email</td>
				<td>:</td>
				<th>' . $row["pic_email3"] . '</th>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<th colspan="10">' . $row["pic_alamat3"] . '</th>
			</tr>
		</table>';
		$output .='<table class="table table-hover table-stripped" width="100%" style="border:1px solid black">
			<tr class="table-warning">
				<th colspan="12" style="text-align: center;">Rekening Bank</th>
			</tr>
			<tr>
				<td>Nama Bank</td>
				<td>:</td>
				<th>' . $row["bank_nama"] . '</th>

				<td>Atas Nama</td>
				<td>:</td>
				<th>' . $row["bank_nama_akun"] . '</th>

				<td>No. Rekening</td>
				<td>:</td>
				<th>' . $row["bank_norek"] . '</th>
			</tr>
			<tr>
				<td>Cabang</td>
				<td>:</td>
				<th>' . $row["bank_cabang"] . '</th>

				<td>Alamat Bank</td>
				<td>:</td>
				<th colspan="3">' . $row["bank_alamat"] . '</th>
			</tr>
		</table>
		<table class="table table-hover table-stripped" width="100%" style="border:1px solid black">
			<tr>
				<td>Status Customer</td>
				<td>:</td>
				<td><span class="label label-info">' . $row["status"] . '</span></td>

				<td>Tgl. Input</td>
				<td>:</td>
				<td><span class="label label-success">' . $row["tgl_input"] . '</span></td>

				<td>Input By</td>
				<td>:</td>
				<td><span class="label label-primary">' . $row["input_by"] . '</span></td>
			</tr>';
		$output .='</table></div>';
		echo $output;
	}
?>