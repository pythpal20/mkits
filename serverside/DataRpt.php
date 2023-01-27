<?php 
// $nilai = $_GET['nilai'];
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'horek940_salsys', 
    'pass' => 'Garuda752021', 
    'db'   => 'horek940_salsys' 
); 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT idPts,tgl_create,tgl_ambil,customer_nama,sales, CONCAT(app_admin,'|',app_akunting) AS map, status
    FROM pts_header
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
        'dt' => 2,
        'formatter' => function($d, $row) {
            return date('d-m-Y', strtotime($d));
        }
    ), 
    array( 
        'db' => 'tgl_ambil', 
        'dt' => 3,
        'formatter' => function($d, $row) {
            return date('d-m-Y', strtotime($d));
        }
    ), 
    array( 'db' => 'customer_nama', 'dt' => 4 ),
    array( 'db' => 'sales', 'dt' => 5),
    array( 'db' => 'status', 'dt' => 6),
    array( 'db' => 'map', 'dt' => 7)
); 

// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);