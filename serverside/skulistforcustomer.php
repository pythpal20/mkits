<?php 
$idcustomer = $_GET['idcustomer'];
// Database connection info 
include 'aconnection.php';
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT
        b.model, 
        SUM(IF(MONTH(a.tgl_order)="01", b.qty_kirim, 0)) AS Jan,
        SUM(IF(MONTH(a.tgl_order)="02", b.qty_kirim, 0)) AS Feb,
        SUM(IF(MONTH(a.tgl_order)="03", b.qty_kirim, 0)) AS Mar,
        SUM(IF(MONTH(a.tgl_order)="04", b.qty_kirim, 0)) AS Apr,
        SUM(IF(MONTH(a.tgl_order)="05", b.qty_kirim, 0)) AS Mei,
        SUM(IF(MONTH(a.tgl_order)="06", b.qty_kirim, 0)) AS Jun,
        SUM(IF(MONTH(a.tgl_order)="07", b.qty_kirim, 0)) AS Jul,
        SUM(IF(MONTH(a.tgl_order)="08", b.qty_kirim, 0)) AS Ags,
        SUM(IF(MONTH(a.tgl_order)="09", b.qty_kirim, 0)) AS Sep,
        SUM(IF(MONTH(a.tgl_order)="10", b.qty_kirim, 0)) AS Okt,
        SUM(IF(MONTH(a.tgl_order)="11", b.qty_kirim, 0)) AS Nov,
        SUM(IF(MONTH(a.tgl_order)="12", b.qty_kirim, 0)) AS Des
    FROM customerorder_dtl b 
    LEFT JOIN customerorder_hdr a
    ON b.No_Co = a.No_Co
    WHERE a.status ='1' AND (a.customer_id = "$idcustomer" AND YEAR(a.tgl_order) = YEAR(CURRENT_DATE()))
    GROUP BY b.model
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'model';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'model', 'dt' => 0 ),
    array( 'db' => 'Jan', 'dt' => 1),
    array( 'db' => 'Feb', 'dt' => 2),
    array( 'db' => 'Mar', 'dt' => 3),
    array( 'db' => 'Apr', 'dt' => 4),
    array( 'db' => 'Mei', 'dt' => 5),
    array( 'db' => 'Jun', 'dt' => 6),
    array( 'db' => 'Jul', 'dt' => 7),
    array( 'db' => 'Ags', 'dt' => 8),
    array( 'db' => 'Sep', 'dt' => 9),
    array( 'db' => 'Okt', 'dt' => 10),
    array( 'db' => 'Nov', 'dt' => 11),
    array( 'db' => 'Des', 'dt' => 12)
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);