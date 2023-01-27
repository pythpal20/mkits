<?php
include '../../config/connection.php';
$ambil_prov ="SELECT wilayah_id,wilayah_nama FROM master_wilayah WHERE CHAR_LENGTH(wilayah_id)=2;";
$hasil_prov = mysqli_query($connect, $ambil_prov);
$html="";
while ($row = mysqli_fetch_array($hasil_prov)) {
    $html .="<option value='".$row['wilayah_id']."'>".$row['wilayah_nama']."</option>";
}
echo $html;
?>