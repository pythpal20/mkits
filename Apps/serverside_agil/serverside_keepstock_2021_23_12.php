<?php 
session_start(); 
   
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
    }else if (in_array("2", $status_array)){
        $status = "P/T done";
    }else if (in_array("3", $status_array)){
        $status = "Request Cancel";
    }else{
        $status = "Canceled";
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
    SELECT distinct no_keepstock, customer, noso FROM keepstock ORDER BY no_keepstock DESC
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'no_keepstock';
 
// indexes
$columns = array(
    array( 'db' => 'no_keepstock', 'dt' => 0 ),
    array( 'db' => 'no_keepstock', 'dt' => 1, 'formatter' => function( $d, $row ) {
        return 'K-'.add_leading_zero($d);
    }),
    array( 'db' => 'customer', 'dt' => 2 ),
    array( 'db' => 'noso', 'dt' => 3 ),
    array( 'db' => 'no_keepstock', 'dt' => 4, 'formatter' => function( $d, $row ) {
        if (ambilStatusperkeepstock($d)=="Sudah disiapkan semua") {
            return "<label class='label label-primary'>".ambilStatusperkeepstock($d)."</label>";
        } else if (ambilStatusperkeepstock($d)=="Belum disiapkan semua") {
            return "<label class='label label-warning'>".ambilStatusperkeepstock($d)."</label>";
        }else if (ambilStatusperkeepstock($d)=="P/T done"){
            return "<label class='label label-success'>".ambilStatusperkeepstock($d)."</label>";
        }else if (ambilStatusperkeepstock($d)=="Request Cancel"){
            return "<label class='label label-danger'>".ambilStatusperkeepstock($d)."</label>";
        }else{
            return "<label class='label label-default'>".ambilStatusperkeepstock($d)."</label>";
        }
        },
    ),
    array( 'db' => 'no_keepstock', 'dt' => 5, 'formatter' => function( $d, $row ) {
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
    array( 'db' => 'no_keepstock', 'dt' => 6, 'formatter' => function( $d, $row ) {

        // $stat = $_GET['stat'];
        include '../../config/connection.php';
        
        $id = $_SESSION['idu'];
        $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
        $mwk = $db1->prepare($query); 
        $mwk->execute();
        $resl = $mwk->get_result();
        $data = $resl->fetch_assoc(); 
        
        $cancel="<button class='btn btn-danger btn-sm cancel' title='Cancel' rel='tooltip'><span class='fa fa-close'></span></button>";
        $gak_cancel="";
        
        $retVal = (ambilStatusperkeepstock($d) !="P/T done" && ambilStatusperkeepstock($d) !="Request Cancel" && ambilStatusperkeepstock($d) !="Belum disiapkan semua" && ambilStatusperkeepstock($d) !="Canceled" && $data['modul'] == "1" &&  $data['level'] == "admin" ) ? $cancel : $gak_cancel ;
        return "<button class='btn btn-default btn-sm seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>".$retVal;
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