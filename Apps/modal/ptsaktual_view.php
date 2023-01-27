<?php
  include '../../config/connection.php';
  session_start(); 
  $akses = $_SESSION['moduls'];
  if (!isset($_SESSION['usernameu'])){
    header("Location: ../index.php");
  }
  $id = $_SESSION['idu'];
  $query_u = "SELECT * FROM master_user
  WHERE user_id='$id'"; 
  $mwk = $db1->prepare($query_u); 
  $mwk->execute();
  $res1 = $mwk->get_result();
  $dt = $res1->fetch_assoc(); 
//select.php  
if (isset($_POST["id"])) {
  error_reporting();
  $output = '';
  $qr = "SELECT * FROM pts_header WHERE idPts = '". $_POST['id'] ."'";
  $mwk = $db1->prepare($qr);
  $mwk->execute();
  $hsl = $mwk->get_result();
  $wr = $hsl->fetch_assoc();

  $output .= '  
    <div class="table-responsive">  
    <table class="table table-bordered">';
        $output .= ' <tr>
      <th class="col-sm-2"><label>Sales</label></th>
      <td>'. $wr["sales"] .'</td>
      <th class="col-sm-2"><label>Status Sample</label></th>';
      if($wr["status"] == "1"){
          $statuss = "Kembali";
        } elseif($wr["status"] == "2") {
            $statuss = "Tidak Kembali";
        } else {
            $statuss = "Dibeli";
        }
      $output .= '<td>' . $statuss . '</td>
    </tr>
     <tr>
        <th class="col-sm-2"><label>No PTS</label></th>  
        <td width="30%"><b>' . $wr["idPts"] . '</b></td>  
        
        <th class="col-sm-2"><label>Customer</label></th>  
        <td width="50%">' . $wr["customer_nama"] . '</td>
     </tr>
     <tr>  
        <th class="col-sm-2"><label>Tgl. diambil</label></th>  
        <td width="30%">' . $wr["tgl_ambil"] . '</td>';  
        if ($wr['status'] == '1') {
            $output .= '<th>Tgl. Kembali</th>
            <td>' . $wr['tgl_kembali']. '</td>';
        } elseif ($wr['status'] == '3') {
            $output .='<th>Detail</th>
            <td>' . $wr['keterangan_beli'] . '</td>';
        }
     $output .= '</tr>
     <tr>
      <th class="col-sm-2"><label>Alamat</label></th>
      <td>' . $wr["alamat"] . '</td>
      <th>Kota</th>
      <td>' . $wr["kota"] . '</td>
     </tr>
     <tr>
      <th class="col-sm-2"><label>Note</label></th>
      <td colspan="3">' . $wr["keterangan"] . '</td>
     </tr>';

  $output .= '</table></div>';
  echo $output;
}
?>

<?php
//select.php  
if (isset($_POST["id"])) {
  $output = '';
  // $connect = mysqli_connect("localhost", "root", "", "db_customer");
  $query = "SELECT * FROM pts_detail_aktual WHERE idPts = '" . $_POST["id"] . "' ORDER BY nourut";
  $result = mysqli_query($connect, $query);
  $output .= ' 
    <div class="table-responsive">  
    <table class="table table-striped table-bordered">
        <thead class="table-warning">
            <tr>
                <th class="col-sm-1" width="20%"><label>SKU</label></th> 
                <th class="col-sm-1" width="10%"><label>Qty.</label></th>';
                if ($wr['status'] == 1) {
                $output .= '<th class="col-sm-1" width="10%"><label>QTY Kembali</label></th>
                <th width="20%">Tgl Kembali</th>';
                }
                $output .= '<th class="col-sm-1" width="20%"><label>Harga</label></th>
                <th class="col-sm-1" width="20%"><label>Amount</label></th>
            </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '
            <tr> 
                <td>' . $row["model"] . '</td> 
                <td>' . $row["qty_aktual"] . '</td>';
                if($wr['status'] == 1) {
                  $output .= '<td>' . $row["qty_kembali"] . '</td>
                  <td>' . $row['tgl_kembali'] . '</td>';
                } 
                $output .= '<td>Rp. ' . number_format($row["harga_aktual"],0,".",".") . '</td> 
                <td>Rp. ' . number_format($row['amount_aktual'],0,".",".") . '</td>
            </tr>';
    }
        $qry = "SELECT SUM(qty_aktual) as total_barang, SUM(qty_kembali) as tot_kembali, SUM(harga_aktual) as total_harga, sum(amount_aktual) as amount FROM pts_detail_aktual WHERE idPts = '" . $_POST["id"] . "'";
        $mwk = $db1->prepare($qry);
        $mwk->execute();
        $rels = $mwk->get_result();
        $rw = $rels->fetch_assoc();
        $output .= '<tr>  
        <th class="col-sm-1">TOTAL</th>
        <th class="col-sm-1">' . $rw["total_barang"] . '</th>';
        if($wr['status'] == 1) {
          $output .='<th class="col-sm-1">' . $rw["tot_kembali"] . '</th>
          <td></td>';
        }
        $output .= '<th class="col-sm-1">Rp. ' . number_format($rw["total_harga"],0,".",".") . '</th>
        <th class="col-sm-1">Rp. ' . number_format($rw["amount"],0,".",".") . '</th> 
        </tr>'; 
  $output .= '</tbody></table></div>';
  echo $output;
}
?>

<?php
//select.php  
if (isset($_POST["id"])) {
  $output = '';
  // $connect = mysqli_connect("localhost", "root", "", "db_customer");
  $output .= '<div class="btn-group pull-left">';
  if($dt['level'] == 'admin' || $dt['level'] == 'superadmin') {
      if ($wr['app_admin'] == '1' && $wr['app_akunting'] == '1') {
          $output .= '<a href="printptsaktual.php?id='.$_POST["id"].'" class="btn btn-danger fill-right"><span class="fa fa-file-pdf-o"></span> '.$_POST["id"].'.pdf</a>';
      }
  }
}
  echo $output;
?>