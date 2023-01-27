<?php 
$id = $_GET['id'];
// Database connection info 
include 'aconnection.php'; 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT
      a.customer_id,
      a.customer_idregister, 
      a.customer_nama,
      a.input_by,
      b.wilayah_nama,
      a.term,
      a.method
    FROM master_customer a
    LEFT JOIN master_wilayah b ON a.customer_kota = b.wilayah_id
    WHERE a.customer_sales = '$id'
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'customer_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'customer_id', 'dt' => 0 ),
    array( 'db' => 'customer_idregister', 'dt' => 1 ),
    array( 'db' => 'customer_nama', 'dt' => 2 ),
    array( 'db' => 'wilayah_nama', 'dt' => 3 ),
    array( 'db' => 'term', 'dt' => 4 ),
    array( 'db' => 'method', 'dt' => 5 ),
    array( 'db' => 'input_by', 'dt' => 6 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);