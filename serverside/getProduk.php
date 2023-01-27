<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'master_produk';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'barcode', 'dt' => 0 ),
    array( 'db' => 'model', 'dt' => 1 ),
    array( 'db' => 'kategori', 'dt' => 2 ),
    array( 'db' => 'deskripsi', 'dt' => 3 ),
    array( 
        'db' => 'harga',
        'dt'=> 4,
        'formatter' => function( $d, $row ) {
            return 'Rp. '.number_format($d);
        }
    )
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'horek940_salsys',
    'pass' => 'Garuda752021',
    'db'   => 'horek940_salsys',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class2.php' );
$where = "status ='1'";
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
);