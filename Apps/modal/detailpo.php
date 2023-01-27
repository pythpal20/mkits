<?php
include '../../config/connection.php';
session_start();
if (!isset($_SESSION['usernameu'])) {
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
  $query = "SELECT ph.sales, ph.noso, ph.tgl_po, cs.customer_nama,ph.alamat_krm, ph.keterangan, ph.jenis_transaksi
           FROM salesorder_hdr ph JOIN master_customer cs ON ph.customer_id = cs.customer_id 
           WHERE ph.noso = '" . $_POST["id"] . "'";
  $result = mysqli_query($connect, $query);

  $ong = "SELECT ongkir, status FROM salesorder_hdr WHERE noso='" . $_POST["id"] . "'";
  $mwk = $db1->prepare($ong);
  $mwk->execute();
  $resl1 = $mwk->get_result();
  $okr = $resl1->fetch_assoc();
  // var_dump($okr); die();
  $output .= '
  <div class="table-responsive">  
    <table class="table table-bordered">
      <tr class="table-info">
        <th colspan="4">Data Customer</th>
      </tr>';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '
      <tr>
        <th class="col-sm-2"><label>Sales</label></th>
        <td>' . $row["sales"] . '</td>
        <th class="col-sm-2"><label>Jenis Transaksi</label></th>
        <td>' . $row["jenis_transaksi"] . '</td>
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
if (isset($_POST["id"])) {
  $output = '';
  $query = "SELECT * FROM salesorder_dtl WHERE noso = '" . $_POST["id"] . "' ORDER BY no_urut";
  $result = mysqli_query($connect, $query);
  $output .= ' 
  <div class="table-responsive">  
    <table class="table table-bordered tableModal taablePo" id="taablePo">
      <tr>
          <th colspan="9" class="table-info">Detail Transaksi</th>
      </tr>
      <tr>
        <th width="15%"><label>SKU</label></th> 
        <th width="8%"><label>Qty.</label></th>  
        <th><label>Harga</label></th>
        <th><label>Pengajuan</label></th>
        <th><label>Amount</label></th>
        <th><label>Disk</label></th>
        <th><label>PPN</label></th>  
        <th>ID Promo</th>
        <th width="15%"><label>Harga Total</label></th>
      </tr>';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '
      <tr> 
        <td>' . $row["model"] . '</td> 
        <td>' . $row["qty"] . '</td> 
        <td>Rp. ' . number_format($row["price"], 0, ".", ".") . '</td> 
        <td width="8%">Rp. ' . number_format($row["harga_request"], 0, ".", ".") . '</td> 
        <td>Rp. ' . number_format($row['amount'], 0, ".", ".") . '</td>
        <td>Rp. ' . number_format($row["diskon"], 0, ".", ".") . '</td>
        <td>Rp. ' . number_format($row["ppn"], 0, ".", ".") . '</td>
        <td width="10%">' . $row["promo_id"] . '</td>
        <td>Rp. ' . number_format($row["harga_total"], 0, ".", ".") . '</td>
      </tr>';
  }
  $output .= '</table></div>';
  echo $output;
}
?>

<?php
if (isset($_POST["id"])) {
  $output = '';
  $query = "SELECT SUM(qty) as total_barang, SUM(price) as total_harga, sum(diskon) AS disc, sum(ppn) AS pajak, sum(amount) as amount, sum(harga_total) AS ttl FROM salesorder_dtl WHERE noso = '" . $_POST["id"] . "'";
  $result = mysqli_query($connect, $query);
  $output .= '  
  <div class="table-responsive">  
    <table class="table table-bordered">';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '<tr> 
        <th width="15%">TOTAL</th>
        <th width="8%">' . $row["total_barang"] . '</th> 
        <th >Rp. ' . number_format($row["total_harga"], 0, ".", ".") . '</th>
        <th width="8%"></th>
        <th >Rp. ' . number_format($row["amount"], 0, ".", ".") . '</th>  
        <th >Rp. ' . number_format($row["disc"], 0, ".", ".") . '</th>
        <th >Rp.' . number_format($row["pajak"], 0, ".", ".") . '</th> 
        <th width="10%"></th>
        <th width="15%">Rp. ' . number_format($row["ttl"], 0, ".", ".") . '</th>
      </tr>';
  }
  $output .= '<tr>
        <th colspan="8">ONGKIR</th>
        <th>Rp. ' . number_format($okr["ongkir"], 0, ".", ".") . '</th>
      </tr>';
  $output .= '</table></div>';
  $output .= '<div class="btn-group pull-left">';
  if ($okr['status'] == '1' && $dt['level'] !== 'sales') {
      $output .= '<a href="printsco.php?id=' . $_POST["id"] . '" class="btn btn-primary fill-right"><span class="fa fa-file-pdf-o"></span> SCO</a>
      <a href="printpo.php?id=' . $_POST["id"] . '" class="btn btn-info fill-right"><span class="fa fa-shopping-cart"></span> PO</a>
      <a href="requestpt.php?id=' . $_POST["id"] . '" class="btn btn-success fill-right"><span class="fa fa-ticket"></span> Request Picktiket</a>';
    } else if ($dt['level'] == 'sales') { 
        $output .= '<a href="printnota.php?id=' . $_POST["id"] . '" class="btn btn-warning fill-right"><span class="fa fa-file-text-o"></span> Nota</a>';
        $output .= '</div>';
    }else {
      $output .= '<button type="close" class="btn btn-default fill-right">Close</button>';
    }
     
  echo $output;
}
?>