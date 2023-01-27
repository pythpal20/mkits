<?php
    
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
    include '../config/connection.php';
    require_once('../assets/dompdf/autoload.inc.php');

    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    // $html = '';
    $id = $_GET['id'];
    $query = "SELECT  a.no_sh, a.tgl_order, a.customer_nama, a.alamat_krm, c.pic_nama, c.customer_telp, c.pic_kontak, a.ongkir, b.atasnama, b.nama_pt, a.noso, a.No_Co, a.no_fa, a.tgl_inv, b.nama_bank, b.rekening
    FROM customerorder_hdr a
    JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.No_Co = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
    $row = $resl->fetch_assoc();

        $qry = "SELECT SUM(amount) AS tAmt, SUM(ppn) AS tPjk, SUM(diskon) AS tDsc, SUM(harga_total) AS total FROM customerorder_dtl WHERE No_Co = '$id'";
        $mwk = $db1->prepare($qry);
        $mwk -> execute();
        $hsl = $mwk->get_result();
        $dtl = $hsl->fetch_assoc();
        
        $qryst = "SELECT a.noso_ref FROM salesorder_hdr a
        JOIN customerorder_hdr b ON a.noso = b.noso
        WHERE b.No_Co = '$id'";
        $mwk = $db1->prepare($qryst);
        $mwk -> execute();
        $hsls = $mwk->get_result();
        $dtq = $hsls->fetch_assoc();

    $html .= '
    <style>
        table {
            font-size:0.850em
        }
        .t-table th {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
        }
    
        div {
            margin-bottom: 3px;
            margin-top: 2px;
        }
        @page { margin: 25px; }
    </style>';

    $html .='<table border = "0" width="100%">
            <tr>
                <td width="50%" style="text-align: left;vertical-align:top; ">
                    <h3>' . $row["atasnama"] . '</h3>
                </td>
                <td width="50%" style="text-align: right;vertical-align:top; ">
                    <p>
                        <b>Invoice</b><br>
                        <b>Ref. : ' . substr($row["no_fa"],4) . '</b><br>
                        Invoice date : ' . date_format(date_create($row["tgl_inv"]), "d/m/Y") . '<br><br>
                        Ref. order / Ref. Shipment : ' . substr($row["No_Co"],4) . ' / ' .  substr($row["no_sh"],4) . '<br>
                        Order Date / Date sending Order : ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . ' / ' . date_format(date_create($row["tgl_inv"]), "d/m/Y") . '</p>
                </td>
            </tr>
            <tr>
                <td width="50%">From :</td>
                <td width="50%">To :</td>
            </tr>
            <tr>
                <td width="50%" style="text-align:left; vertical-align:top;">
                    <b>' . $row["atasnama"] .'</b><br>
                    Jl. Garuda 75-77<br>
                    40183 Bandung<br><br>
                    Phone : 0226031070<br>
                    Fax : 0226038229
                </td>
                <td width="50%" style="text-align:left; vertical-align:top; border:1px solid black; border-collapse: collapes; padding: 5px">
                    <b>' . $row["customer_nama"] . '</b><br>
                    ' . $row["alamat_krm"]. '<br><br>
                    UP : ' . $row["pic_nama"] . '<br>
                    ' . $row["customer_telp"].' / '.$row["pic_kontak"] .  '<br>
                    PO : ' . $dtq["noso_ref"] . '
                </td>
            </tr>  
        </table><br>';
$html .= '<table style="border: 0.8px solid black; border-collapse:collapse;" width="100%" class="t-table" border="0.5">
    <thead>
        <tr>
            <th>Description</th>
            <th align="center">Sales Tax</th>
            <th align="center">U.P (net)</th>
            <th align="center"> Qty </td>
            <th align="center">Subtotal</th>
        </tr>
    </thead>
    <tbody style="border: 0.8px; font-size:0.850em;">
            <tr>
                <td style="height : 430px; vertical-align : top; ">';
                    $sql1 = "SELECT a.model, b.deskripsi FROM customerorder_dtl a 
                    JOIN master_produk b ON a.model = b.model
                    WHERE a.No_Co = '" . $_GET['id'] ."' AND a.qty_kirim != 0 ORDER BY a.no_urut ASC";
                    $mwk = $db1->prepare($sql1);
                    $mwk ->execute();
                    $resq = $mwk->get_result();
                    while ($rw = $resq->fetch_assoc()) {
                        $html .='<div>' . $rw["model"] . '/ ' . strtoupper($rw["deskripsi"]) . '</div>';
                    } 
                $html .='</td>    
                <td style="height : 430px; vertical-align : top; " align="center">';
                    $sql2 = "SELECT ppn FROM customerorder_dtl WHERE No_Co = '$id' AND qty_kirim != 0 ORDER BY no_urut ASC";
                    $mwk = $db1->prepare($sql2);
                    $mwk->execute();
                    $res = $mwk->get_result();
                    while ($tx = $res->fetch_assoc()) {
                    $html.= '<div>' . $tx["ppn"] . '</div>';
                    } 
                $html .= '</td>
                <td style="height : 430px; vertical-align : top; " align="right">';
                    $sql2 ="SELECT price FROM customerorder_dtl WHERE No_Co = '$id' AND qty_kirim != 0 ORDER BY no_urut ASC";
                    $mwk = $db1->prepare($sql2);
                    $mwk ->execute();
                    $res30 = $mwk->get_result();
                    while($tx = $res30->fetch_assoc()){
                    $html .='<div>' .
                        number_format($tx["price"],2,".",",") . '
                    </div>';
                } 
                $html .= '</td>
                <td style="height : 430px; vertical-align : top; " align="center">';
                    $sql2 ="SELECT qty_kirim FROM customerorder_dtl WHERE No_Co = '$id' AND qty_kirim != 0 ORDER BY no_urut ASC";
                    $mwk = $db1->prepare($sql2);
                    $mwk ->execute();
                    $res = $mwk->get_result();
                    while($tx = $res->fetch_assoc()){
                    $html .='<div>'.
                    $tx["qty_kirim"] . '</div>';
                    }
                $html .='</td>
                <td style="height : 430px; vertical-align : top; " align="right">';
                    $sql2 ="SELECT amount FROM customerorder_dtl WHERE No_Co = '$id' AND qty_kirim != 0 ORDER BY no_urut ASC";
                    $mwk = $db1->prepare($sql2);
                    $mwk ->execute();
                    $res = $mwk->get_result();
                    while($tx = $res->fetch_assoc()){
                    $html .= '<div> ' . number_format($tx["amount"],2,".",",") . '</div>';
                    } 
                $html .='</td>
            </tr>
        </tbody>
    </table>';        
$html .= '<table width="100%">
    <tbody>
        <tr>
            <td align="left" rowspan="5" width="40%" colspan="2">' . $row["atasnama"] . '<br> No. Rek ' . $row["nama_bank"] . ': ' .  $row["rekening"] . '
            </td>
        </tr>';
        $html       .= '<tr>
        <td align="right" width="73%">Subtotal</td>
        <td align="right">' . number_format($dtl["tAmt"],2,".",",") . '</td>
        </tr>';

        if ($dtl['tDsc'] !=0) { 
            $html .= '<tr>
            <td align="right" width="75%">Discount</td>
            <td align="right">' . number_format($dtl["tDsc"],2,".",",") . '</td>
        </tr>';
        } 
        if($dtl['tPjk'] !=0) {
        $html .= '<tr>
            <td align="right" width="75%">Tax</td>
            <td align="right">' . number_format($dtl["tPjk"],2,".",",") . '</td>
        </tr>';
        }
        if($row['ongkir'] != 0) { 
        $html .='<tr>
            <td align="right" width="75%">shipping cost</td>
            <td align="right">' . number_format($row["ongkir"],2,".",",") . '</td>
            </tr>';
        } 
        $html.=
        '<tr>
            <td align="right" width="75%">Total</td>
            <td align="right">' . number_format($dtl["total"]+$row["ongkir"],2,".",",") . '</td>
        </tr>
    </tbody>
</table>';
$html .='<table width="100%">
    <thead>
        <tr>
            <td style="height : 70px; vertical-align : top; " align="left"><b>Approve By :</b></td>
            <td width="30%"></td>
            <td style="height : 70px; vertical-align : top; margin-right:15px" align="center"><b>Customer :</b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td align="left"><b>Stephanie A</b></td>
            <td width="30%"></td>
            <td align="center">( . . . . . . . . . . )</td>
        </tr>
        <tr style="font-size:0.820em">
            <td colspan="3" align="right"><b>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.<br>
                    Komplain kualitas dan kuantitas maksimal 1x24 jam setalah barang diterima</b>
            </td>
        </tr>
    </tbody>
</table>';
$html .="</html>";
// ECHO $html;die();
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream($row["no_fa"].'.pdf');

// error_reporting(0);
//     date_default_timezone_set('Asia/Jakarta');
//     include '../config/connection.php';
//     require_once('../assets/dompdf/autoload.inc.php');

//     use Dompdf\Dompdf;
//     $dompdf = new Dompdf();

//     // $html = '';
//     $id = $_GET['id'];
//     $query = "SELECT  a.no_sh, a.tgl_order, a.customer_nama, a.alamat_krm, c.pic_nama, c.customer_telp, c.pic_kontak, a.ongkir, b.atasnama, b.nama_pt, a.noso, a.No_Co, a.no_fa, a.tgl_inv, b.nama_bank, b.rekening
//     FROM customerorder_hdr a
//     JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
//     JOIN master_customer c ON a.customer_id = c.customer_id
//     WHERE a.No_Co = '$id'";
//     $mwk = $db1->prepare($query);
//     $mwk -> execute();
//     $resl = $mwk->get_result();
//     $row = $resl->fetch_assoc();

//         $qry = "SELECT SUM(amount) AS tAmt, SUM(ppn) AS tPjk, SUM(diskon) AS tDsc, SUM(harga_total) AS total FROM customerorder_dtl WHERE No_Co = '$id'";
//         $mwk = $db1->prepare($qry);
//         $mwk -> execute();
//         $hsl = $mwk->get_result();
//         $dtl = $hsl->fetch_assoc();
        
//         $qryst = "SELECT a.noso_ref FROM salesorder_hdr a
//         JOIN customerorder_hdr b ON a.noso = b.noso
//         WHERE b.No_Co = '$id'";
//         $mwk = $db1->prepare($qry);
//         $mwk -> execute();
//         $hsls = $mwk->get_result();
//         $dtq = $hsls->fetch_assoc();
        
//     $kueri = "SELECT a.model, b.deskripsi, a.ppn, a.price, a.qty_kirim, a.amount FROM customerorder_dtl a 
//     JOIN master_produk b ON a.model = b.model
//     WHERE a.No_Co = '$id' ORDER BY a.no_urut ASC";
//     $mwk = $db1->prepare($kueri);
//     $mwk -> execute();
//     $dh = $mwk->get_result();

//     $html .= '
//     <style>
//         table {
//             font-size:0.850em
//         }
//     </style>';

//     $html .='<table border = "0" width="100%">
//             <tr>
//                 <td width="50%" style="text-align: left;vertical-align:top; ">
//                     <h3>' . $row["atasnama"] . '</h3>
//                 </td>
//                 <td width="50%" style="text-align: right;vertical-align:top; ">
//                     <p>
//                         <b>Invoice</b><br>
//                         <b>Ref. : ' . substr($row["no_fa"],4) . '</b><br>
//                         Invoice date : ' . date_format(date_create($row["tgl_inv"]), "d/m/Y") . '<br><br>
//                         Ref. order / Ref. Shipment : ' . substr($row["No_Co"],4) . ' / ' .  substr($row["no_sh"],4) . '<br>
//                         Order Date / Date sending Order : ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . ' / ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . '</p>
//                 </td>
//             </tr>
//             <tr>
//                 <td width="50%">From :</td>
//                 <td width="50%">To :</td>
//             </tr>
//             <tr>
//                 <td width="50%" style="text-align:left; vertical-align:top;">
//                     <b>' . $row["atasnama"] .'</b><br>
//                     Jl. Garuda 75-77<br>
//                     40183 Bandung<br><br>
//                     Phone : 0226031070<br>
//                     Fax : 0226038229
//                 </td>
//                 <td width="50%" style="text-align:left; vertical-align:top; border:1px solid black; border-collapse: collapes; padding: 5px">
//                     <b>' . $row["customer_nama"] . '</b><br>
//                     ' . $row["alamat_krm"]. '<br><br>
//                     UP : ' . $row["pic_nama"] . '<br>
//                     ' . $row["customer_telp"].' / '.$row["pic_kontak"] .  '<br>
//                     PO : ' . $dtq["noso_ref"] . '
//                 </td>
//             </tr>  
//         </table><br>';
// $html .= '<div>
// <table style="border: 0.8px solid black; border-collapse:collapse" width="100%" border="1">
//     <thead>
//         <tr>
//             <th>Description</th>
//             <th align="center">Sales Tax</th>
//             <th align="center">U.P (net)</th>
//             <th align="center"> Qty </td>
//             <th align="center">Subtotal</th>
//         </tr>
//     </thead>
//     <tbody style="border: 0.8px; font-size;0.820em;">';
//     while ($hd = $dh->fetch_assoc()) {
//             $html .='<tr>
//             <td>' . $hd["model"] . '/ ' . $hd["deskripsi"] . '</td>
//             <td>' . $hd["ppn"] . '</td>
//             <td>' . number_format($hd['price'],2,".",",") . '</td>
//             <td>' . $hd['qty_kirim'] . '</td>
//             <td>' . number_format($hd['amount'],2,".",",") . '</td>';
//     }
//             $html .='</tr>
//         </tbody>
//     </table></div>';        
// $html .= '<table width="100%">
//     <tbody>
//         <tr>
//             <td align="left" rowspan="5" width="40%" colspan="2">' . $row["atasnama"] . '<br> No. Rek ' . $row["nama_bank"] . ': ' .  $row["rekening"] . '
//             </td>
//         </tr>';
//         $html       .= '<tr>
//         <td align="right" width="75%">Subtotal</td>
//         <td align="right">' . number_format($dtl["tAmt"],2,".",",") . '</td>
//         </tr>';

//         if ($dtl['tDsc'] !=0) { 
//             $html .= '<tr>
//             <td align="right" width="75%">Discount</td>
//             <td align="right">' . number_format($dtl["tDsc"],2,".",",") . '</td>
//         </tr>';
//         } 
//         if($dtl['tPjk'] !=0) {
//         $html .= '<tr>
//             <td align="right" width="75%">Tax</td>
//             <td align="right">' . number_format($dtl["tPjk"],2,".",",") . '</td>
//         </tr>';
//         }
//         if($row['ongkir'] != 0) { 
//         $html .='<tr>
//             <td align="right" width="75%">shipping cost</td>
//             <td align="right">' . number_format($row["ongkir"],2,".",",") . '</td>
//             </tr>';
//         } 
//         $html.=
//         '<tr>
//             <td align="right" width="75%">Total</td>
//             <td align="right">' . number_format($dtl["total"]+$row["ongkir"],2,".",",") . '</td>
//         </tr>
//     </tbody>
// </table>';
// $html .='<table width="100%">
//     <thead>
//         <tr>
//             <td style="height : 70px; vertical-align : top; " align="left"><b>Approve By :</b></td>
//             <td width="30%"></td>
//             <td style="height : 70px; vertical-align : top; margin-right:15px" align="center"><b>Customer :</b></td>
//         </tr>
//     </thead>
//     <tbody>
//         <tr>
//             <td align="left"><b>Stephanie A</b></td>
//             <td width="30%"></td>
//             <td align="center">( . . . . . . . . . . )</td>
//         </tr>
//         <tr style="font-size:0.820em">
//             <td colspan="3" align="right"><b>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.<br>
//                     Komplain kualitas dan kuantitas maksimal 1x24 jam setalah barang diterima</b>
//             </td>
//         </tr>
//     </tbody>
// </table>';
// $html .="</html>";
// // ECHO $html;die();
// $dompdf->load_html($html);
// // Setting ukuran dan orientasi kertas
// $dompdf->setPaper('A4', 'potrait');
// // Rendering dari HTML Ke PDF
// $dompdf->render();
// // Melakukan output file Pdf
// $dompdf->stream($row["no_fa"].'.pdf');
?>