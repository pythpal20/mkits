<?php 
// $modul = $_GET['ide'];
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'horek940_salsys', 
    'pass' => 'Garuda752021', 
    'db'   => 'horek940_salsys' 
); 
 
// DB table to use 
$table = <<<EOT
 (
    SELECT
        a.noso,
        b.customer_nama,
        a.sales,
        a.tgl_po,
        a.aproval_finance,
        a.co_status,
        c.nama_pt,
        CONCAT(a.aproval_finance, '|' , a.co_status) AS aksi,
        a.status
    FROM salesorder_hdr a
    JOIN master_customer b ON a.customer_id = b.customer_id
    JOIN list_perusahaan c ON a.id_perusahaan = c.id_perusahaan
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
    array( 'db' => 'sales', 'dt' => 3 ),
    array( 'db' => 'tgl_po', 'dt' => 4 ),
    array( 'db' => 'nama_pt', 'dt' => 5 ),
    array( 'db' => 'status',  'dt'=>6),
    array( 'db' => 'aproval_finance', 'dt' => 7 ),
    array( 'db' => 'co_status', 'dt' =>8),
    array( 'db' => 'aksi', 'dt' =>9)
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);