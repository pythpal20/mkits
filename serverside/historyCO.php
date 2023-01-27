<?php 
$ide = $_GET['ide'];
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
      a.No_Co,
      SUBSTRING(a.No_Co, 5) AS id_CO,
      a.no_fa,
      a.tgl_inv,
      a.tgl_order,
      a.noso,
      a.sales,
      SUM(b.harga_total) AS total
    FROM customerorder_hdr a
    JOIN customerorder_dtl b ON a.No_Co = b.No_Co
    WHERE a.customer_id = '$ide' AND a.status != '2' 
    GROUP BY b.No_Co
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
    array( 'db' => 'no_fa', 'dt' => 1 ),
    array( 'db' => 'tgl_inv', 'dt' => 2 ),
    array( 'db' => 'noso', 'dt' => 3 ),
    array( 'db' => 'id_CO', 'dt' => 4 ),
    array( 'db' => 'sales', 'dt' => 5 ),
    array( 'db' => 'tgl_order', 'dt' => 6 ),
    array( 'db' => 'total', 'dt' => 7 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);