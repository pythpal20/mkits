<?php

date_default_timezone_set('Asia/Jakarta');
// var_dump($_POST);
function rupiah($angka)
{

    $hasil = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil;
}
include '../../config/connection.php';
$output = '';
$no = 0;
$tgl = date_format(date_create($_POST['id']), 'Y-m-d');
$sopir = $_POST['pic'];
$kenek = $_POST['pic2'];

$sql4 = "SELECT a.no_bl, 
        a.customer_nama, 
        c.sales, 
        SUM(b.harga_total) AS nominal_akhir, 
        a.tgl_delivery,
        (SELECT SUM(nominal_diterima) FROM tb_setoran WHERE no_bl = a.no_bl) AS diterima
    FROM customerorder_hdr_delivery a 
    JOIN customerorder_hdr c ON a.No_Co = c.No_Co             
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co    
    JOIN salesorder_hdr d ON a.noso = d.noso  
    WHERE DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d')='$tgl' AND a.sopir = '$sopir' AND a.kenek = '$kenek' AND c.method LIKE 'Cash/Tunai'  AND (d.jenis_transaksi LIKE 'KUNJUNGAN' OR d.jenis_transaksi LIKE 'TELEPON')
    GROUP BY a.No_Co";
$results = mysqli_query($connect,$sql4);
$total_row = mysqli_num_rows($results);

while ($row3 = mysqli_fetch_array($results)) {  $no++;
$sisa = $row3["nominal_akhir"] - $row3['diterima'];
$output .='<form id="form'. $no .'">
    <table width="100%" class="table table-hover table-bordered" id="tab">
        <thead>
            <tr>
                <th width="16%">No.BL</th>
                <th width="18%">Nama Cust.</th>
                <th width="15%">Nominal Awal</th>
                <th width="15%">Sisa</th>
                <th>Tgl. Kirim</th>
                <th width="18%">Nom. Setor</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
                <input type="hidden" name="nominalawal" id="awal'. $no .'" value="' .  $row3["nominal_akhir"]  . '">
                <input type="hidden" name="no_bl" id="no_bl' . $no . '" value="' .  $row3["no_bl"]  . '">
                <input type="hidden" name="sisa" id="sisa' . $no . '" value="' .  $sisa  . '">
                <input type="hidden" name="tgl_delivery" id="tgl_delivery' . $no . '" value="' .  $row3["tgl_delivery"]  . '">
                <th>' .  $row3["no_bl"]  . '</th>
                <td>' .  $row3["customer_nama"]  . '</td>
                <td>' .  rupiah($row3["nominal_akhir"])  . '</td>
                <td>' .  rupiah($row3["nominal_akhir"] - $row3['diterima']) . '</td>
                <td>' .  date_format(date_create($row3["tgl_delivery"]), 'd/m/y' )  . '</td>
                <td><input type="text" class="form-control" placeholder="Rp." name="nominal_diterima" id="nomditerima' . $no . '" disabled=""></td>
                <td><input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan'. $no .'"></td>
            </tr>
        </tbody>
    </table>
</form>';
}
$output .='<input type="hidden" name="total_row" id="total_row" value="' . $total_row . '">';
echo $output;