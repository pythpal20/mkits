<?php
include '../../config/connection.php';
session_start(); 

$id     = $_SESSION['idu'];
$quser  = "SELECT * FROM master_user WHERE user_id='$id'"; 
$mwk    = $db1->prepare($quser); 
$mwk->execute();
$result = $mwk->get_result();
$data   = $result->fetch_assoc(); 

if (isset($_POST["id"])) {
    error_reporting(0);
    $output = '';
    $query = "SELECT a.No_Co, a.no_bl, a.noso, b.customer_nama, b.pic_nama, b.customer_telp, b.pic_kontak, a.tgl_order, a.tgl_krm, a.ongkir, a.alamat_krm, a.no_sh, a.tgl_inv, a.status FROM customerorder_hdr a
    JOIN master_customer b ON a.customer_id = b.customer_id 
    WHERE a.No_Co = '" . $_POST["id"] . "'";
    $mwk = $db1 -> prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    $row = $resl->fetch_assoc();

    $output .= '
<table class="table display" width="100%">
    <tr>
        <th>No. CO</th>
        <td> : </td>
        <td>'. substr($row["No_Co"],4) .'</td>
        <th>SCO</th>
        <td> : </td>
        <td>'. $row["noso"] .'</td>
    </tr>
    <tr>
        <th>Nama Customer</th>
        <td> : </td>
        <td>'. $row["customer_nama"] .'</td>
        <th>UP</th>
        <td> : </td>
        <td>'. $row["pic_nama"] .'</td>
    </tr>
    <tr>
        <th>Kontak</th>
        <td> : </td>
        <td>'. $row["customer_telp"] .' / '. $row["pic_kontak"] .'</td>
        <th class="table-warning">Tanggal Order</th>
        <td> : </td>
        <td>'. $row["tgl_order"] .'</td>
    </tr>
    <tr>
        <th>Tanggal Kirim</th>
        <td> : </td>
        <td>'. $row["tgl_krm"] .'</td>
        <th class="table-danger">Tanggal Invoice</th>
        <td>:</td>
        <td>'. $row["tgl_inv"] . '</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td> : </td>
        <td colspan="4">'. $row["alamat_krm"] .'</td>
    </tr>
</table><hr>';
}
echo $output;
?>

<?php
if (isset($_POST["id"])) {
    $output = '';
    $query1 = "SELECT model, price, amount, qty_kirim FROM customerorder_dtl
    WHERE No_Co = '" . $_POST["id"] . "' ORDER BY no_urut ASC";
    $mwk=$db1->prepare($query1);
    $mwk->execute();
    $res = $mwk->get_result();

    $output .= '
<table class="table table-bordered display" width="100%">
    <thead>
        <tr>
            <th>Deskripsi</th>
            <th>Jumlah Item</th>
            <th>Harga</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>';
        while ($row1 = $res->fetch_assoc()) { 
        $output .='
        <tr>
            <th>'. $row1["model"] .'</th>
            <td>'. $row1["qty_kirim"] .'</td>
            <td>Rp. '. number_format($row1["price"],0,".",".") .'</td>
            <td>Rp. '. number_format($row1["amount"],0,".",".") .'</td>
        </tr>
        ';
        }
        $output .='
    </tbody>';
    $summ = "SELECT SUM(amount) AS ttl_amt, SUM(diskon) AS disc, SUM(ppn) AS pajak, SUM(harga_total) AS ttl
    FROM customerorder_dtl WHERE No_Co = '" . $_POST["id"] . "'";
    $mwk = $db1->prepare($summ);
    $mwk ->execute();
    $res_sum = $mwk->get_result();
    $row2 = $res_sum->fetch_assoc();
$output .= '    
    <tfoot>
        <tr>
            <th colspan="3" class="table-default">Subtotal</th>
            <th>Rp.' . number_format($row2["ttl_amt"],0,".",".") . '</th>
        </tr>
        <tr>
            <th colspan="3" class="table-default">Diskon</th>
            <th>Rp.' . number_format($row2["disc"],0,".",".") . '</th>
        </tr>
        <tr>
            <th colspan="3">TAX (10%)</th>
            <th>Rp. ' . number_format($row2["pajak"],0,".",".") . '</th>
        </tr>
        <tr>
            <th colspan="3">Shipping costs</th>
            <th>Rp. ' . number_format($row["ongkir"],0,".",".") . '</th>
        </tr>
        <tr>
            <th colspan="3">Total </th>
            <th>Rp. ' . number_format($row2["ttl"] + $row["ongkir"],0,".",".") . '</th>
        </tr>
    </tfoot>
</table>';
}
if (isset($_POST["id"])) {

    $tory = "SELECT * FROM tb_history_download_bl WHERE no_bl = '" . $row['no_bl'] . "'";
    $pcs = $db1->prepare($tory);
    $pcs->execute();
    $rtory = $pcs->get_result();
    $nox = 1;

    $output .='<table width="100%" class="table table-bordered" id="story">
    <thead>
        <tr>
            <th colspan="3" style="background-color: yellow">History Dowload Surat Jalan</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Download Date</th>
            <th>Download By</th>
        </tr>
    </thead>
    <tbody rules="cols">';
    while ($rrow = $rtory->fetch_assoc()) {
        $output .='<tr>
            <td>' . $nox++ . '</td>
            <td>' . $rrow["DW_DATE"] . '</td>
            <td>' . $rrow["user"] . '</td>
        </tr>';
    }
    $output .='</tbody></table>';
}

if ($row['status'] == '1') {
$output .= '<div class="button-group">
    <a href="print_co.php?id=' . $_POST["id"] . '" class="btn btn-danger btn-sm" target="_blank"><span
    class="fa fa-download"></span> | ORDER</a>
<a href="print_pt.php?id=' . $_POST["id"] . '" class="btn btn-info btn-sm" target="_blank"><span
        class="fa fa-download"></span> | Pick Ticket</a>
<a href="print_bl.php?id=' . $_POST["id"] . '" class="btn btn-warning btn-sm" target="_blank"><span
        class="fa fa-download"></span> | Surat Jalan</a>
<a href="print_inv.php?id=' . $_POST["id"] . '" class="btn btn-primary btn-sm" target="_blank"><span
        class="fa fa-download"></span> | Invoice</a>
</div>';
}
echo $output;
?>