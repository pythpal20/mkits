<?php
	
	// var_dump($_POST); die();
	date_default_timezone_set('Asia/Jakarta');
	error_reporting(0);
	include '../config/connection.php';
	$id_customer 	= $_POST['idc'];
	$id_register	= $_POST['idRegister'];
	$tglNow         = date('Y-m-d');
	$user           = $_POST['inputby'];
	$nm_customer    = $_POST['nama_customer'];
	$sales          = $_POST['idsales'];
	$cs_kategori    = $_POST['kategori'];
	$cs_telp        = $_POST['telp'];
	$id_prov        = $_POST['prov'];
	$id_kota        = $_POST['kab'];
	$id_kecamatan   = $_POST['kec']; 
	$cs_alamat      = $_POST['almtCustomer'];
	$cs_alamat_kirim = $_POST['almtKirim']; 
	$term           = $_POST['term']; 
	$method         = $_POST['method'];
	$nohp           = $_POST["nohp"];
	$fax            = $_POST['nofax']; 
	$cemail         = $_POST['email'];
	$cweb           = $_POST['web'];
	$kpos           = $_POST['kodepos'];

	$pic            = $_POST['pic']; 
	$jabatan1       = $_POST['jabatan1']; 
	$pic_kontak     = $_POST['kontak']; 
	$emailpic1      = $_POST['emailpic1'];
	$noktp1         = $_POST['noktp1']; 
	$pic_alamat     = $_POST['almtPic'];

	$pic2           = $_POST['pic2'];
	$jabatan2       = $_POST['jabatan2'];
	$pic_kontak2        = $_POST['kontak2'];
	$emailpic2      = $_POST['emailpic2'];
	$noktp2         = $_POST['noktp2'];
	$pic_alamat2       = $_POST['almtPic2'];

	$pic3           = $_POST['pic3'];
	$jabatan3       = $_POST['jabatan3'];
	$pic_kontak3        = $_POST['kontak3'];
	$emailpic3      = $_POST['emailpic3'];
	$noktp3         = $_POST['noktp3'];
	$pic_alamat3       = $_POST['almtPic3'];

	$namabank       = $_POST['namabank'];
	$atasnama       = $_POST['atasnama'];
	$rekening       = $_POST['rekening'];
	$cabang         = $_POST['cabang'];
	$alamatbank     = $_POST['alamatbank'];


	$cd_kategori    = $_POST['kode_kategori'];
	$cd_wilayah     = $_POST['kode_wilayah'];
	
	$tudei = date('Y-m-d');
	// generate id register
	$cekTgl = date('ymd');
	$ambiNo = "SELECT MAX(customer_idregister) AS idArr FROM master_customer WHERE customer_kategori='$cs_kategori' AND customer_kota = '$id_kota'";
	$mwk = $db1->prepare($ambiNo);
	$mwk -> execute();
	$resl = $mwk->get_result();
	while ($sb = $resl->fetch_assoc()) {
		$idRegister  = $sb['idArr'];
		$urutan = (int) substr($idRegister, 14, 14);
		$urutan++;
		$huruf = $_POST['kode_wilayah'].".".$_POST['kode_kategori'];
		$idRegister = $huruf.".".$cekTgl.".".sprintf("%05s", $urutan);
		// var_dump($sb['idArr']);
	}
	// die();
	$cek = "SELECT * FROM master_customer WHERE customer_idregister = '$id_register'";
	$mwk = $db1->prepare($cek);
	$mwk -> execute();
	$reslc = $mwk->get_result();
	if ($reslc->num_rows > 0){
		$update1 = "UPDATE master_customer SET customer_nama = '$nm_customer', 
											   customer_sales = '$sales',
											   customer_kategori = '$cs_kategori',
											   customer_telp = '$cs_telp',
											   customer_provinsi = '$id_prov',
											   customer_kota =  '$id_kota',
											   customer_kecamatan = '$id_kecamatan',
											   customer_alamat = '$cs_alamat',
											   customer_alamat_krm = '$cs_alamat_kirim',
											   customer_nohp = '$nohp',
											   customer_fax  = '$fax',
											   customer_email = '$cemail',
											   customer_web  = '$cweb',
											   customer_pos = '$kpos',

											   pic_nama = '$pic',
											   pic_jabatan = '$jabatan1',
											   pic_noktp = '$noktp1',
											   pic_alamat = '$pic_alamat',
											   pic_kontak = '$pic_kontak',
											   pic_email = '$emailpic1',

											   pic_nama2 = '$pic2',
											   pic_jabatan2 = '$jabatan2',
											   pic_noktp2 = '$noktp2',
											   pic_alamat2 = '$pic_alamat2',
											   pic_kontak2 = '$pic_kontak2',
											   pic_email2 = '$emailpic2',

											   pic_nama3 = '$pic3',
											   pic_jabatan3 = '$jabatan3',
											   pic_noktp3 = '$noktp3',
											   pic_alamat3 = '$pic_alamat3',
											   pic_kontak3 = '$pic_kontak3',
											   pic_email3 = '$emailpic3',
											
											   bank_nama = '$namabank',
											   bank_nama_akun = '$atasnama',
											   bank_norek = '$rekening',
											   bank_cabang = '$cabang',
											   bank_alamat = '$alamatbank',
											   editby = '$user',
											   editDate = '$tudei'

											   
											   WHERE customer_id = '$id_customer'";
		$mwk = $db1->prepare($update1);
		$mwk -> execute();
		$reslu = $mwk->get_result();
		if ($reslu->num_rows > 0) {
			echo 'Gagal Query! silahkan coba lagi :)';
		} else {
			echo 'Update Data Berhasil';
		}
	} else{
		$query_insert = "UPDATE master_customer SET customer_idregister= '$idRegister',
													customer_nama = '$nm_customer',
													customer_kategori = '$cs_kategori',
													customer_provinsi = '$id_prov', 
													customer_kota = '$id_kota', 
													customer_alamat = '$cs_alamat', 
													customer_telp = '', 
													pic_nama = '$pic', 
													pic_alamat = '$pic_alamat', 
													pic_kontak = '$pic_kontak' 
													WHERE customer_id = '$id_customer'";
		$mwk = $db1->prepare($query_insert);
		$mwk -> execute();
		$resli = $mwk->get_result();
		if($resli->num_rows>0){
			echo "Gagal Update Data, silahkan ulangi";
		} else{
			echo "Yeay! Insert Data Berhasil...";
		}
	}
	
?>