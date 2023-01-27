<?php
// error_reporting(0);
include '../config/connection.php';
require_once('../assets/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf(); 

$no=1;
$no_keepstock = $_GET['id'];

$query = "SELECT * FROM keepstock WHERE no_keepstock = '$no_keepstock'";
$mwk=$db1->prepare($query);
$mwk->execute();
$reslt=$mwk->get_result();
$mwk2=$db1->prepare($query);
$mwk2->execute();
$reslt2=$mwk2->get_result();
$mwk3=$db1->prepare($query);
$mwk3->execute();
$reslt3=$mwk3->get_result();
// $data = $reslt->fetch_assoc();

// function id
function add_leading_zero($value, $threshold = 4) {
	return sprintf('%0' . $threshold . 's', $value);
}

//declare
$customer="";
$noso="";
$duedate="";
$id_keep="";
$userkeep="";
$userreq="";
$waktu_selesai="";
$user_selesai="";
$sh="";
while ($data2 = $reslt2->fetch_assoc()) {
	$customer=$data2['customer'];
	$noso=$data2['noso'];
	$duedate=$data2['duedate'];
	$id_keep=$data2['no_keepstock'];
	$userkeep=$data2['user_keep'];
	$userreq=$data2['user'];
	$waktu_selesai=$data2['waktu_selesai'];
	$user_selesai=$data2['user_selesai'];
	$sh=$data2['no_sh'];
}

$html ='
<style>
table.label {
    border: 1px solid #1C6EA4;
    background-color: #EEEEEE;
    width: 100%;
    text-align: center;
    border-collapse: collapse;
  }
  table.label td, table.label th {
    border: 6px solid #AAAAAA;
    padding: 10px 5px;
  }
  table.label tbody td {
    font-size: 55px;
    font-weight: bold;
    color: #333333;
  }
  table.label tr:nth-child(even) {
    background: #D0E4F5;
  }
  table.label thead {
    background: #1C6EA4;
    background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
    background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
    background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
    border-bottom: 2px solid #444444;
  }
  table.label thead th {
    font-size: 30px;
    font-weight: bold;
    color: #FFFFFF;
    text-align: center;
    border-left: 2px solid #D0E4F5;
  }
  table.label thead th:first-child {
    border-left: none;
  }
  
  table.label tfoot {
    font-size: 14px;
    font-weight: bold;
    color: #FFFFFF;
    background: #D0E4F5;
    background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
    background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
    background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
    border-top: 2px solid #444444;
  }
  table.label tfoot td {
    font-size: 14px;
  }
  table.label tfoot .links {
    text-align: right;
  }
  table.label tfoot .links a{
    display: inline-block;
    background: #1C6EA4;
    color: #FFFFFF;
    padding: 2px 8px;
    border-radius: 5px;
  }
</style>
<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

}
.detail td{
    border: 1px solid;
    height:18px;min-width:40px;
}
.detail th{
    text-align:center;
    border: 1px solid;
    height:18px;min-width:40px;
}


.center {
  margin-left: auto;
  margin-right: auto;
  margin-top: 1px;
}
.table {
	margin-top: 1px;
    width:100%;
}
</style>';
$html .='
<table style="width:100%;height:50px;text-align:center;"><tr ><th  style="padding:5px;"><h3>KEEP STOCK</h3></th></tr></table>
<table class="table" width="100%" style="background-color:white;">
<tr>
    <td>
    <th>No Keep  </th>
    <td>:</td>
    <td>K-'.add_leading_zero($id_keep).'</td>
</td>
<td>
<th>Requested by </th>
<td>:</td>
<td>'.$userreq.'</td>
</td>


</tr>
<tr>
    <td>
    <th>No SO </th>
    <td>:</td>
    <td> '.$noso.'</td>
</td>
<td>
<th>Kept by </th>
<td>:</td>
<td>'.$userkeep.'</td>
</td>


</tr>
<tr>
    <td>
    <th>Customer </th>
    <td>:</td>
    <td>'.$customer.'</td>
</td>
<td>
<th>Completed By </th>
<td>:</td>
<td>'.$user_selesai.'</td>
</td>
</tr>
<tr>
    <td>
    <th>Duedate </th>
    <td>:</td>
    <td>'.$duedate.'</td>
</td>
<td>
<th>Completed </th>
<td>:</td>
<td>'.$waktu_selesai.'</td>
</td>
</tr>
<tr>
    <td>
    <th> </th>
    <td></td>
    <td></td>
</td>
<td>
<th>No SH </th>
<td>:</td>
<td>'.$sh.'</td>
</td>
</tr>

</table>
<hr />
<br />
<table class="detail" style="border:1px solid;border-collapse: collapse;page-break-after: always;">
    <thead>
        <tr>
            <th>No Keep </th>
            <th>Requested By</th>
            <th>Kept by</th>
            <th>Customer</th>
            <th>SKU</th>
            <th>Qty Req</th>
            <th>Qty Keep</th>
            <th>Waktu Req</th>
            <th>Waktu Keep</th>
            <th>Due Date</th>
        </tr>
    </thead>
    <tbody>

        ';

        $id_keep = "" ;
        while ($data = $reslt->fetch_assoc()) {
        $html .="<tr>";
            $html .="<td style='text-align:center;'> K-".add_leading_zero($data['no_keepstock'])."</td>
            ";
            $html .="<td style='text-align:center;'> ".$data['user']."</td>";
            $html .="<td style='text-align:center;'>".$data['user_keep']."</td>";
            $html .="<td style='text-align:center;'> ".$data['customer']."</td>";
            $html .="<td> ".$data['model']."</td>";
            $html .="<td style='text-align:center;'>".$data['qty_req']."</td>";
            $html .="<td style='text-align:center;'>".$data['qty_keep']."</td>";
            $html .="<td style='text-align:center;'>".$data['waktu_req']."</td>";
            $html .="<td style='text-align:center;'>".$data['waktu_keep']."</td>";
            $html .="<td>".$data['duedate']."</td>";
            $html .="</tr>";
        $id_keep="K-".add_leading_zero($data['no_keepstock']);
        }




        $html .="</tbody>
</table>";

$html .="
<table class='label'>
    ";
    while ($data3 = $reslt3->fetch_assoc() ) {
    $html .="<tr>";
        $html .="<td style='text-align:left;'>".$data3['model']."</td>";
        $html .="<td>".$data3['qty_req']."</td>";
        $html .="<td>"."K-".add_leading_zero($data3['no_keepstock'])."</td>";
        $html .="</tr>";
    }
    $html .="
</table>
";
// echo $html; die();
// ECHO $html;
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'landscape');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream($id_keep.".pdf");
?>