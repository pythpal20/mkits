<?php 
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT
      a.ID,
      a.customer_nama,
      a.jenis_usaha,
      b.wilayah_nama,
      a.pic,
      a.status
    FROM temp_customer a
    LEFT JOIN master_wilayah b ON a.kota = b.wilayah_id
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'ID';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'ID', 'dt' => 0 ),
    array( 'db' => 'customer_nama', 'dt' => 1 ),
    array( 'db' => 'jenis_usaha', 'dt' => 2 ),
    array( 'db' => 'wilayah_nama', 'dt' => 3 ),
    array( 'db' => 'pic', 'dt' => 4 ),
    array( 'db' => 'status', 'dt' => 5)
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);