<?php
date_default_timezone_set('Asia/Jakarta');
// var_dump($mwk3);
function rupiah($angka)
{

    $hasil = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil;
}
include '../../config/connection.php';
$output = '';
$tgl = date_format(date_create($_POST['tgl_delivery']), 'Y-m-d');
$sopir = $_POST['pic'];
$kenek = $_POST['pic2'];

$sql4 = "SELECT a.no_bl, 
        a.customer_nama, 
        c.sales, 
        SUM(b.harga_total) AS nominal_akhir, 
        a.tgl_delivery       
    FROM customerorder_hdr_delivery a 
    JOIN customerorder_hdr c ON a.No_Co = c.No_Co             
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co    
    JOIN salesorder_hdr d ON a.noso = d.noso      
    WHERE DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d')='$tgl' AND (a.sopir = '$sopir' AND a.kenek = '$kenek') AND c.method LIKE 'Cash/Tunai'  AND (d.jenis_transaksi LIKE 'KUNJUNGAN' OR d.jenis_transaksi LIKE 'TELEPON')
    GROUP BY b.No_Co";
$mwk3 = $db1->prepare($sql4);
$mwk3->execute();
$hasil5 = $mwk3->get_result();
$output .= '<table width="100%" class="table display table-hover" id="tbView">
    <thead>
        <tr class="table-info">
            <th>Tgl. Setoran</th>
            <th>No. BL</th>
            <th>Nominal Terima</th>
            <th>Nama Customer</th>
            <th>Keterangan</th>
            <th>Input By</th>
        </tr>
    </thead>
    <tbody>';


$sql2 = "SELECT a.tgl_input, a.no_bl, a.nominal_diterima, b.customer_nama, a.keterangan, a.inputby, a.pic1, a.pic2 FROM tb_setoran a
        JOIN customerorder_hdr_delivery b ON a.no_bl = b.no_bl
WHERE DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d')='$tgl' AND (a.pic1 = '$sopir' AND a.pic2= '$kenek')";
$mwk = $db1->prepare($sql2);
$mwk->execute();
$hasil3 = $mwk->get_result();
if($hasil3->num_rows > 0){
    while ($row = $hasil3->fetch_assoc()) {
    $output .= '
        <tr>
            <td>' . $row["tgl_input"] . '</td>
            <td>' . $row["no_bl"] . '</td>
            <td style="text-align:left;">' . rupiah($row["nominal_diterima"]) . '</td>
            <td>' . $row["customer_nama"] . '</td>
            <td>' . $row["keterangan"] . '</td>
            <td>' . $row["inputby"] . '</td>
        </tr>';
    }
} else {
    $output .='<tr>
        <td colspan="5" align="center">Belum ada data</td>
    </tr>';
}

$sql3 = "SELECT SUM(a.nominal_diterima) as total FROM tb_setoran a 
WHERE tgl_delivery='$tgl' AND (pic1 = '$sopir' AND pic2= '$kenek') GROUP BY tgl_delivery";
$mwk2 = $db1->prepare($sql3);
$mwk2->execute();
$hasil4 = $mwk2->get_result();
$output .= '
    <tr>
        <th style="text-align:left;">Total</th>';
if($hasil4->num_rows > 0){
    while ($row2 = $hasil4->fetch_assoc()) {
    $output .= '
        <th colspan="3" style="text-align:center;">' . rupiah($row2["total"]) . '</th>';
    }
} else {
    $output .='<th>Belum ada data</th>';
}
    $output .='</tr>
    </tbody>';


echo $output;