<?php 
$ide = $_GET['ide'];
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
        c.customer_nama, 
        a.No_Co, 
        a.noso,
        tgl_order, 
        b.model, 
        b.qty_kirim, 
        b.price, 
        b.amount, 
        b.diskon, 
        b.ppn, 
        b.harga_total ,
        substring(a.no_fa,5) AS NoFa
    FROM customerorder_hdr a
JOIN customerorder_dtl b ON a.No_Co = b.No_Co
JOIN master_customer c ON a.customer_id = c.customer_id
WHERE c.customer_id = '$ide' AND a.status != '2'
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'No_Co';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'No_Co', 'dt' => 0 ),
    array( 'db' => 'NoFa', 'dt' => 1 ),
    array( 'db' => 'noso', 'dt' => 2),
    array( 'db' => 'tgl_order', 'dt' => 3 ),
    array( 'db' => 'model', 'dt' => 4 ),
    array( 'db' => 'qty_kirim', 'dt' => 5 ),
    array( 'db' => 'price', 'dt' => 6 ),
    array( 'db' => 'diskon', 'dt' => 7 ),
    array( 'db' => 'ppn', 'dt' => 8 ),
    array( 'db' => 'amount', 'dt' => 9 ),
    array( 'db' => 'harga_total', 'dt' => 10 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);