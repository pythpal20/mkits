<?php
session_start();
$id = $_GET['id'];
// Database connection info 
include '../../../serverside/aconnection.php';

// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
      d.tgl_inv,
      d.no_fa AS nofa_awal,
      a.noso,
      a.No_Co,
      c.customer_nama,
      d.sales,      
      (SELECT SUM(e.harga_total) FROM customerorder_dtl e WHERE e.No_co = a.No_Co)  AS nominal_awal,
      (SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)  AS nominal_akhir,
      a.tgl_delivery,    
      f.tgl_kontrabon,    
      f.tgl_duedate, 
      IFNULL(((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)), 'belum bayar') AS selisih,
      (SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco) AS total_bayar,  
      DATEDIFF( NOW(), f.tgl_duedate ) AS overdue,  
      a.no_fa AS nofa_akhir
    FROM customerorder_hdr_delivery a
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
    JOIN customerorder_dtl e ON a.No_Co = e.No_Co
    JOIN master_customer c ON a.customer_id = c.customer_id
    JOIN customerorder_hdr d ON a.No_Co = d.No_Co
    LEFT JOIN kontrabon f ON a.No_Co = f.noco
    LEFT JOIN detail_penagihan g ON a.No_Co =g.noco
    WHERE d.id_perusahaan LIKE '$id' AND (((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)) IS NULL OR ((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)) < '0')
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
    array('db' => 'tgl_inv', 'dt' => 0),
    array(
        'db' => 'nofa_awal', 
        'dt' => 1,
        'formatter' => function($d, $row) {
            return substr($d, 4);
        }
    ),
    array('db' => 'noso', 'dt' => 2),
    array('db' => 'customer_nama', 'dt' => 3),
    array('db' => 'sales', 'dt' => 4),
    array('db' => 'nominal_awal', 'dt' => 5),
    array('db' => 'nominal_akhir', 'dt' => 6),
    array('db' => 'tgl_kontrabon', 'dt' => 7),
    array('db' => 'tgl_duedate', 'dt' => 8),
    array('db' => 'overdue', 'dt' => 9),
    array('db' => 'total_bayar', 'dt' => 10),
    array('db' => 'selisih', 'dt' => 11),
    array( 'db' => 'No_Co', 'dt' => 12)

);
// Include SQL query processing class 
require 'ssp.php';

// require('ssp.class.php');

// Output data as json format 
echo json_encode(
    SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);
