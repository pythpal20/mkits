<?php
$start = date("Y-m-d", strtotime($_POST['start']));
$end = date("Y-m-d", strtotime($_POST['end']));


function add_leading_zero($value, $threshold = 4) {
  return sprintf('%0'. $threshold . 's', $value);
}
include '../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
$sql = "
SELECT  *
  FROM customerorder_dtl_delivery
  WHERE  DATE_FORMAT(tgl_delivery, '%Y-%m-%d')  >= '$start' && DATE_FORMAT(tgl_delivery, '%Y-%m-%d') <= '$end'
";
// $sql = "
// SELECT  sum(a.qty_request-a.qty_kirim)as qty_sisa, b.tgl_delivery, b.No_Co,b.no_bl, b.no_sh,a.model,c.qty_kirim as qty_po,a.qty_kirim,
// a.qty_sisa_diterima,CONCAT(b.sopir,' - ',b.kenek) as pic,b.alasan, b.customer_nama,a.status_gudang
//   FROM customerorder_dtl_delivery a 
//    JOIN customerorder_hdr_delivery b ON a.No_Co = b.No_Co 
//    JOIN customerorder_dtl c ON c.No_Co = a.No_Co
//   WHERE  DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d')  >= '$start' && DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d') <= '$end'
// ";
$result = $db1->query($sql);

function status($angka){
if ($angka == "1") {
  return "Diterima";
} else if ($angka == "2") {
  return "Pending";
}else if ($angka == "3") {
  return "Pending Terkonfirmasi";
}else if ($angka == "4") {
  return "Close Pending";
}else{
  return "Belum diterima";
}

}

function ambil_data_header($No_CO){
  include '../config/connection.php';

  $sql = "
  SELECT  *
    FROM customerorder_hdr_delivery
    WHERE  No_Co ='$No_CO'
  ";
  $result = $db1->query($sql);
  $noco="";
  $nosh="";
  $nobl="";
  $pic="";
  $alasan="";
  $customer="";

  while ($row = $result->fetch_assoc()){
    $noco = $row['No_Co'];
    $nosh = $row['no_sh'];
    $nobl = $row['no_bl'];
    $pic = $row['sopir']." & ".$row['kenek'];
    $alasan = $row['alasan'];
    $customer = $row['customer_nama'];
  }
  return["nosh"=>$nosh, "noco" => $noco, "nobl"=> $nobl,"pic"=> $pic,"alasan" => $alasan,"customer"=> $customer];
}

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_delivery($start sampai $end).xls");  
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$html = "<table border='1'>
            <thead>
              <tr>
                <th>no</th>
                <th>Tanggal Kirim</th>
                <th>CO</th>
                <th>BL</th>
                <th>SKU</th>
                <th>SH</th>
                <th>Qty PO</th>
                <th>Qty Kirim</th>
                <th>Qty Kembali</th>
                <th>Qty Terima Gudang</th>
                <th>PIC</th>
                <th>Alasan Barang Kembali </th>
                <th>Customer</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              
        ";
        $no =0;
        while ($row = $result->fetch_assoc()) {
          $qty_sisa = (int)$row['qty_request']-(int)$row['qty_kirim'];
           $no++;
           $html .="<tr><td>".$no."</td>";
           $html .="<td>".$row['tgl_delivery']."</td>";
           $html .="<td>".$row['No_Co']."</td>";
           $html .="<td>".ambil_data_header($row['No_Co'])['nobl']."</td>";
           $html .="<td>".$row['model']."</td>";
           $html .="<td>".ambil_data_header($row['No_Co'])['nosh']."</td>";
           $html .="<td>".$row['qty_request']."</td>";
           $html .="<td>".$row['qty_kirim']."</td>";
           $html .="<td>". $qty_sisa."</td>";
           $html .="<td>".$row['qty_sisa_diterima']."</td>";
           $html .="<td>".ambil_data_header($row['No_Co'])['pic']."</td>";
          if ($qty_sisa !="0") {
            $html .="<td>".ambil_data_header($row['No_Co'])['alasan']."</td>";
          } else{
            $html .="<td></td>";
          }
         
           $html .="<td>".ambil_data_header($row['No_Co'])['customer']."</td>";
           $html .="<td>".status($row['status_gudang'])."</td></tr>";
        }

$html.="
          
        </tbody>
      </table>
    ";

    echo $html;
?>