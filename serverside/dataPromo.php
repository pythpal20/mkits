<?php 
// $nilai = $_GET['nilai'];
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
        a.promo_id,
        a.promo_name,
        COUNT(b.model) AS jumlahSku,
        a.promo_date,
        a.promo_status,
        a.promo_addby
    FROM bundle_promo a
    JOIN bundle_promo_dtl b ON a.promo_id = b.promo_id
    GROUP BY b.promo_id
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'promo_id'; 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'promo_id', 'dt' => 0 ),
    array( 'db' => 'promo_id', 'dt' => 1 ), 
    array( 'db' => 'promo_name', 'dt' => 2), 
    array( 'db' => 'jumlahSku', 'dt' => 3), 
    array( 'db' => 'promo_date', 'dt' => 4 ),
    array( 'db' => 'promo_status', 'dt' => 5),
    array( 'db' => 'promo_addby', 'dt' => 6)
); 

// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);