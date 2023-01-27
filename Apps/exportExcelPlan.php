<?php
$start = date("Y-m-d", strtotime($_POST['start']));
$end = date("Y-m-d", strtotime($_POST['end']));


include '../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');


include '../config/connection.php';
// $sql = "
// SELECT 
//   a.tgl_krm, 
//   a.No_Co, 
//   a.customer_nama, 
//   b.model, 
//   a.alamat_krm, 
//   b.qty_kirim
//   FROM customerorder_hdr a 
//   JOIN customerorder_dtl b ON a.No_Co = b.No_Co
//   WHERE a.tgl_krm BETWEEN '$start' AND '$end' AND a.status_delivery !=1 AND a.status_delivery !=2 
//   GROUP BY a.tgl_krm ASC
//   ";

$sql = "
  SELECT  *
  FROM customerorder_hdr a
  LEFT JOIN customerorder_dtl b ON a.No_Co = b.No_Co
  WHERE a.tgl_krm BETWEEN '$start' AND '$end' AND a.status_delivery !=1 AND a.status_delivery !=2
";
$result = $db1->query($sql);

function ambil_data_header($No_Co)
{
  include '../config/connection.php';
  $sql = "
 SELECT 
  a.No_Co,
  a.model,
  a.qty_kirim,
  b.customer_nama,
  b.alamat_krm
    FROM customerorder_dtl a
    LEFT JOIN customerorder_hdr b ON a.No_Co = b.No_Co
    WHERE a.No_Co ='$No_Co'
 ";
  $result = $db1->query($sql);
  $model = "";
  $qty_kirim = "";
  $customer_nama = "";
  $alamat_krm = "";
  $No_Co = "";

  while ($row = $result->fetch_assoc()) {

    $model = $row['model'];
    $qty_kirim = $row['qty_kirim'];
    $customer_nama = $row['customer_nama'];
    $alamat_krm = $row['alamat_krm'];
    $No_Co = $row['No_Co'];
  }
  return ["model" => $model, "qty_kirim" => $qty_kirim, "customer_nama" => $customer_nama, "alamat_krm" => $alamat_krm, "No_Co" => $No_Co];
}

//     $model = "";
//     $qty_kirim = "";

//     while ($row = $result->fetch_assoc()) {
//         $model = $row['model'];
//         $qty_kirim = $row['qty_kirim'];
//     }
//     return ["model" => $model, "qty_kirim" => $qty_kirim];
// }

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Laporan_Planning_Delivery($start sampai $end).xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);


$html = "<table border='1'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>CO</th>
                <th>Customer</th>
                <th>SKU</th>
                <th>Alamat</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Kenek</th>
                <th>Supir</th>
                <th>Nopol</th>
                <th>Jenis</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
        ";
$no = 0;
while ($row = $result->fetch_assoc()) {
  $no++;
  $html .= "<tr><td>" . $no . "</td>";
  $html .= "<td>" . $row['tgl_krm'] . "</td>";
  $html .= "<td>" . $row['No_Co'] . "</td>";
  $html .= "<td>" . ambil_data_header($row['No_Co'])['customer_nama'] . "</td>";
  $html .= "<td>" . $row['model'] . "</td>";
  // $html .= "<td>" . ambil_data_header($row['No_Co'])['model'] . "</td>";
  $html .= "<td>" . ambil_data_header($row['No_Co'])['alamat_krm'] . "</td>";
  // $html .= "<td>" . $row['qty_kirim'] . "</td>";
  $html .= "<td>" . ambil_data_header($row['No_Co'])['qty_kirim'] . "</td>";
  $html .= "<td></td>";
  $html .= "<td></td>";
  $html .= "<td></td>";
  $html .= "<td></td>";
  $html .= "<td></td>";
  $html .= "<td></td>";
}

$html .= "
        </tbody>
      </table>
    ";

echo $html;