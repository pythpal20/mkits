<?php 
$ide = $_GET['id'];
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
        customer_id,
        editDate,
        editby
    FROM log_master_customer 
WHERE customer_id = '$ide'
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
    array( 'db' => 'editDate', 'dt' => 1 ),
    array( 'db' => 'editby', 'dt' => 2 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);