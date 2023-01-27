<?php
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
    include '../config/connection.php';
    require_once('../assets/dompdf/autoload.inc.php');
    
    use Dompdf\Dompdf;
    $dompdf = new Dompdf(); 

    $id = $_GET['id'];
    $query = "SELECT a.no_sh, a.tgl_order, a.customer_nama, a.no_bl, a.alamat_krm, c.pic_nama, c.customer_telp, c.pic_kontak, a.ongkir, b.atasnama, b.nama_pt, a.noso, a.No_Co, a.tgl_inv
    FROM customerorder_hdr a
    JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.No_Co = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
    $row = $resl->fetch_assoc();

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
                    <b>Delivery Order ' . substr($row["no_bl"],4) . '</b><br>
                    Date : ' . date_format(date_create($row["tgl_inv"]),"d M Y") . '</p>
            </td>
        </tr>
        <tr style="font-size:0.810em">
            <td width="50%"></td>
            <td width="50%" style="text-align:right; vertical-align:top; ">
            Ref. Order : ' . substr($row["No_Co"],4) . '<br>
            Order Date : ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . '<br>
            Ref. Order / Ref. Shipment : ' . substr($row["No_Co"],4) . ' / ' .  substr($row["no_sh"],4) . '<br>
            Order date / Date Sending order : ' . date_format(date_create($row["tgl_order"]), "d/m/Y") . ' / ' . date_format(date_create($row["tgl_order"]), 'd/m/Y') . '
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
                ' . $row["alamat_krm"] . '<br><br>
                UP : ' . $row["pic_nama"] . '<br>
                ' . $row["customer_telp"]. ' / '. $row["pic_kontak"] . '
            </td>
        </tr>
    </table><br>';
                $no=1;
                $sql_dtl = "SELECT a.model, b.deskripsi , a.keterangan, a.qty_kirim
                FROM customerorder_dtl a
                JOIN master_produk b ON a.model = b.model
                WHERE a.No_Co = '$id' ORDER BY a.no_urut ASC";
                $mwk = $db1->prepare($sql_dtl);
                $mwk -> execute();
                $hsl_dtl = $mwk->get_result();
$html .= '
<div>
    <table style="min-height : 430px; border: 0.8px solid black; border-collapse:collapse" width="100%" border="1">
        <thead>
            <tr>
                <th>Description</th>
                <th>Comment</th>
                <th align="center">Qty to ship</th>
            </tr>
        </thead>
        <tbody style="border: 0.8px;">';
        while($hd= $hsl_dtl->fetch_assoc()){
            $html .='<tr>
                <td>' . $hd["model"].' / ' . $hd["deskripsi"] . '</td>
                <td>' . $hd["keterangan"] . '</td>
                <td>' . $hd["qty_kirim"] . '</td>
            </tr>';
        }
        $html .='</tbody>
    </table>
</div>';
$html .='<table width="100%">
    <tbody>
        <tr>
            <td colspan="2" style="vertical-align:top;">FOR ' . $row["atasnama"] . ':</td>
            <td width="35%" style="text-align:left; vertical-align:top; border:1px solid black; border-collapse: collapes; padding: 5px; height:120px">
                For Customer :
            </td>
        </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
        <tr>
            <td>Stephanie A</td>
            <td align="center">Roland</td>
            <td width="65%" align="right" style="font-size: 0.810em;"><b>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan. Komplain
            kualitas dan kuantitas maksimal 1 x 24 jam setelah barang diterima</b></td>
        </tr>
        <tr>
            <td>Akunting</td>
            <td align="center">Kep. Gudang</td>
        </tr>
    </tbody>
</table>';
$html .="

</html>";
// ECHO $html;die();
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream($row["no_bl"].'.pdf');
?>