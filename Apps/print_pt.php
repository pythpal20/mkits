<?php
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
    include '../config/connection.php';
    require_once('../assets/dompdf/autoload.inc.php');
    
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $id = $_GET['id'];

    $query = "SELECT a.no_sh, a.tgl_order, a.customer_nama, a.alamat_krm, c.pic_nama, c.customer_telp, c.pic_kontak, a.ongkir,  b.atasnama, b.nama_pt, a.noso, a.No_Co, a.issuedby, a.ttd_by     
    FROM customerorder_hdr a
    JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.No_Co = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
    $row = $resl->fetch_assoc();

    $query2 = "SELECT tgl_po FROM salesorder_hdr WHERE noso = '". $row['noso'] ."'";
    $mwk = $db1->prepare($query2);
    $mwk -> execute();
    $hsl1 = $mwk->get_result();
    $wr = $hsl1->fetch_assoc();

    $html .= '
    <style>
        table {
            font-size:0.850em
        }
    </style>';
    $html .= '
    <table border = "0" width="100%">
        <tr>
            <td width="50%" style="text-align: left;vertical-align:top; ">
                <h3>' . $row["atasnama"] . '</h3>
            </td>
            <td width="50%" style="text-align: right;vertical-align:top; ">
                <p>
                    <b>Pick Ticket</b><br>
                    Ref. Shipment : ' . substr($row["no_sh"],4) . '<br>
                    Date : ' . date_format(date_create($row["tgl_order"]), "F d, Y") . '
                </p>
            </td>
        </tr>
        <tr style="font-size:0.820em">
            <td width="50%"></td>
            <td width="50%" style="text-align:right; vertical-align:top;">
                Ref. Order / Ref. SCO : ' . substr($row["No_Co"],4) . ' / ' . $row['noso'] . '<br>
                Order Date : ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . ' / ' .  date_format(date_create($wr["tgl_po"]), "d/m/Y") . '
            </td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td width="50%" style="">
                Recipient :
                <hr style="border:0.8px solid black">
            </td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align:left; vertical-align:top;">
                    <b>' . $row["customer_nama"] . '</b><br>' . $row["alamat_krm"] . '<br>
                    UP : ' . $row["pic_nama"] . '<br>' .  $row["customer_telp"].' / '.$row["pic_kontak"] . '
            </td>
        </tr>
    </table><br>';
$html .='
<div>
    <table style="min-height : 430px; border: 0.8px solid black; border-collapse:collapse" width="100%" border="1">
        <thead>
            <tr>
                <td>Description</td>
                <td>Comment</td>
                <td align="center">Qty to ship</td>
            </tr>
        </thead>
        <tbody style="border: 0.8px;">
            <tr>
                <td style="height : 430px; vertical-align : top; ">';
                $sql_dtl = "SELECT model FROM customerorder_dtl  WHERE No_Co = '$id' ORDER BY no_urut ASC";
                $mwk = $db1->prepare($sql_dtl);
                $mwk -> execute();
                $hsl_dtl = $mwk->get_result();
                while ($sk = $hsl_dtl->fetch_assoc()){
                $html .= $sk['model'] . '<br>' ;
                }
                $html .='</td>
                <td style="height : 430px; vertical-align : top;">';
                $sql_dtl = "SELECT locator FROM customerorder_dtl 
                WHERE No_Co = '$id' ORDER BY no_urut ASC";
                $mwk = $db1->prepare($sql_dtl);
                $mwk -> execute();
                $hsl_dtl = $mwk->get_result();
                while ($sk = $hsl_dtl->fetch_assoc()){
                $html .= $sk['locator'] . '<br>';
                }
                $html .='</td>
                <td style="height : 430px; vertical-align : top;" align="center">';
                $sql_dtl = "SELECT qty_kirim FROM customerorder_dtl 
                WHERE No_Co = '$id' ORDER BY no_urut ASC";
                $mwk = $db1->prepare($sql_dtl);
                $mwk -> execute();
                $hsl_dtl = $mwk->get_result();
                while ($sk = $hsl_dtl->fetch_assoc()){
                $html .= $sk['qty_kirim'] . '<br>';
                }
                $html .='</td>
            </tr>
    </table>
    <table width="100%" style="min-height: 180px;">
            <thead>
                <tr align="center">
                    <td style="height:120px;vertical-align:top;"><b>Issued By :</b></td>
                    <td style="height:120px;vertical-align:top;"><b>Approve By :</b></td>
                    <td style="height:120px;vertical-align:top;"><b>Received By :</b></td>
                    <td style="height:120px;vertical-align:top;"><b>Prepare By :</b></td>
                    <td style="height:120px;vertical-align:top;"><b>Check By :</b></td>
                    <td style="height:120px;vertical-align:top;"><b>Finance Check :</b></td>
                </tr>
            </thead>
            <tbody>
                <tr style="vertical-align:bottom;" align="center">
                    <td><b>' . $row["issuedby"] . '</b></td>
                    <td><b>' . $row["ttd_by"] . '</b></td>
                    <td> . . . . . . </td>
                    <td> . . . . . . </td>
                    <td> . . . . . . </td>
                    <td> . . . . . . </td>
                </tr>
            </tbody>
        </table>
    </table>
</div>';
$html .="

</html>";
// ECHO $html;
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream($row["no_sh"] .'.pdf');

// error_reporting(0);
//     date_default_timezone_set('Asia/Jakarta');
//     include '../config/connection.php';
//     require_once('../assets/dompdf/autoload.inc.php');
    
//     use Dompdf\Dompdf;
//     $dompdf = new Dompdf();

//     $id = $_GET['id'];

//     $query = "SELECT a.no_sh, a.tgl_order, a.customer_nama, a.alamat_krm, c.pic_nama, c.customer_telp, c.pic_kontak, a.ongkir,  b.atasnama, b.nama_pt, a.noso, a.No_Co, a.issuedby     
//     FROM customerorder_hdr a
//     JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
//     JOIN master_customer c ON a.customer_id = c.customer_id
//     WHERE a.No_Co = '$id'";
//     $mwk = $db1->prepare($query);
//     $mwk -> execute();
//     $resl = $mwk->get_result();
//     $row = $resl->fetch_assoc();

//     $query2 = "SELECT tgl_po FROM salesorder_hdr WHERE noso = '". $row['noso'] ."'";
//     $mwk = $db1->prepare($query2);
//     $mwk -> execute();
//     $hsl1 = $mwk->get_result();
//     $wr = $hsl1->fetch_assoc();
    
//     $kueri = "SELECT model, locator, qty_kirim FROM customerorder_dtl  WHERE No_Co = '$id' ORDER BY no_urut ASC";
//     $mwk = $db1->prepare($kueri);
//     $mwk -> execute();
//     $dh = $mwk->get_result();
    

//     $html .= '
//     <style>
//         table {
//             font-size:0.850em
//         }
//     </style>';
//     $html .= '
//     <table border = "0" width="100%">
//         <tr>
//             <td width="50%" style="text-align: left;vertical-align:top; ">
//                 <h3>' . $row["atasnama"] . '</h3>
//             </td>
//             <td width="50%" style="text-align: right;vertical-align:top; ">
//                 <p>
//                     <b>Pick Ticket</b><br>
//                     Ref. Shipment : ' . substr($row["no_sh"],4) . '<br>
//                     Date : ' . date_format(date_create($row["tgl_order"]), "F d, Y") . '
//                 </p>
//             </td>
//         </tr>
//         <tr style="font-size:0.820em">
//             <td width="50%"></td>
//             <td width="50%" style="text-align:right; vertical-align:top;">
//                 Ref. Order / Ref. SCO : ' . substr($row["No_Co"],4) . ' / ' . $row['noso'] . '<br>
//                 Order Date : ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . ' / ' .  date_format(date_create($wr["tgl_po"]), "d/m/Y") . '
//             </td>
//         </tr>
//         <tr>
//             <td width="50%"></td>
//             <td width="50%" style="">
//                 Recipient :
//                 <hr style="border:0.8px solid black">
//             </td>
//         </tr>
//         <tr>
//             <td width="50%"></td>
//             <td width="50%" style="text-align:left; vertical-align:top;">
//                     <b>' . $row["customer_nama"] . '</b><br>' . $row["alamat_krm"] . '<br>
//                     UP : ' . $row["pic_nama"] . '<br>' .  $row["customer_telp"].' / '.$row["pic_kontak"] . '
//             </td>
//         </tr>
//     </table><br>';
// $html .='
// <div>
//     <table style="min-height : 430px; border: 0.8px solid black; border-collapse:collapse" width="100%" border="1">
//         <thead>
//             <tr>
//                 <td>Description</td>
//                 <td>Comment</td>
//                 <td align="center">Qty to ship</td>
//             </tr>
//         </thead>
//         <tbody style="border: 0.8px;">';
//         while ($hd = $dh->fetch_assoc()) {
//             $html .= '<tr>
//                 <td>' . $hd["model"] . '</td>
//                 <td>' . $hd["locator"] . '</td>
//                 <td>' . $hd["qty_kirim"] . '</td>
//             </tr>';
//         }
//     $html .= '</table>
//     <table width="100%" style="min-height: 180px;">
//             <thead>
//                 <tr align="center">
//                     <td style="height:120px;vertical-align:top;"><b>Issued By :</b></td>
//                     <td style="height:120px;vertical-align:top;"><b>Approve By :</b></td>
//                     <td style="height:120px;vertical-align:top;"><b>Received By :</b></td>
//                     <td style="height:120px;vertical-align:top;"><b>Prepare By :</b></td>
//                     <td style="height:120px;vertical-align:top;"><b>Check By :</b></td>
//                     <td style="height:120px;vertical-align:top;"><b>Finance Check :</b></td>
//                 </tr>
//             </thead>
//             <tbody>
//                 <tr style="vertical-align:bottom;" align="center">
//                     <td><b>' . $row["issuedby"] . '</b></td>
//                     <td><b>Christine</b></td>
//                     <td> . . . . . . </td>
//                     <td> . . . . . . </td>
//                     <td> . . . . . . </td>
//                     <td> . . . . . . </td>
//                 </tr>
//             </tbody>
//         </table>
//     </table>
// </div>';
// $html .="

// </html>";
// // ECHO $html;
// $dompdf->load_html($html);
// // Setting ukuran dan orientasi kertas
// $dompdf->setPaper('A4', 'potrait');
// // Rendering dari HTML Ke PDF
// $dompdf->render();
// // Melakukan output file Pdf
// $dompdf->stream($row["no_sh"] .'.pdf');

?>