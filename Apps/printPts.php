<?php
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
    include '../config/connection.php';
    require_once('../assets/dompdf/autoload.inc.php');
    
    use Dompdf\Dompdf;
    $dompdf = new Dompdf(); 

    $id = $_GET['id'];

    $sql_hdr = "SELECT * FROM pts_header WHERE idPts = '$id'";
    $mwk = $db1->prepare($sql_hdr);
    $mwk -> execute();
    $hsl = $mwk->get_result();
    $hdr = $hsl->fetch_assoc();

    $sql_dtl = "SELECT a.model, b.deskripsi, a.harga, a.qty, a.amount, a.ket
    FROM pts_detail a JOIN master_produk b ON a.model = b.model
    WHERE a.idPts = '$id' ORDER BY nourut ASC";
    $mwk = $db1->prepare($sql_dtl);
    $mwk -> execute();
    $hsl_dtl = $mwk->get_result();

    $sql_sum = "SELECT SUM(qty) AS total_barang, SUM(harga) AS total_harga, SUM(amount) AS total_amount
    FROM pts_detail
    WHERE idPts = '$id'";
    $mwk = $db1->prepare($sql_sum);
    $mwk -> execute();
    $hsl_sum = $mwk->get_result();
    $sum = $hsl_sum->fetch_assoc();

    $sql_dtl = "SELECT a.model, b.deskripsi, a.qty, a.ket FROM pts_detail a
    JOIN master_produk b ON a.model = b.model
    WHERE a.idPts = '$id' ORDER BY a.nourut ASC";
    $mwk = $db1->prepare($sql_dtl);
    $mwk -> execute();
    $hsl_dtl = $mwk->get_result();
    
    if($hdr["status"] == "1") {
        $desk = date_format(date_create($hdr["tgl_kembali"]), "d M Y");
    } elseif ($hdr["status"] == "2") {
        $desk = "Tidak Kembali";
    } elseif ($hdr["status"] == "3") {
        $desk = "DIBELI / " . $hdr["keterangan_beli"];
    }
    $html .= '
    <style>
        div {
            font-size:0.850em
        }
    </style>';
    $html .= '
    <table border = "0" width="100%">
        <tr>
            <td width="50%" style="text-align: left;vertical-align:top;padding-bottom: 20px;"><img src="../img/system/mkc.png"
width="180"/></td>
            <td width="50%" style="text-align: right;vertical-align:top;padding-bottom: 20px;">
                <P>
                    <b>Pick Ticket Sample</b><br>
                    <u>' . $hdr["idPts"] . '</u>
                </p>
            </td>
        </tr>
        <tr style="font-size:0.850em">
            <td width="50%" style="text-align: left;padding-top: 20px;">
                Customer : <b>' . $hdr["customer_nama"] . '</b><br>
                Kota : <b>' . $hdr["kota"] . '</b><br>
                Sales : ' . $hdr["sales"] . '</td>

            <td width="50%" style="text-align: right;padding-top: 20px;">
                Tgl. PTS : ' . date_format(date_create($hdr["tgl_create"]),"d M Y") . '<br>
                Tgl. Diambil : ' . date_format(date_create($hdr["tgl_ambil"]),"d M Y") . '<br>
                Tgl. Kembali : ' . $desk . '</td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:0.765em;">*Note : <em>' . $hdr["keterangan"] . '</em></td>
        </tr>
    </table><br>';
$html .= '
<div>
    <table style="min-height : 450px; border: 0.8px solid black; border-collapse:collapse" width="100%" border="1">
        <thead>
            <tr>
                <td>SKU</td>
                <td>Deskripsi</td>
                <td>Comment</td>
                <td align="center">Qty</td>
            </tr>
        </thead>
        <tbody style="border: 0.8px;">';
        while ($yz = $hsl_dtl->fetch_assoc()){
            $html .='<tr>
                <td>'.$yz["model"].'</td>
                <td>'.$yz["deskripsi"].'</td>
                <td>'.$yz["ket"].'</td>
                <td>'.$yz["qty"].'</td>
            </tr>';
        }
        $html .='</tbody>
    </table>
    <br>
    <table width="100%" border="1" style="min-height:120px; border-collapse:collapse;">
        <thead>
            <tr style="border:1px solid black; text-align:center;">
                <td>Diterima </td>
                <td>Sales</td>
                <td colspan="3">Mengetahui</td>
                <td>Yang Menyerahkan</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:120px; vertical-align:top; text-align:center;"></td>
                <td style="height:120px; text-align:center;"><img src="../img/'.$hdr["sales"].'.png" width="50"/></td>
                <td style="height:120px; text-align:center;"><img src="../img/'.$hdr["admin"].'.png" width="50"/></td>
                <td style="height:120px; text-align:center;"><img src="../img/'.$hdr["akunting"].'.png" width="50"/></td>
                <td style="height:120px; vertical-align:top; text-align:center;"></td>
                <td style="height:120px; vertical-align:top; text-align:center;"></td>
            </tr>
            <tr style="text-align:center;font-size:0.865em">
                <td>( . . . . . . . . . )</td>
                <td>' . $hdr["sales"] . '</td>
                <td>' . $hdr["admin"] . '<br>Kepala Admin</td>
                <td>' . $hdr["akunting"] . '<br>Akunting</td>
                <td>( . . . . . . . . . )<br>Kepala Gudang</td>
                <td>( . . . . . . . . . )</td>
            </tr>
            <tr style="font-size:0.765em">
                <td>Tgl.</td>
                <td>Tgl. '. $hdr["tgl_create"] .'</td>
                <td>Tgl. ' . $hdr["tgl_adminapp"] . '</td>
                <td>Tgl. ' . $hdr["tgl_akuntingapp"] . '</td>
                <td>Tgl.</td>
                <td>Tgl.</td>
            </tr>
        </tbody>
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
$dompdf->stream('PTS'.$hdr["idPts"].'.pdf');
?>