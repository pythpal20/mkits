<?php
$start = date("Y-m-d", strtotime($_POST['start']));
$end = date("Y-m-d", strtotime($_POST['end']));


include '../config/connection.php';
// declare
date_default_timezone_set('Asia/Jakarta');
$sql = "  
SELECT 
  d.tgl_inv,
  d.no_fa as nofa_awal,
  a.noso,
  a.No_Co,
  c.customer_nama,
  d.sales,      
  (select sum(e.harga_total) from customerorder_dtl e where e.No_co = a.No_Co)  AS nominal_awal,
  (select sum(b.harga_total) from customerorder_dtl_delivery b where b.No_co = a.No_Co)  AS nominal_akhir,
  a.tgl_delivery,    
  f.tgl_kontrabon,    
  g.tgl_input,    
  g.nominal,    
  g.metode_pembayaran,    
  g.tgl_pembayaran,    
  g.keterangan,    
  f.tgl_duedate, 
  IFNULL(((select sum(g.nominal) from detail_penagihan g where a.No_co = g.noco)-(select sum(b.harga_total) from customerorder_dtl_delivery b where b.No_co = a.No_Co)), 'belum bayar') as selisih,
  (select sum(g.nominal) from detail_penagihan g where a.No_co = g.noco) as total_bayar,  
  DATEDIFF( NOW(), f.tgl_duedate ) as overdue,  
  a.no_fa as nofa_akhir
  FROM customerorder_hdr_delivery a
  JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
  JOIN customerorder_dtl e ON a.No_Co = e.No_Co
  JOIN master_customer c ON a.customer_id = c.customer_id
  JOIN customerorder_hdr d ON a.No_Co = d.No_Co
  left JOIN kontrabon f ON a.No_Co = f.noco
  left JOIN detail_penagihan g ON a.No_Co =g.noco
  
WHERE DATE_FORMAT(g.tgl_input, '%Y-%m-%d') >= '$start' 
&& 
DATE_FORMAT(g.tgl_input, '%Y-%m-%d') <='$end'
GROUP BY g.int_id
 ";
$result = $db1->query($sql);
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_keepstock($start sampai $end).xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$html = "<table border='1'>
            <thead>
              <tr>
                <th>no</th>
                <th>tanggal input</th>
                <th>Tanggal FA</th>
                <th>no FA</th>
                <th>no SO</th>
                <th>Nama Customer</th>
                <th>Sales</th>
                <th>Nominal FA Awal</th>
                <th>Nominal Konfirmasi Konsumen</th>
                <th>Nominal Pembayaran</th>
                <th>selisih</th>
                <th>Metode Pembayaran</th>
                <th>Tgl Pembayaran</th>
                <th>Tgl Kontrabon</th>
                <th>Tgl Due Date</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              
        ";
        $no =0;
        while ($row = $result->fetch_assoc()) {
           $no++;
           $html .="<tr><td>".$no."</td>";
           $html .="<td>".$row['tgl_input']."</td>";
           $html .="<td>".$row['tgl_inv']."</td>";
           $html .="<td>".$row['nofa_awal']."</td>";
           $html .="<td>".$row['noso']."</td>";
           $html .="<td>".$row['customer_nama']."</td>";
           $html .="<td>".$row['sales']."</td>";
           $html .="<td>".$row['nominal_awal']."</td>";
           $html .="<td>".$row['nominal_akhir']."</td>";
           $html .="<td>".$row['nominal']."</td>";
           $html .="<td>".$row['selisih']."</td>";
           $html .="<td>".$row['metode_pembayaran']."</td>";
           $html .="<td>".$row['tgl_pembayaran']."</td>";
           $html .="<td>".$row['tgl_kontrabon']."</td>";
           $html .="<td>".$row['tgl_duedate']."</td>";
           $html .="<td>".$row['keterangan']."</td></tr>";
        }

$html.="
          
        </tbody>
      </table>
    ";

    echo $html;
?>