<?php 
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT
      a.id_followup,
      a.followup_by,
      a.tgl_followup,
      b.customer_nama,
      c.user_nama,
      a.ket,
      a.deskripsi_followup
    FROM master_kunjungan a
    JOIN temp_customer b ON a.customer_id = b.ID
    JOIN master_user c ON a.sales = c.user_id
    ORDER BY tgl_followup DESC
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
    array( 
        'db' => 'tgl_followup', 
        'dt' => 1, 
        'formatter' => function($d, $row){
            return date('d M Y', strtotime($d));
        }
    ),
    array( 'db' => 'customer_nama', 'dt' => 2 ),
    array( 'db' => 'user_nama', 'dt' => 3 ),
    array( 'db' => 'followup_by', 'dt' => 4 ),
    array( 'db' => 'ket', 'dt' => 5 ),
    array( 'db' => 'deskripsi_followup', 'dt' => 6 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);