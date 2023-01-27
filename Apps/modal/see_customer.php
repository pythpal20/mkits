<?php
    //include file koneksi di folder config
    include '../../config/connection.php';
    
    $output = '';
    //Cek apakah ada ID yang di POST dari Halaman awal
    if (isset($_POST['id'])){
        //1. query untuk menampilkan detail customer berdasarkan nama (WHERE)
        $nama = $_POST['id'];
        $qry = "SELECT * FROM master_customer WHERE customer_nama = '$nama'";
        $mwk = $db1->prepare($qry);
        $mwk -> execute();
        $results = $mwk->get_result();
        $row=$results->fetch_assoc(); 
        //2. query untuk menampilkan nama kota dari customer
        $prov = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id ='" . $row['customer_provinsi'] . "' ";
        $mwk = $db1->prepare($prov);
        $mwk -> execute();
        $rsprov = $mwk->get_result();
        $pv = $rsprov->fetch_assoc();
        //3. query untuk menampilkan nama Provinsi dari Customer
        $kota = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id ='" . $row['customer_kota'] . "' ";
        $mwk = $db1->prepare($kota);
        $mwk -> execute();
        $rskota = $mwk->get_result();
        $kt = $rskota->fetch_assoc();
        //4. HTML didalam PHP (table yang akan muncul di Modal)
        $output .= '
        <table width="100%" class="table table-borderless">
            <tr>
                <td>ID</td>
                <td>:</td>
                <th>' . $row["customer_idregister"] . '</th>
                <td>Status</td>
                <td>:</td>
                <th>' . $row["status"] . '</th>
            </tr>
            <tr>
                <td width="20%">Customer</td>
                <td>:</td>
                <th width="30%">' . $row["customer_nama"] . '</th>
                <td width="20%">Kategori</td>
                <td>:</td>
                <th width="30%">' . $row["customer_kategori"] . '</th>
            </tr>
            <tr>
                <td>Kontak</td>
                <td>:</td>
                <th>' . $row["customer_telp"] . ' / '.$row["pic_kontak"].'</th>
                <td>PIC</td>
                <td>:</td>
                <th>' . $row["pic_nama"] . '</th>
            </tr>
            <tr>
                <td>Kota</td>
                <td>:</td>
                <th>' . $kt["wilayah_nama"] . '</th>
                <td>Provinsi</td>
                <td>:</td>
                <th>' . $pv["wilayah_nama"] . '</th>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <th colspan="4">' . $row["customer_alamat"] . '</th>
            </tr>
        </table>';
    } else { //Jika tidak ada data yang di Post maka tampilkan pesan ini
        $output .= '<b>NO DATA TO SEE :( </b>';
    } //Kirim Output dalam bentuk HTML ke Ajax
    echo $output;
?>
<!--
    Happy Coding
    Paulus Christofel Situmorang
    christofelpaulus@gmail.com
-->