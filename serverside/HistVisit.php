<?php 
$ide = $_GET['id'];
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
        a.id_followup,
        a.tgl_followup,
        b.user_nama,
        a.followup_by,
        a.ket,
        a.deskripsi_followup,
        c.ID
    FROM master_kunjungan a
    JOIN master_user b ON a.sales = b.user_id
    JOIN temp_customer c ON a.customer_id = c.ID
WHERE c.ID = '$ide'
 ) temp
EOT;
// Table's primary key 
$primaryKey = 'id_followup';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id_followup', 'dt' => 0 ),
    array( 'db' => 'tgl_followup', 'dt' => 1 ),
    array( 'db' => 'user_nama', 'dt' => 2 ),
    array( 'db' => 'followup_by', 'dt' => 3 ),
    array( 'db' => 'ket', 'dt' => 4 ),
    array( 'db' => 'deskripsi_followup', 'dt' => 5 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);