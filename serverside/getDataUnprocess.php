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
      a.tgl_po,
      c.customer_nama,
      SUM(b.harga_total) AS total,
      d.nama_pt,
      a.term,
      a.sales
    FROM salesorder_hdr a
    LEFT JOIN salesorder_dtl b ON a.noso = b.noso
    LEFT JOIN master_customer c ON a.customer_id = c.customer_id
    JOIN list_perusahaan d ON a.id_perusahaan = d.id_perusahaan
    WHERE a.aproval_finance = '0' AND a.status = '1'
    GROUP BY b.noso
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
    array( 'db' => 'tgl_po', 'dt' => 2 ),
    array( 'db' => 'customer_nama', 'dt' => 3 ),
    array( 'db' => 'nama_pt', 'dt' => 4 ),
    array( 'db' => 'term', 'dt' => 5 ),
    array( 'db' => 'total', 'dt' => 6 ),
    array( 'db' => 'sales', 'dt' => 7 )
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);