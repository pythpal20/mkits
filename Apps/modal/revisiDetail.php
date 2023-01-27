<?php
include '../../config/connection.php';
session_start(); 

$id     = $_SESSION['idu'];
$quser  = "SELECT * FROM master_user WHERE user_id='$id'"; 
$mwk    = $db1->prepare($quser); 
$mwk->execute();
$result = $mwk->get_result();
$data   = $result->fetch_assoc(); 

if (isset($_POST["co"])) {
    error_reporting(0);
    $output = '';
    $query = "SELECT a.No_Co, a.noso, b.customer_nama, b.pic_nama, b.customer_telp, b.pic_kontak, a.tgl_order, a.tgl_krm, a.ongkir, a.alamat_krm, a.no_sh, a.tgl_inv FROM log_customerorder_hdr a
    JOIN master_customer b ON a.customer_id = b.customer_id 
    WHERE a.No_Co = '" . $_POST["co"] . "' AND a.keterangan='" . $_POST['revisi'] . "'";
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
if (isset($_POST["co"])) {
    $output = '';
    $query1 = "SELECT a.model, b.deskripsi, a.price, a.amount, a.qty_kirim FROM log_customerorder_dtl a
    JOIN master_produk b ON a.model = b.model
    WHERE a.No_Co = '" . $_POST["co"] . "' AND revisi='" . $_POST['revisi'] . "' ORDER BY a.no_urut ASC";
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
    FROM log_customerorder_dtl WHERE No_Co = '" . $_POST["co"] . "' AND revisi='" . $_POST["revisi"] . "'";
    $mwk = $db1->prepare($summ);
    $mwk ->execute();
    $res_sum = $mwk->get_result();
    $row2 = $res_sum->fetch_assoc();
$output .= '    
    <tfoot>
        <tr>
            <th colspan="3" class="table-default">Total</th>
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
            <th colspan="3">Total (inc. Tax)</th>
            <th>Rp. ' . number_format($row2["ttl"] + $row["ongkir"],0,".",".") . '</th>
        </tr>
    </tfoot>
</table>';
}
echo $output;
?>
<hr>
<span class="label label-warning"><?=$_POST['revisi'] ?></span>