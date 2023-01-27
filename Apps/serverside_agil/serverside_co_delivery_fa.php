<?php 
session_start(); 

function rupiah($angka){
	
	$hasil_rupiah = number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}

// function ambil status keepstock header
function hitungterima($noco){
    include '../../config/connection.php';

    $sql="SELECT status_gudang FROM customerorder_dtl_delivery WHERE No_Co ='$noco' AND qty_request != qty_kirim ";
    $result = $db1->query($sql);
    $status_array = [];
    $status = "";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // cek apakah ada status 0
            array_push($status_array, $row['status_gudang']);
        }
    } else {

    }

 
    if (in_array("0", $status_array)) {
        $status = "Belum diterima semua";
    } else if (in_array("2", $status_array) ) {
        $status = "Sudah diterima dan ada pending";
    }else if (in_array("3", $status_array) ) {
        $status = "Sudah diterima dan ada pending terkonfirmasi";
    }else if (in_array("4", $status_array)){
        $status = "Sudah diterima dan ada close";
    }
    else if (in_array("1", $status_array)){
        $status = "Sudah diterima semua";
    }else{
        $status= "- tidak perlu";
    }
    return $status;
    
}
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'horek940_salsys', 
    'pass' => 'Garuda752021', 
    'db'   => 'horek940_salsys'
); 
 
// DB table to use 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
      a.No_Co,
      a.tgl_order,
      a.tgl_krm,
      a.tgl_delivery,
      a.no_bl,
      a.no_fa,
      a.status_delivery,
      c.customer_nama,
      SUM(b.harga_total) AS uang,
      a.status,
      a.sales,
      a.issuedby,
      a.keterangan
    FROM customerorder_hdr_delivery a
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
    JOIN master_customer c ON a.customer_id = c.customer_id
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
    array( 'db' => 'tgl_delivery', 'dt' => 1 ),
    array( 'db' => 'no_fa', 'dt' =>2 ),
    array( 'db' => 'no_bl', 'dt' =>3),
    // array( 'db' => 'tgl_order', 'dt' => 2 ),
    // array( 'db' => 'tgl_krm', 'dt' => 3 ),
    array( 'db' => 'customer_nama', 'dt' => 4 ),
    array( 'db' => 'uang', 'dt' => 5, "formatter" => function ($d, $row){
        return rupiah($d);
    }),
    array( 'db' => 'status_delivery', 'dt' =>6,  "formatter" => function ($d, $row){
        if ($d == '0') {
            return "<label class='label label-default'>belum delivery</label>";
        } else if ($d == '1') {
            return "<label class='label label-primary'>Sudah delivery</label>";
        }else if ($d == '2') {
            return "<label class='label label-warning'>Sudah delivery dengan alasan</label>";
        }else{
            return "<label class='label label-success'>Completed</label>";
        }
        
    }),
    array( 'db' => 'No_Co', 'dt' =>7,  "formatter" => function ($d, $row){
        if (hitungterima($d)=="Sudah diterima semua") {
            return "<label class='label label-success'>".hitungterima($d)."</label>";
        } else if (hitungterima($d)=="Belum diterima semua") {
            return "<label class='label label-warning'>".hitungterima($d)."</label>";
        }else if (hitungterima($d)=="Sudah diterima dan ada pending terkonfirmasi"){
            return "<label class='label label-info'>".hitungterima($d)."</label>";
        }else if (hitungterima($d)=="Sudah diterima dan ada pending"){
            return "<label class='label label-danger'>".hitungterima($d)."</label>";
        }else if (hitungterima($d)=="Sudah diterima dan ada close"){
            return "<label class='label label-secondary'>".hitungterima($d)."</label>";
        }else{
            return "<label class='label label-default'>".hitungterima($d)."</label>";
        }
        
    }),
    array( 'db' => 'status_delivery', 'dt' =>8, 'formatter' => function( $d, $row ) {

        // $stat = $_GET['stat'];
        include '../../config/connection.php';
        
        $id = $_SESSION['idu'];
        $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
        $mwk = $db1->prepare($query); 
        $mwk->execute();
        $resl = $mwk->get_result();
        $data = $resl->fetch_assoc(); 
        $buttonView =
        "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        $buttonPrint =
        "<button class='btn btn-default btn-xs print_fa' title='Print FA' rel='tooltip'><span class='fa fa-print'></span></button>";
        $buttonApprove =
        "<button class='btn btn-primary btn-xs approve_fa' title='approve fa' rel='tooltip'><span class='fa fa-check'></span></button>";
        $no_approve="";
        
        $retVal = ( $d !="3" && $data['modul'] == "2"  ) ? $buttonApprove : $no_approve ;
        $print = ( $d =="3" && $data['modul'] == "2"  ) ? $buttonPrint : $no_approve ;
        return $buttonView.$retVal;
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