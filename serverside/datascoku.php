<?php
$id = $_GET['id'];
// Database connection info 
include 'aconnection.php';

// DB table to use 
// $table = 'members'; 

$table = <<<EOT
    (
       SELECT 
            a.noso, 
            a.tgl_po,
            c.customer_nama,
            SUM(b.harga_total) AS total,
            a.status
       FROM salesorder_hdr a
       LEFT JOIN salesorder_dtl b ON a.noso = b.noso
       LEFT JOIN master_customer c ON a.customer_id = c.customer_id
       WHERE sales = '$id' 
       GROUP BY b.noso
    ) temp
EOT;

$primaryKey = 'noso';

$columns = array(
    array('db' => 'noso', 'dt' => 0),
    array('db' => 'noso', 'dt' => 1),
    array('db' => 'tgl_po', 'dt' => 2),
    array('db' => 'customer_nama', 'dt' => 3),
    array('db' => 'total', 'dt' => 4),
    array(
        'db' => 'status', 'dt' => 5,
        'formatter' => function ($d, $row) {
            if ($d == '1') {
                return 'PROCESS';
            } elseif ($d == '2') {
                return 'CANCEL';
            } else {
                return 'UNPROCESS';
            }
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
