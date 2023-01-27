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
      d.nama_pt,
      a.term,
      a.aproval_finance,
      a.aproval_by
    FROM salesorder_hdr a
    LEFT JOIN master_customer c ON a.customer_id = c.customer_id
    JOIN list_perusahaan d ON a.id_perusahaan = d.id_perusahaan
    WHERE a.aproval_finance != '0'
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
    array( 
        'db' => 'aproval_finance', 
        'dt' => 6 ,
        'formatter' => function($d, $row) {
            if ($d == 1) {
                return 'PROCESS' ;
               } elseif($d == 2) {
                   return 'PENDING';
               } else {
                   return 'CANCEL';
               }
        }),
    array( 'db' => 'aproval_by', 'dt' =>7)
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);