<?php 
// $stat = $_GET['stat'];
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'horek940_salsys' 
); 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
      a.noso,
      b.customer_nama,
      COUNT(c.model) AS total_sku,
      SUM(c.qty) AS total_qty,
      d.nama_pt,
      a.sales
    FROM salesorder_hdr a
    LEFT JOIN master_customer b ON a.customer_id = b.customer_id
    JOIN salesorder_dtl c ON a.noso = c.noso
    JOIN list_perusahaan d ON a.id_perusahaan = d.id_perusahaan
    WHERE a.aproval_finance = '1' AND a.co_status = '0'
    GROUP BY c.noso
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
    array( 'db' => 'total_sku', 'dt' => 4 ),
    array( 'db' => 'total_qty', 'dt' => 5 ),
    array( 'db' => 'nama_pt', 'dt' =>6),
    array( 'db' => 'nama_pt', 'dt' =>7),
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);