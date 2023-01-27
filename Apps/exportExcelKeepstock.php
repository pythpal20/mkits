<?php
$start = date("Y-m-d", strtotime($_POST['start']));
$end = date("Y-m-d", strtotime($_POST['end']));


function add_leading_zero($value, $threshold = 4) {
  return sprintf('%0'. $threshold . 's', $value);
}
include '../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
$sql = "SELECT * FROM keepstock WHERE DATE_FORMAT(waktu_req, '%Y-%m-%d') >= '$start' && DATE_FORMAT(waktu_req, '%Y-%m-%d') <='$end' ";
$result = $db1->query($sql);

 // function status
 function status($value) {
  if ($value == "1") {
      return "kept";
  } else if ($value == "0"){
      return "requesting";
  }elseif ($value == "2") {
      return "completed";
  }elseif ($value == "3") {
      return "req cancel";
      # code...
  }elseif ($value == "4") {
      return "canceled";
      # code...
  }
  
}

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_keepstock($start sampai $end).xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$html = "<table border='1'>
            <thead>
              <tr>
                <th>no</th>
                <th>noso</th>
                <th>Tanggal Req</th>
                <th>no keepstock</th>
                <th>SKU</th>
                <th>Qty PO</th>
                <th>Qty Req</th>
                <th>Qty keep</th>
                <th>Keterangan Qty</th>
                <th>Customer</th>
                <th>Direquest </th>
                <th>Dikeep</th>
                <th>No SH</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              
        ";
        $no =0;
        while ($row = $result->fetch_assoc()) {
           $no++;
           $html .="<tr><td>".$no."</td>";
           $html .="<td>".$row['noso']."</td>";
           $html .="<td>".$row['waktu_req']."</td>";
           $html .="<td><b>K-".add_leading_zero($row['no_keepstock'])."</b></td>";
           $html .="<td>".$row['model']."</td>";
           $html .="<td>".$row['qty_po']."</td>";
           $html .="<td>".$row['qty_req']."</td>";
           $html .="<td>".$row['qty_keep']."</td>";
           $html .="<td>".$row['keterangan_qty']."</td>";
           $html .="<td>".$row['customer']."</td>";
           $html .="<td>".$row['user']."</td>";
           $html .="<td>".$row['user_keep']."</td>";
           $html .="<td>".$row['no_sh']."</td>";
           $html .="<td>".$row['duedate']."</td>";
           $html .="<td>".$row['priority']."</td>";
           $html .="<td>".status($row['status_keep'])."</td></tr>";
        }

$html.="
          
        </tbody>
      </table>
    ";

    echo $html;
?>