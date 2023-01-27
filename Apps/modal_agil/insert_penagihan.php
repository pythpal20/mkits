<?php

date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';

// get variable
    if (isset($_POST)) {
        $noco = $_POST['noco_insert'];
        $kontrabon = $_POST['tgl_kontrabon'];
        $duedate = $_POST['tgl_due'];
        $jenis = $_POST['jenis'];
    }
// koneksi
    if ($db1->connect_error) {
        die("Connection failed: " . $db1->connect_error);
      }
// check ada atau tidak ada di table
    $sql_cari = "SELECT noco FROM kontrabon WHERE noco = '$noco'";
    $query_cari = $db1->query($sql_cari);
    $cari =  $query_cari->num_rows;
  

if($cari < 1){
    // ketika tidak ada insert
    $sql = "INSERT INTO kontrabon (noco, tgl_kontrabon, tgl_duedate)
    VALUES ('$noco','$kontrabon', '$duedate')";
    $kalimat = "berhasil ditambahkan";
}else{
    // ketika ada update
    $sql = "UPDATE kontrabon set  tgl_kontrabon = '$kontrabon', tgl_duedate ='$duedate'
    WHERE noco = '$noco'";
    $kalimat = "berhasil diupdate";
}

    
    if ($db1->query($sql) === TRUE) {
      echo "<script>
             history.back();
             alert('$kalimat');
          </script>";
    } else {
      echo "Error: " . $sql . "<br>" . $db1->error;
    }

?>