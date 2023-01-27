<?php 
$stat = $_GET['stat'];
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
      a.No_Co,
      a.tgl_order,
      a.tgl_krm,
      c.customer_nama,
      SUM(b.harga_total) AS uang,
      a.status,
      a.sales,
      a.keterangan
    FROM customerorder_hdr a
    JOIN customerorder_dtl b ON a.No_Co = b.No_Co
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.id_perusahaan = '1'
    GROUP BY b.No_Co
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'No_Co';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'No_Co', 'dt' => 0 ),
    array( 
        'db' => 'No_Co', 
        'dt' => 1, 
        'formatter' => function($d, $row) {
            return substr($d, 4);
        }
    ),
    array( 'db' => 'tgl_order', 'dt' => 2 ),
    array( 'db' => 'tgl_krm', 'dt' => 3 ),
    array( 'db' => 'customer_nama', 'dt' => 4 ),
    array( 'db' => 'uang', 'dt' => 5 ),
    array( 'db' => 'status', 'dt' => 6 ),
    array( 'db' => 'sales', 'dt' => 7),
    array( 'db' => 'keterangan', 'dt' => 8),
    array( 'db' => 'status', 'dt' => 9),
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);