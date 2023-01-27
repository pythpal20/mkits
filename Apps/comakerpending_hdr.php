<?php 
    // var_dump($_POST); die();
    include '../config/connection.php';
    session_start(); 
    $id = $_SESSION['idu'];
    $nama = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($nama); 
    $mwk->execute();
    $hasil = $mwk->get_result();
    $data = $hasil->fetch_assoc(); 

    $issuedby = $data['user_nama'];

    $tgl    = date('ym');
    $idpt   = $_POST['idpt'];
    $namapt     = $_POST['namapt'];
    
    //1. Generate Kode CO [CO2110-0001]
    $query = "SELECT MAX(kode) AS idCO
    FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(No_Co, 12, 5) AS urutan FROM customerorder_hdr WHERE id_perusahaan = '$idpt' AND SUBSTRING(No_Co,5,4) = 'CO23' ) AS tabel_a) AS table_b";
    $mwk = $db1->prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    while ($co = $resl->fetch_assoc()){
        $nomor = $co['idCO'];
        $urut = $nomor+1;
        $idCo = $namapt.'-'.'CO'.$tgl.'-'.sprintf("%04s", $urut);
    }
    
    //2. Generate Kode BL [BL2110-0001]
    $query2 = "SELECT MAX(kode) AS idBL
    FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(no_bl, 12, 5) AS urutan FROM customerorder_hdr WHERE id_perusahaan = '$idpt' AND SUBSTRING(No_Co,5,4) = 'CO23' ) AS tabel_a) AS table_b";  
    $mwk = $db1->prepare($query2);
    $mwk->execute();
    $resl2 = $mwk->get_result();
    while ($bl = $resl2->fetch_assoc()){
        $nomor2 = (int) $bl['idBL'];
        $urut2 = $nomor2+1;
        $idBl = $_POST['namapt'] . '-' . 'BL' . $tgl . '-' . sprintf("%04s", $urut2);
    }
    
    //3. Generate Kode PT [PT2110-0001] Pick Ticket
    $query3 = "SELECT MAX(kode) AS idPT
    FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(no_sh, 12, 5) AS urutan FROM customerorder_hdr WHERE id_perusahaan = '$idpt' AND SUBSTRING(No_Co,5,4) = 'CO23' ) AS tabel_a) AS table_b";  
    $mwk = $db1->prepare($query3);
    $mwk->execute();
    $resl3 = $mwk->get_result();
    while ($pt = $resl3->fetch_assoc()){
        $nomor3 = (int) $pt['idPT'];
        $urut3 = $nomor3 + 1;
        $idPt = $_POST['namapt'].'-'.'PT'.$tgl.'-'.sprintf("%04s", $urut3);
    }
    
    //4. Generate Kode Invoice FA [FA2110-0001]
    $query4 = "SELECT MAX(kode) AS idFA
    FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(no_fa, 12, 5) AS urutan FROM customerorder_hdr WHERE id_perusahaan = '$idpt' AND SUBSTRING(No_Co,5,4) = 'CO23' ) AS tabel_a) AS table_b";  
    $mwk = $db1->prepare($query4);
    $mwk->execute();
    $resl4 = $mwk->get_result();
    while ($fa = $resl4->fetch_assoc()){
        $nomor4 = (int) $fa['idFA'];
        $urut4 = $nomor4 + 1;
        $idFa = $_POST['namapt'] . '-' . 'FA' . $tgl . '-' . sprintf("%04s", $urut4);
    }
    //5. Simpan data header ketika NSCO di set dan Kode sudah lengkap
    if(isset($_POST['nsco'])) {
        $kode_co    = $idCo;
        $kode_bl    = $idBl;
        $kode_pt    = $idPt;
        $kode_fa    = $idFa;
        $nsco       = $_POST['nsco'];
        $idcustomer = $_POST['idcustomer'];
        $customer   = $_POST['customer'];
        $idpt       = $_POST['idpt'];
        $namapt     = $_POST['namapt'];
        $tglorder   = $_POST['tglorder'];
        $tglkrm     = $_POST['tglkrm'];
        $ongkir     = $_POST['ongkir'];
        $alamat     = $_POST['alamat'];
        $sales      = $_POST['sales'];
        $co_date = date('Y-m-d');
        $termp = $_POST['termp'];

        $sql = "INSERT INTO customerorder_hdr (No_Co, noso, no_sh, no_bl, no_fa, id_perusahaan, tgl_order, customer_id, customer_nama, term, alamat_krm, tgl_krm, ongkir, sales, issuedby, status, tgl_create)
        VALUES ('$kode_co', '$nsco', '$kode_pt', '$kode_bl', '$kode_fa', '$idpt', '$tglorder', '$idcustomer', '$customer', '$termp', '$alamat', '$tglkrm', '$ongkir', '$sales', '$issuedby', '1', '$co_date')";
        $mwk = $db1->prepare($sql);
        $mwk->execute();
        $result = $mwk->get_result();

        $sql2 = "UPDATE salesorder_hdr SET co_status = '1' WHERE noso = '$nsco'";
        $mwk = $db1->prepare($sql2);
        $mwk->execute();
        $result2 = $mwk->get_result();

        // $sql3 = "INSERT INTO customerorder_hdr_pending (noso, id_perusahaan, customer_id, alamat_krm) VALUES ('$nsco','$kode_pt', '$idcustomer', '$alamat')"

        echo $idCo;
    } else {
        echo 'Tidak ada data tersimpan';
    }
?>