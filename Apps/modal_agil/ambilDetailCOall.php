<?php
    include '../../config/connection.php';


    session_start(); 
    $akses = $_SESSION['moduls'];
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data_user = $resl->fetch_assoc(); 

    

    $noco = $_POST['noco'];
    function rupiah($angka){
	
        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
     
    }
    $query = "SELECT a.noso, a.No_Co,a.sales,a.customer_id,d.term, c.customer_nama, a.sales, a.no_bl, a.no_fa, a.no_sh,  a.alamat_krm 
    FROM customerorder_hdr a
    JOIN customerorder_dtl b ON a.No_Co = b.No_Co
    JOIN salesorder_hdr d ON a.noso = d.noso
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.No_Co = '$noco'";
    $mwk=$db1->prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    $hdr = $resl->fetch_assoc();
?>
<div class="ibox" style="width:100%;overflow-x:auto">
    <table class="table" width="100%" style="background-color:white;">
        <tr>
            <th>No. CO</th>
            <td>:</td>
            <td id="noco_hdr"><?php echo $hdr['No_Co']; ?></td>
            <th> No SO</th>
            <td>:</td>
            <td id="noso_hdr"><?php echo $hdr['noso']; ?></td>
        </tr>
        <tr>
            <th>No. SH</th>
            <td>:</td>
            <td id="nosh_hdr"><?php echo $hdr['no_sh']; ?></td>
            <th> No. BL</th>
            <td>:</td>
            <td id="nobl_hdr"><?php echo $hdr['no_bl']; ?></td>
        </tr>
        <tr>
            <th>No. FA</th>
            <td>:</td>
            <td id="nofa_hdr"><?php echo $hdr['no_fa']; ?></td>
            <th> Customer Name</th>
            <td>:</td>
            <td id="customer_hdr"><?php echo $hdr['customer_nama']; ?></td>
        </tr>
        <tr>
            <th colpsan="2">TOP </th>
            <td>:</td>
            <td id="top_hdr" colspan="4"><?php echo $hdr['term']; ?></td>
        </tr>
        <tr>
            <th colpsan="2">Alamat Kirim </th>
            <td>:</td>
            <td id="alamat_hdr" colspan="4"><?php echo $hdr['alamat_krm']; ?></td>
        </tr>
        <div class="d-none" id="customer_id_hdr"><?php echo $hdr['customer_id']; ?></div>
    </table>
</div>
<hr>
<?php
    $query2 = "SELECT * FROM customerorder_dtl WHERE No_Co = '$noco' ORDER BY no_urut ASC";
    $mwk = $db1->prepare($query2);
    $mwk -> execute();
    $resl2 = $mwk->get_result();
    $no = 0;

    $query3 = "SELECT SUM(diskon) AS disc, SUM(ppn) AS pajak, SUM(amount) AS subtotal, SUM(harga_total) AS total FROM customerorder_dtl WHERE No_Co = '$noco'";
    $mwk = $db1->prepare($query3);
    $mwk -> execute();
    $resl3 = $mwk->get_result();
 

?>
<div style="width:100%;overflow-x:auto">
    <form id='form_<?=$no?>'>
        <table class="table ">
            <!-- <?php if($no ==1):?>
            <?php endif;?> -->

            <tbody style="background-color:white;">
                <div class="responsive">
                    <tr>
                        <th>Deskripsi/SKU</th>
                        <th>Qty Kirim</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>PPN</th>
                        <th>Amount</th>
                        <th>Harga Total</th>
                    </tr>
                    <?php while ($dtl = $resl2->fetch_assoc()){ ?>
                    <tr>
                        <th><?php echo $dtl['model']; ?></th>
                        <td><?php echo $dtl['qty_kirim']; ?></td>
                        <td>Rp. <?php echo number_format($dtl['price'],0,".","."); ?> </td>
                        <td>Rp. <?php echo number_format($dtl['diskon'],0,".","."); ?></td>
                        <td>Rp. <?php echo number_format($dtl['ppn'],0,".","."); ?></td>
                        <td>Rp. <?php echo number_format($dtl['amount'],0,".","."); ?></td>
                        <td>Rp. <?php echo number_format($dtl['harga_total'],0,".","."); ?></td>
                    </tr>
                    <?php } ?>
                    <?php while ($dtl = $resl3->fetch_assoc()){ ?>
                    <tr>
                        <th>Total Diskon</th>
                        <th colspan="5">

                        <td>Rp. <?php echo number_format ($dtl['disc'],0,".","."); ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Total PPN</th>
                        <th colspan="5">
                        <td>Rp. <?php echo number_format($dtl['pajak'],0,",","."); ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <th colspan="5">
                        <td>Rp. <?php echo number_format($dtl['subtotal'],0,",","."); ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th colspan="5">
                        <td>Rp. <?php echo number_format($dtl['total'],0,",","."); ?></td>
                        </th>
                    </tr>
                    <?php } ?>
                </div>
            </tbody>
        </table>
    </form>
    <input type="hidden" name="total" value="<?php echo $no; ?>">
</div>
<tr></tr>