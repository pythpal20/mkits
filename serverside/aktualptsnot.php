<?php 
$jenis = $_GET['jenis'];
// Database connection info 
include 'aconnection.php'; 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT *
    FROM pts_header
    WHERE app_wrh = '1' AND (app_akunting = '1' AND app_admin = '1') AND status ='$jenis'
    ORDER BY idPts DESC
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'idPts'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'idPts', 'dt' => 0 ),
    array( 'db' => 'idPts', 'dt' => 1 ), 
    array( 
        'db' => 'tgl_create', 
        'dt' => 2 ,
        'formatter' => function($d, $row) {
            return date('d-m-Y', strtotime($d));
        }
    ), 
    array( 
        'db' => 'tgl_ambil', 
        'dt' => 3 ,
        'formatter' => function($d, $row) {
            return date('d-m-Y', strtotime($d));
        }
    ), 
    array( 'db' => 'customer_nama', 'dt' => 4),
    array( 'db' => 'sales', 'dt' => 5),
    array( 'db' => 'complete', 'dt' => 6)
); 

// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);