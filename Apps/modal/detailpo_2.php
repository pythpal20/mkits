<?php
include '../../config/connection.php';
session_start(); 
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
  error_reporting(0);
  $output = '';
  $query = "SELECT ph.sales, ph.noso, ph.tgl_po, cs.customer_nama,ph.alamat_krm, ph.keterangan
           FROM salesorder_hdr ph JOIN master_customer cs ON ph.customer_id = cs.customer_id 
           WHERE ph.noso = '" . $_POST["id"] . "'";
  $result = mysqli_query($connect, $query);



  $ong = "SELECT ongkir FROM salesorder_hdr WHERE noso='". $_POST["id"]."'";
  $mwk = $db1->prepare($ong);
  $mwk->execute();
  $resl1 = $mwk->get_result();
  $okr = $resl1->fetch_assoc();
  // var_dump($okr); die();
  $output .= '  
 <div class="table-responsive">  
 <table class="table table-bordered">';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '
    <tr>
      <th>Sales</th>
      <td colspan="3">'. $row["sales"] .'</td>
    </tr>
     <tr>
        <th class="col-sm-2"><label>No PO</label></th>  
        <td width="30%">' . $row["noso"] . '</td>  
        
        <th class="col-sm-2"><label>Nama Customer</label></th>  
        <td width="50%">' . $row["customer_nama"] . '</td> 
     </tr>
     <tr>  
        <th class="col-sm-2"><label>Tanggal</label></th>  
        <td width="30%" colspan="3">' . $row["tgl_po"] . '</td>  
     </tr>
     <tr>
      <th class="col-sm-2"><label>Alamat Kirim</label></th>
      <td colspan="3">' . $row["alamat_krm"] . '</td>
     </tr>
     <tr>
      <th class="col-sm-2"><label>Note</label></th>
      <td colspan="3">' . $row["keterangan"] . '</td>
     </tr>';
  }
  $output .= '</table></div>';
  echo $output;
}
?>

<?php
//select.php  
if (isset($_POST["id"])) {
  $output = '';
  // $connect = mysqli_connect("localhost", "root", "", "db_customer");
  $query = "SELECT * FROM salesorder_dtl WHERE noso = '" . $_POST["id"] . "' ORDER BY no_urut";
  $result = mysqli_query($connect, $query);
  $output .= ' 
  <div class="table-responsive">  
  <table class="table table-bordered tableModal">
  <tr>
    <td class="col-sm-1"><label>SKU</label></td> 
    <td class="col-sm-1"><label>Qty.</label></td>  
    <td class="col-sm-1"><label>Harga</label></td>
    <td class="col-sm-1"><label>Amount</label></td>
    <td class="col-sm-1"><label>Disk</label></td>
    <td class="col-sm-1"><label>PPN</label></td>  
    <td class="col-sm-1"><label>Harga Total</label></td>
  </tr>';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '
    <tr> 
      <td>' . $row["model"] . '</td> 
      <td>' . $row["qty"] . '</td> 
      <td>Rp. ' . number_format($row["price"],0,".",".") . '</td> 
      <td>Rp. ' . number_format($row['amount'],0,".",".") . '</td>
      <td>Rp. ' . number_format($row["diskon"],0,".",".") . '</td>
      <td>Rp. ' . number_format($row["ppn"],0,".",".") . '</td>
      <td>Rp. ' . number_format($row["harga_total"],0,".",".") . '</td>
    </tr>

     ';
  }
  $output .= '</table></div>';
  echo $output;
}
?>

<?php
//select.php  
if (isset($_POST["id"])) {
  $output = '';
  // $connect = mysqli_connect("localhost", "root", "", "db_customer");
  $query = "SELECT SUM(qty) as total_barang, SUM(price) as total_harga, sum(diskon) AS disc, sum(ppn) AS pajak, sum(amount) as amount, sum(harga_total) AS ttl FROM salesorder_dtl WHERE noso = '" . $_POST["id"] . "'";
  $result = mysqli_query($connect, $query);
  $output .= '  
 <div class="table-responsive">  
 <table class="table table-bordered">';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '
                <tr>  
                  <th class="col-sm-1">TOTAL</th>
                  <th class="col-sm-1">' . $row["total_barang"] . '</th> 
                  <th class="col-sm-1">Rp. ' . number_format($row["total_harga"],0,".",".") . '</th>
                  <th class="col-sm-1">Rp. ' . number_format($row["amount"],0,".",".") . '</th>  
                  <th class="col-sm-1">Rp. ' . number_format($row["disc"],0,".",".") . '</th>
                  <th class="col-sm-1">Rp.' . number_format($row["pajak"],0,".",".") . '</th> 
                  <th class="col-sm-1">Rp. ' . number_format($row["ttl"],0,".",".") . '</th>
                </tr>';
  }
  $output .= '<tr>
                  <th colspan="6">ONGKIR</th>
                  <th>Rp. '. number_format($okr["ongkir"],0,".",".") .'</th>
                </tr>';
  $output .= '</table></div>';
  $output .= '<div class="btn-group pull-left">';
  echo $output;
}
?>