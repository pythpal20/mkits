<?php 
$modul = $_GET['ide'];
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
    SELECT *
    FROM master_user
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'user_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'user_id', 'dt' => 0 ),
    array( 'db' => 'user_nama', 'dt' => 1 ),
    array( 'db' => 'notelp', 'dt' => 2 ),
    array( 'db' => 'email', 'dt' => 3 ),
    array( 'db' => 'company', 'dt' => 4 ),
    array( 'db' => 'level', 'dt' => 5 ),
    array( 'db' => 'status', 'dt' => 6)
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null, "modul = $modul")
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);