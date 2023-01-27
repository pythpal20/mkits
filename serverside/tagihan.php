<?php
function rupiah($angka)
{
    date_default_timezone_set('Asia/Jakarta');
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
// Database connection info 
include 'aconnection.php';

// DB table to use 
// // $table = 'members'; 
//  WHERE jenis_transaksi != 'MARKETPLACE' AND jenis_transaksi != 'SHOWROOM' AND jenis_transaksi != 'INTERNAL'
$table = <<<EOT
 (
    SELECT 
        a.tgl_delivery,
        a.sopir, 
        a.kenek, 
        SUM(b.harga_total) AS nominal_akhir, 
        (SELECT SUM(nominal_diterima) FROM tb_setoran WHERE tgl_delivery = DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d') AND pic1 = a.sopir AND pic2=a.kenek GROUP BY tgl_delivery) AS nominalditerima
    FROM customerorder_hdr_delivery a
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
    JOIN salesorder_hdr d ON a.noso = d.noso
    JOIN customerorder_hdr e ON a.No_Co = e.No_Co
    WHERE e.method LIKE 'Cash/Tunai' AND a.status_delivery != '0' AND (d.jenis_transaksi LIKE 'KUNJUNGAN' OR d.jenis_transaksi LIKE 'TELEPON')
    GROUP BY DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d'), a.sopir, a.kenek
 ) temp
EOT;

// Table's primary key 
$primaryKey = 'tgl_delivery';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'tgl_delivery', 'dt' => 0),
    array(
        'db' => 'tgl_delivery', 'dt' => 1,
        "formatter" => function ($d, $row) {
            return date('d-m-Y', strtotime($d));
        }
    ),
    array(
        'db' => 'nominal_akhir', 'dt' => 2,
        "formatter" => function ($d, $row) {
            return 'Rp. ' . rupiah($d);
        }
    ),
    array('db' => 'sopir', 'dt' => 3),
    array('db' => 'kenek', 'dt' => 4),
    array(
        'db' => 'nominalditerima', 'dt' => 5,
        "formatter" => function ($d, $row) {
            return 'Rp. ' . rupiah($d);
        }
    )
);
// Include SQL query processing class 
require 'ssp.php';

// require('ssp.class.php');

// Output data as json format 
echo json_encode(
    SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);