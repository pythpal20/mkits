<?php 
// $kategori = $_GET['kategori'];
// Database connection info 
include 'aconnection.php'; 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT a.fpp_id, 
        b.noso, 
        a.fpp_tanggal, 
        c.customer_nama,
        a.approvl,
        b.sales 
    FROM master_fpp a 
    JOIN salesorder_hdr b ON a.noso = b.noso
    JOIN master_customer c ON b.customer_id = c.customer_id
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'fpp_id';
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'fpp_id', 'dt' => 0 ),
    array( 'db' => 'fpp_id', 'dt' => 1 ),
    array( 'db' => 'noso', 'dt' => 2 ),
    array( 'db' => 'fpp_tanggal', 'dt' => 3 ),
    array( 'db' => 'customer_nama', 'dt' => 4 ),
    array( 'db' => 'sales', 'dt' => 5 ),
    array( 'db' => 'approvl', 'dt' => 6 ),
    array( 'db' => 'approvl', 'dt' => 7 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);