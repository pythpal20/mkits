<?php 
function rupiah($angka){
	
	$hasil_rupiah = number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
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
      a.tgl_order,
      a.tgl_krm,
      a.no_bl,
      CONCAT( a.status_delivery,'|',IF(a.tgl_rescedhule IS NOT NULL, a.tgl_rescedhule, "-") ) AS status_tanggal,
      c.customer_nama,
      SUM(b.harga_total) AS uang,
      a.status,
      a.sales,
      a.issuedby,
      a.method,
      a.keterangan,
      f.wilayah_nama AS kota
    FROM customerorder_hdr a
    JOIN customerorder_dtl b ON a.No_Co = b.No_Co
    JOIN master_customer c ON a.customer_id = c.customer_id
    JOIN salesorder_hdr e ON a.noso = e.noso
    JOIN master_wilayah f ON c.customer_kota = f.wilayah_id
    WHERE NOT EXISTS (SELECT * FROM customerorder_hdr_delivery d WHERE a.No_Co = d.No_Co) AND (e.jenis_transaksi = 'KUNJUNGAN' OR e.jenis_transaksi ='TELEPON') AND YEAR(a.tgl_krm)>'2021' AND a.status = '1'
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
    array( 'db' => 'no_bl', 'dt' => 1 ),
    array( 'db' => 'tgl_order', 'dt' => 2 ),
    array( 'db' => 'tgl_krm', 'dt' => 3 ),
    array( 'db' => 'customer_nama', 'dt' => 4 ),
    array( 'db' => 'kota', 'dt' => 5 ),
    // array( 'db' => 'uang', 'dt' => 5, "formatter" => function ($d, $row){
    //     return rupiah($d);
    // }),
    array( 'db' => 'issuedby', 'dt' => 6),
    array( 'db' => 'sales', 'dt' =>7),
    array( 'db' => 'method', 'dt' => 8),
    array( 'db' => 'status_tanggal', 'dt' =>9, "formatter" => function ($d, $row){
        $status = explode("|", $d)[0];
        $tanggal = explode("|", $d)[1];
        if ($status== '0') {
         return "<label class='label label-default'>belum proses</label>";
         } else  if ($status == '1') {
             return "<label class='label label-primary'>sudah proses</label>" ;
         }else{
             return "<label class='label label-warning'>reschedule</label><br/>".$tanggal ;
         }
        
    } ),
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);