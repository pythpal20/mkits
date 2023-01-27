<?php 
// $stat = $_GET['stat'];
 // function id
 function add_leading_zero($value, $threshold = 4) {
    return sprintf('%0'. $threshold . 's', $value);
}

// function ambil status keepstock header
function ambilStatusperkeepstock($no_keepstock){
    include '../../config/connection.php';

    $sql="SELECT status_keep FROM keepstock WHERE no_keepstock ='$no_keepstock' ";
    $result = $db1->query($sql);
    $status_array = [];
    $status = "";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // cek apakah ada status 0
            array_push($status_array, $row['status_keep']);
        }
    } else {

    }

    if (in_array("0", $status_array)) {
        $status = "Belum disiapkan semua";
    } else if (in_array("1", $status_array)) {
        $status = "Sudah disiapkan semua";
    }else{
        $status = "P/T done";
    }
    
    return $status;
    
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
    SELECT distinct no_keepstock FROM keepstock ORDER BY no_keepstock DESC
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'no_keepstock';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'no_keepstock', 'dt' => 0 ),
    array( 'db' => 'no_keepstock', 'dt' => 1, 'formatter' => function( $d, $row ) {
        return 'K-'.add_leading_zero($d);
    }),
    array( 'db' => 'no_keepstock', 'dt' => 2, 'formatter' => function( $d, $row ) {
        if (ambilStatusperkeepstock($d)=="Sudah disiapkan semua") {
            return "<label class='label label-primary'>".ambilStatusperkeepstock($d)."</label>";
        } else if (ambilStatusperkeepstock($d)=="Belum disiapkan semua") {
            return "<label class='label label-warning'>".ambilStatusperkeepstock($d)."</label>";
        }else{
            return "<label class='label label-success'>".ambilStatusperkeepstock($d)."</label>";
        }
        
        },
    ),
    array( 'db' => 'no_keepstock', 'dt' => 3, 'formatter' => function( $d, $row ) {
      
           return "<form target='_blank' method='get' action='exportkeepstock.php'>
           <input type='hidden' name='id' value='".$d."'>
           <center>
           <button type='submit' class='btn btn-default btn-sm print' no_keepstock='".$d."' >
           <i class='fa fa-print'></i> 
           </button>
           </center>
           </form>";
      
        },
    ),
);
// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
	SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null)
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);