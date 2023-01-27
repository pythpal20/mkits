<?php

date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
var_dump($_POST);
// get variable
    if (isset($_POST)) {
        $noco = $_POST['noco'];
        $keterangan = $_POST['keterangan'];
        $nominal = $_POST['nominal'];
        $tanggal_bayar = $_POST['tanggal_bayar'];
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $addby = $_POST['addby'];
       
    }
// koneksi
    if ($db1->connect_error) {
        die("Connection failed: " . $db1->connect_error);
      }
// ketika insert
    $sql = "INSERT INTO detail_penagihan (noco, keterangan, nominal, metode_pembayaran,tgl_pembayaran, add_by)
            VALUES ('$noco','$keterangan', '$nominal', '$metode_pembayaran','$tanggal_bayar', '$addby')";
    if ($db1->query($sql) === TRUE) {
        echo "<script>
            history.back();
            alert('berhasil di tambahkan!');
            $('#form_detail_penagihan').trigger('reset');
            </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $db1->error;
    }


?>
<script>
// alert('test');
// history.back();
</script>