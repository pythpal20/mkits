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
    SELECT DISTINCT(a.idPts),a.tgl_create,a.tgl_ambil,a.customer_nama,a.sales, a.app_admin
    FROM pts_header a
    JOIN pts_detail b ON a.idPts = b.idPts
    WHERE b.amount IS NOT NULL
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
    array( 'db' => 'tgl_create', 'dt' => 2 ), 
    array( 'db' => 'tgl_ambil', 'dt' => 3 ), 
    array( 'db' => 'customer_nama', 'dt' => 4 ),
    array( 'db' => 'sales', 'dt' => 5),
    array( 'db' => 'app_admin', 'dt' => 6)
); 

// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);