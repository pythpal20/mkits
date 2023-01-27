<?php
// var_dump($_POST); die();
	error_reporting(0);
	include '../config/connection.php';
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
	$pic            = $_POST['pic']; 
	$jabatan1       = $_POST['jabatan1']; 
	$pic_kontak     = $_POST['kontak']; 
	$emailpic1      = $_POST['emailpic1'];
	$noktp1         = $_POST['noktp1']; 
	$pic_alamat     = $_POST['almtPic'];
	$term           = $_POST['term']; 
	$method         = $_POST['method'];
	$nohp           = $_POST["nohp"];
	$fax            = $_POST['nofax']; 
	$cemail         = $_POST['email'];
	$cweb           = $_POST['web'];
	$kpos           = $_POST['kodepos'];

	$pic2           = $_POST['pic2'];
	$jabatan2       = $_POST['jabatan2'];
	$kontak2        = $_POST['kontak2'];
	$emailpic2      = $_POST['emailpic2'];
	$noktp2         = $_POST['noktp2'];
	$almtPic2       = $_POST['almtPic2'];

	$pic3           = $_POST['pic3'];
	$jabatan3       = $_POST['jabatan3'];
	$kontak3        = $_POST['kontak3'];
	$emailpic3      = $_POST['emailpic3'];
	$noktp3         = $_POST['noktp3'];
	$almtPic3       = $_POST['almtPic3'];

	$namabank       = $_POST['namabank'];
	$atasnama       = $_POST['atasnama'];
	$rekening       = $_POST['rekening'];
	$cabang         = $_POST['cabang'];
	$alamatbank     = $_POST['alamatbank'];


	$cd_kategori    = $_POST['kode_kategori'];
	$cd_wilayah     = $_POST['kode_wilayah'];
	// generate id register
	$cekTgl         = date('ymd');
	
	$ambiNo = "SELECT MAX(customer_idregister) AS idArr FROM master_customer WHERE customer_kategori='$cs_kategori' AND customer_kota = '$id_kota'";
	$mwk    = $db1->prepare($ambiNo);
	$mwk    -> execute();
	$resl   = $mwk->get_result();
	while ($sb = $resl->fetch_assoc()) {
		$idRegister  = $sb['idArr'];
		$urutan      = (int) substr($idRegister, 14, 14);
		$urutan++;
		$huruf       = $_POST['kode_wilayah'].".".$_POST['kode_kategori'];
		$idRegister  = $huruf.".".$cekTgl.".".sprintf("%05s", $urutan);
	}
	$RegisterID = $idRegister;
	$cek = "SELECT * FROM master_customer WHERE customer_nama = '$nm_customer' AND customer_kategori ='$cs_kategori'";
	$mwk = $db1->prepare($cek);
	$mwk -> execute();
	$reslc = $mwk->get_result();
	if ($reslc->num_rows > 0){
		echo "Data ini sudah ada, Tambah Customer Lain";
	} else {
	   // echo "Proses berlanjut" . $idRegister;
	    $query_insert = "INSERT INTO master_customer (customer_id, customer_idregister, customer_kategori, customer_nama, customer_provinsi, customer_kota, customer_kecamatan, customer_alamat, customer_telp, 
	    customer_nohp, pic_nama, pic_alamat, pic_kontak, term, input_by, tgl_input, method, customer_sales, customer_alamat_krm, 
	    customer_email, customer_pos, customer_fax, customer_web, pic_jabatan, pic_noktp, pic_email, pic_nama2, pic_jabatan2, 
	    pic_noktp2, pic_alamat2, pic_kontak2, pic_email2, pic_nama3, pic_jabatan3, pic_noktp3, pic_alamat3, pic_kontak3, pic_email3,
	    bank_nama, bank_nama_akun, bank_norek, bank_cabang, bank_alamat) VALUES ('','$idRegister','$cs_kategori','$nm_customer', '$id_prov','$id_kota', '$id_kecamatan', '$cs_alamat','$cs_telp', '$nohp', '$pic', '$pic_alamat', '$pic_kontak', '$term', '$user', '$tglNow', '$method', '$sales', '$cs_alamat_kirim', '$cemail', '$kpos', '$fax', '$cweb', '$jabatan1', '$noktp1', '$emailpic1', '$pic2', '$jabatan2', '$noktp2', '$almtPic2', '$kontak2', '$emailpic2', '$pic3', '$jabatan3', '$noktp3', '$almtPic3', '$kontak3', '$emailpic3', '$namabank', '$atasnama', '$rekening', '$cabang', '$alamatbank')";
		$mwk = $db1->prepare($query_insert);
		$mwk -> execute();
		$resli = $mwk->get_result();
		if($resli->num_rows>0){
			echo "Gagal Input Data";
		} else{
			echo "Yeay! Insert Data Berhasil...";
		}
	}
// 	var_dump($_POST);
?>