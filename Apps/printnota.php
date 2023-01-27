<?php
error_reporting(0);
include '../config/connection.php';
require_once('../assets/dompdf/autoload.inc.php');

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$noso = $_GET['id'];

$sql = "SELECT sh.tgl_po, sh.noso, mc.pic_nama, mc.customer_nama, sh.ongkir, sh.sales
FROM salesorder_hdr sh
JOIN master_customer mc ON sh.customer_id = mc.customer_id
WHERE sh.noso = '$noso'";
$mwk=$db1->prepare($sql);
$mwk->execute();
$resl=$mwk->get_result();
$vw = $resl->fetch_assoc();

$queryDtl = "SELECT a.*, b.promo_name 
FROM salesorder_dtl a 
JOIN bundle_promo b ON a.promo_id = b.promo_id
WHERE a.noso ='$noso'";
$mwk=$db1->prepare($queryDtl);
$mwk->execute();
$reslt2=$mwk->get_result();

$querysum = "SELECT SUM(qty) as total_barang, SUM(price) as total_harga, SUM(amount) as total_amount, SUM(diskon) as disc, SUM(ppn) as pajak, SUM(harga_total) as total FROM salesorder_dtl WHERE noso='$noso'";
$mwk=$db1->prepare($querysum);
$mwk->execute();
$res1=$mwk->get_result();
$summ = $res1->fetch_assoc();

$head = "SELECT * FROM master_user WHERE user_nama='". $vw['sales'] ."'";
$mwk = $db1->prepare($head);
$mwk->execute();
$headr = $mwk->get_result();
$hd = $headr->fetch_assoc();

// halaman header
$html .= '<style type="text/css">
    @page { margin: 1px; }
    .p1 {font-family: "Lucida Console", "Courier New", monospace;}
</style>';
$html .='<table border="0" width="40%" style="overflow-x:auto; font-size: 0.745em;">
<tr>
    <th scop="row" colspan="3">'.$hd["company"].'</th>
</tr>
<tr>
    <td>Sales</td>
    <td>:</td>
    <td scop="row" >'.$hd["user_nama"].'</td>
</tr>
<tr>
    <td>Kontak</td>
    <td>:</td>
    <td scop="row" >'.$hd["notelp"].'</td>
</tr>
<tr>
    <td>E-Mail</td>
    <td>:</td>
    <td scop="row" >'.$hd["email"].'</td>
</tr>
<tr>
    <td>CS</td>
    <td>:</td>
    <td scop="row" >+62 878-2785-1394</td>
</tr>
</table>
<hr style="border-width: 0.015em; border-style: dotted;">';
$html .= '<table class="p1" style="font-size: 0.756em; overflow-x:auto;  width: 100%; border-collapse: collapse; border: 0.025em solid black;">
<tr>
    <td>No.PO</td>
    <td>:</td>
    <td>'.$vw["noso"].'</td>
</tr>
<tr>
    <td>Tanggal</td>
    <td>:</td>
    <td>'.$vw["tgl_po"].'</td>
</tr>
<tr>
    <td>Toko</td>
    <td>:</td>
    <td>'.$vw["customer_nama"].'</td>
</tr>
<tr>
    <td>PIC</td>
    <td>:</td>
    <td>'.$vw["pic_nama"].'</td>
</tr>
</table>';
$html .= '<table class="p1" style="font-size: 0.765em; overflow-x:auto; width: 100%; border-collapse: collapse; border: 0.025em solid black;">
<thead>
    <tr>
        <th>SKU</th>
        <th>Qty.</th>
        <th>Price</th>
    </tr>
</thead>
<tbody>';
    while($dtl=$reslt2->fetch_assoc()) {
        $html .= "<tr>
        <td>".$dtl['model']." <p style='font-size: 0.756em;'>".$dtl['promo_name']."</p></td>
        <td>".$dtl['qty']."x".number_format($dtl['price'],0,".",".")."</td>
        <td style='text-align: right;'>".number_format($dtl['amount'],0,".",".")."</td>
        </tr>";
    }
$html .= "<tr>
<th>Total</th>
<th colspan='2' style='text-align: right;'>Rp. ". number_format($summ['total_amount'],0,".",".")."</th>
</tr>
</table>";
$html .= "<table class='p1' style='font-size: 0.756em; overflow-x:auto; width: 100%; border-collapse: collapse; border: 0.025em solid black;'>
<tr>
    <th colspan ='2'>Total DISC</th>
    <td style='text-align: right;'>Rp. ".number_format($summ['disc'],0,".",".")."</td>
</tr>
<tr>
    <th colspan='2'>Total PPN (11%)</th>
    <td style='text-align: right;'>Rp. ".number_format($summ['pajak'],0,".",".")."</td>
</tr>
<tr>
    <th colspan='2'>Ongkir</th>
    <td style='text-align: right;'>Rp. ".number_format($vw['ongkir'],0,".",".")."</td>
</tr>
<tr>
    <th colspan='2'>Total Bayar</th>
    <td style='text-align: right;'>Rp. ".number_format($summ['total']+$vw['ongkir'],0,".",".")."</td>
</tr>
</table><br>";
$html .= '<table style="font-size: 0.756em; overflow-x:auto;  width: 100%; border-collapse: collapse;">
<tr>
    <td width="55%"></td>
    <td style="text-align: center;">Customer</td>
</tr>
<tr>
    <td width="55%"></td>
    <td style="text-align: center;"></td>
</tr>
<tr>
    <td width="55%"></td>
    <td style="text-align: center;"></td>
</tr>
<tr>
    <td width="55%"><br></td>
    <td style="text-align: center;"><br></td>
</tr>
<tr>
    <td width="55%"><br></td>
    <td style="text-align: center;"><br></td>
</tr>
<tr>
    <td><br></td>
</tr>
<tr>
    <td width="55%"></td>
    <td style="text-align: center;">______________</td>
</tr>
<tr>
    <td width="55%"></td>
    <td style="text-align: center;">ttd, nama, dan cap</td>
</tr>';
$html .="</table>";
$html .= '<br><table border="0" class="p1" style="font-size: 0.756em;">
<tr>
    <th>Nota berikut bukan merupakan Bukti Pembayaran</th>
</tr>
<tr>
    <td style="font-size: 0.656em;">Barang yang sudah dibeli tidak dapat dituker atau dikembalikan.Komplain kualitas dan kuantitas maksimal 1 x 24 jam setelah barang diterima</td>
</tr>
</table>';
$html .="</html>";
	// ECHO $html;
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->set_option('dpi', 72);
$customPaper = array(0,0,204,650);
$dompdf->set_paper($customPaper);
// $dompdf->setPaper('A4', 'portrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('Nota'.$noso.'.pdf'); 
?>