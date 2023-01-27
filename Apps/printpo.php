<?php
error_reporting(0);
include '../config/connection.php';
require_once('../assets/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$no=1;
$noso = $_GET['id'];

$queryHdr = "SELECT * FROM salesorder_hdr sh
JOIN master_customer mc ON mc.customer_id=sh.customer_id
JOIN list_perusahaan lp ON sh.id_perusahaan = lp.id_perusahaan 
WHERE sh.noso ='$noso'";
$mwk=$db1->prepare($queryHdr);
$mwk->execute();
$reslt=$mwk->get_result();
$hdr = $reslt->fetch_assoc();

$queryDtl = "SELECT * FROM salesorder_dtl sd 
JOIN master_produk mp ON sd.model=mp.model
WHERE noso ='$noso'";
$mwk=$db1->prepare($queryDtl);
$mwk->execute();
$reslt2=$mwk->get_result();

$querysum = "SELECT SUM(qty) as total_barang, SUM(price) as total_harga, SUM(amount) as total_amount, SUM(diskon) AS disc, SUM(ppn) AS pajak, SUM(harga_total) AS ttl FROM salesorder_dtl WHERE noso='$noso'";
$mwk=$db1->prepare($querysum);
$mwk->execute();
$res1=$mwk->get_result();
$summ = $res1->fetch_assoc();

$html .='<table border="0" width="100%" style="font-size:0.756em;">
<tr>
	<th align="left" width="145px"><img src="../img/system/mkc3.png" width="145px"></th>
	<th align="center" rowspan="2"><h3>PURCHASE ORDER</h3></th>
</tr>
<tr>
    <td scop="row" >Jl. Garuda No. 75-77 Bandung 40183 Indonesia<br>Phone : 022-6031070<br>Fax : 022-6038229</td>
</tr>
</table>
<hr>';
$html .='<table border="0" width="100%" style="font-size:0.756em;">
<tr>
    <th width = "15%">To</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr["customer_nama"].'</td>
    <th width = "15%">No PO</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr["noso"].' / '.$hdr['noso_ref'].'</td>
</tr>
<tr>
    <th width = "15%">No Tlp</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr["pic_kontak"].' / '.$hdr["customer_telp"].'</td>
    <th width = "15%">Delivery To</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr["alamat_krm"].'</td>
</tr>
<tr>
    <th width = "15%">Delivery Date</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr["tgl_krm"].'</td>
    <th width = "15%">Date</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr["tgl_po"].'</td>
</tr>
<tr>
    <th width = "15%">Dikirim Via</th>
    <td width = "2%">:</td>
    <td width = "33%"></td>
    <th width = "15%">Pembayaran</th>
    <td width = "2%">:</td>
    <td width = "33%">'.$hdr['term'].'</td>
</tr>
</table><br>';
$html .='<table border="0" width="100%" style="font-size:0.756em;">
<tr>
    <th align="center">Detail Order</th>
</tr>
</table>';
$html .='<table border="0.5px" width="100%" style="font-size:0.756em; border-collapse: collapse; overflow-x:auto; border-radius: 5px;">
<thead>
    <tr>
        <th align="center">No</th>
        <th align="center">Spesification</th>
        <th align="center">Qty</th>
        <th align="center">Price</th>
        <th align="center">Amount</th>
        <th align="center">Disc</th>
        <th align="center">PPN</th>
        <th align="center">Total</th>
        <th align="center">Keterangan</th>
    </tr>
</thead>
<tbody>';
while($dtl=$reslt2->fetch_assoc()) {
	$html .= "<tr>
    	<td>".$no++."</td>
    	<td>".$dtl['model']."-".$dtl['deskripsi']."</td>
    	<td>".$dtl['qty']."</td>
    	<td>Rp. ".number_format($dtl['price'],0,".",".")."</td>
    	<td>Rp. ".number_format($dtl['amount'],0,".",".")."</td>
        <td>Rp. ".number_format($dtl['diskon'],0,".",".")."</td>
        <td>Rp. ".number_format($dtl['ppn'],0,".",".")."</td>
        <td>Rp. ".number_format($dtl['harga_total'],0,".",".")."</td>
        <td>". $dtl['keterangan'] ."</td>
	</tr>";
}
$html .= "<tr>
    <th colspan='2' align='center'>Total</th>
    <th>".$summ['total_barang']."</th>
    <th>Rp. ".number_format($summ['total_harga'],0,".",".")."</th>
    <th>Rp. ". number_format($summ['total_amount'],0,".",".")."</th>
    <th>Rp. ". number_format($summ['disc'],0,".",".")."</th>
    <th>Rp. ". number_format($summ['pajak'],0,".",".")."</th>
    <th>Rp. ". number_format($summ['ttl'],0,".",".")."</th>
    <th></th>
</tr>
<tr>   
    <th colspan='7' style='text-align:right;'>Ongkos Kirim</th>
    <td colspan='2' style='text-align:right;'>Rp. ". number_format($hdr['ongkir'],0,".",".") ."</td>
</tr>
<tr>
    <th colspan='7' style='text-align:right;'> Total Payment </th>
    <th colspan='2' style='text-align:right;'>Rp. ". number_format($hdr['ongkir']+$summ['ttl'],0,".",".") ."</th>
</tr>";
$html  .="</table>";
$html .='<table border="0" width="100%" style="font-size:0.756em;">
<tr>
<td colspan="3"><b>Note.</b><br>Transfer dapat dilakukan melalui No. Rek '.$hdr["rekening"].' a/n <b>'.$hdr["atasnama"].'</b> '.$hdr["nama_bank"].'</td>
</tr><br>';
$html .='</table>';
$html .='<table border="1" width="100%" style="font-size:0.756em; border-collapse: collapse; overflow-x:auto; border-radius: 5px;">
<tr>
	<th align="center" width="33%">Approved By</th>
	<th align="center" width="33%">Received By</th>
	<th align="center" width="33%">Request By</th>
</tr>
<tr>';
if($hdr['sco_aprovalby'] != NULL) {
    $html .='<td align="center" style="height: 75px;"><img src="../img/'.$hdr['sco_aprovalby'].'.png" height="75px" width="75px"></td>';
} else {
	$html .='<td style="height: 75px;"></td>';
}
	$html .='<td style="height: 75px;"></td>
	<td align="center" style="height: 75px;"><img src="../img/'.$hdr['sales'].'.png" width="75px"></td>
</tr>
<tr>';
if($hdr['sco_aprovalby'] != NULL) {
	$html .='<td align="center">('. $hdr["sco_aprovalby"] .')</td>';
} else {
    $html .='<td align="center">Christine</td>';
}
	$html .='<td></td>
	<td align="center">('.$hdr["sales"].')</td>
</tr>';
$html .="</html>";
	// ECHO $html;
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potr');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf

$dompdf->stream('Purchase Order '.$noso.'.pdf');
// $dompdf->stream('f-penilaian.pdf', array("Attachment" => false));	 

?>