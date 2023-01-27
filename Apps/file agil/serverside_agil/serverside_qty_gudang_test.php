<?php 
// $stat = $_GET['stat'];

// function ambil keepstock
function ambil_qty_keep($sku){
    $sql_keep = "SELECT i.model AS sku, s.g1_stok as stok
     FROM gdg_stocklocation s 
      JOIN gdg_item i 
     ON s.barcode = i.barcode 
     WHERE i.model = '$sku' 
     GROUP BY s.barcode";


    include '../../config/connection.php';
    $mwk = $DB_AGIL->prepare($sql_keep); 
    $mwk->execute();
    $resl = $mwk->get_result();
     
    $qty="";

    while ($data = $resl->fetch_assoc()) {
        $qty = $data['stok'];
    }
    return ["qty_gdg" => $qty];
}



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
    SELECT no_keepstock,model,
    (SELECT SUM(qty_keep) FROM keepstock ) as kept ,
    (SELECT SUM(qty_keep) FROM keepstock  ) as complete ,
    (SELECT SUM(qty_req) FROM keepstock ) as req 
    FROM keepstock
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'no_keepstock';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'model', 'dt' => 0 ),
    array( 'db' => 'req', 'dt' => 1 ),
    array( 'db' => 'kept', 'dt' => 2 ),
    array( 'db' => 'complete', 'dt' => 3 ),
    array( 'db' => 'model', 'dt' => 4, 'formatter' => function( $d, $row ) {
        return ambil_qty_keep($d)['qty_gdg'];
    }),
    
    
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);