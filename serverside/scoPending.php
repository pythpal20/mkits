<?php 
$stat = $_GET['stat'];
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
    SELECT 
        a.noso,
        b.customer_nama,
        COUNT(d.model) AS total_sku,
        c.nama_pt
    FROM customerorder_hdr_pending a
    JOIN master_customer b ON a.customer_id = b.customer_id
    JOIN list_perusahaan c ON a.id_perusahaan = c.id_perusahaan
    JOIN customerorder_dtl_pending d ON a.noso = d.noso
    GROUP BY d.noso
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'noso';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'noso', 'dt' => 0 ),
    array( 'db' => 'noso', 'dt' => 1 ),
    array( 'db' => 'customer_nama', 'dt' => 2 ),
    array( 'db' => 'total_sku', 'dt' => 3 ),
    array( 'db' => 'nama_pt', 'dt' => 4 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);