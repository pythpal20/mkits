<?php 
// $stat = $_GET['stat'];

// function ambil keepstock
function ambil_qty_keep($sku){

    // 0 => request
    // 1 => keep
    // 2 => complete
    // 3 => req cancel
    // 4 => canceled
    
    $sql_keep = "SELECT no_keepstock,model,
    (SELECT SUM(qty_req) FROM keepstock WHERE status_keep = '0' AND model ='$sku') as req ,
    (SELECT SUM(qty_keep) FROM keepstock WHERE status_keep = '1'  AND model ='$sku') as kept ,
    (SELECT SUM(qty_keep) FROM keepstock WHERE status_keep = '3'  AND model ='$sku') as req_cancel ,
    (SELECT SUM(qty_keep) FROM keepstock WHERE status_keep = '2'  AND model ='$sku') as complete 
    FROM keepstock GROUP BY model ";  


    include '../../config/connection.php';
    $mwk = $db1->prepare($sql_keep); 
    $mwk->execute();
    $resl = $mwk->get_result();
     
    $qty_keep="";
    $qty_req="";
    $qty_complete="";
    $qty_req_cancel="";
    
    while ($data = $resl->fetch_assoc()) {
        $qty_keep = $data['kept'];
        $qty_req = $data['req'];
        $qty_complete = $data['complete'];
        $qty_req_cancel=$data['req_cancel'];
    }
    return ["qty_req" => $qty_req, "qty_keep" => $qty_keep, "qty_complete" => $qty_complete, "qty_req_cancel" => $qty_req_cancel];
}



// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'horek940_ngudang', 
    'pass' => 'garuda75', 
    'db'   => 'horek940_ngudang' 
); 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT s.id, i.model as sku,
    s.g1_stok as stok
    FROM gdg_stocklocation s
     JOIN gdg_item i ON s.barcode = i.barcode 
    
    GROUP BY s.barcode
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'sku', 'dt' => 0 ),
    array( 'db' => 'sku', 'dt' => 1 ),
    array( 'db' => 'sku', 'dt' => 2, 'formatter' => function( $d, $row ) {
        return (int)ambil_qty_keep($d)['qty_req'];
    }),
    array( 'db' => 'sku', 'dt' => 3, 'formatter' => function( $d, $row ) {
        return (int)ambil_qty_keep($d)['qty_keep'];
    }),
    array( 'db' => 'sku', 'dt' => 4, 'formatter' => function( $d, $row ) {
        return (int)ambil_qty_keep($d)['qty_req_cancel'];
    }),
    array( 'db' => 'sku', 'dt' => 5, 'formatter' => function( $d, $row ) {
        return (int)ambil_qty_keep($d)['qty_complete'];
    }),
    array( 'db' => 'stok', 'dt' => 6 ),
    
    
    
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);