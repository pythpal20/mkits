<?php 
// $nilai = $_GET['nilai'];
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
      a.sales,
      SUM(b.harga_total) AS total,
      a.status,
      a.ongkir,
      concat(a.status,'|', a.co_status) AS statu
    FROM salesorder_hdr a
    LEFT JOIN salesorder_dtl b ON a.noso = b.noso
    LEFT JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE jenis_transaksi = 'SHOWROOM'
    GROUP BY b.noso
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'noso'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'noso', 'dt' => 0 ),
    array( 'db' => 'noso', 'dt' => 1 ), 
    array( 'db' => 'tgl_po',  'dt' => 2 ), 
    array( 'db' => 'customer_nama',      'dt' => 3 ), 
    array( 'db' => 'sales',     'dt' => 4 ), 
    array( 'db' => 'total',  'dt' => 5), 
    array( 
        'db' => 'status', 
        'dt'  => 6,
        'formatter' => function($d, $row) {
             if ($d == 1) {
                 return 'PROCESS' ;
                } elseif($d == 2) {
                    return 'CANCEL';
                } else {
                    return 'UNPROCESS';
                }
        }
    ),
    array( 'db' => 'statu', 'dt' => 7)
); 

// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);