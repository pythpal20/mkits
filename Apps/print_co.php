<?php
    include '../config/connection.php';
    $id = $_GET['id'];
    $query = "SELECT  
        a.no_sh,
        a.tgl_order,
        a.customer_nama,
        a.alamat_krm,
        c.pic_nama,
        c.customer_telp,
        c.pic_kontak,
        a.ongkir, 
        b.atasnama,
        b.nama_pt,
        a.noso,
        a.No_Co,
        a.issuedby
    FROM customerorder_hdr a
    JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan 
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.No_Co = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
    $row = $resl->fetch_assoc();
?>
<div id="elemenPrint">
    <input type="hidden" id="nodoc" value="<?php echo $id; ?>">
    <style>
    table {
        font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif, Helvetica, sans-serif;
        font-size: 12px;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    .table-bordered {
        border: 0.8px solid black;
        border-collapse: collapse;
    }

    .table-bordered th,
    .table-bordered td {
        border: 0.8px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
    }
    
    td {
        height: 15px;
    }
    </style>
     
    <table>
        <table width="100%">
            <tr>
                <td style="vertical-align: top;">
                    <h3><?php echo $row['atasnama']; ?></h3>
                </td>
                <td style="text-align: right; vertical-align:top;">
                    <p>
                        <b>Order</b><br>
                        <b>Ref : <?php echo substr($row['No_Co'],4);?></b><br>
                        No. SO : <?php echo $row['noso'];?><br>
                        Order Date : <?php echo date_format(date_create($row['tgl_order']), 'd/m/Y'); ?>
                    </p>
                </td>
            </tr>
        </table>
        <!-- tabel lagi -->
        <table width="100%">
            <tr>
                <td width="50%">From :</td>
                <td width="50%">To :</td>
            </tr>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td>
                                <p style="line-height: 1;">
                                    <b><?php echo $row['atasnama'];?></b><br>
                                    Jl. Garuda 75-77<br>
                                    40183 Bandung
                                </p>
                                <p>
                                    Phone : 0226031070<br>
                                    Fax : 0226038229
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align:top;">
                    <table style="border: 0.8px solid black; border-collapse: collapse separate;" width="100%">
                        <tr>
                            <td>
                                <p>
                                    <b><?php echo $row['customer_nama']; ?></b><br>
                                    <?php echo $row['alamat_krm'];?>
                                </p>
                                <p>
                                    UP : <?php echo $row['pic_nama']; ?><br>
                                    <?php echo $row['customer_telp'].' / '.$row['pic_kontak']; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p style="text-align:right; font-size: 12px;">Amount in Indonesia Rupiah currency</p>
        <table style="min-height: 420px;" width="100%" class="table-bordered">
            <thead>
                <tr>
                    <td>Description</td>
                    <td align="center">Sales Tax</td>
                    <td align="center">U.P (net)</td>
                    <td align="center"> Qty </td>
                    <td align="center">Total (Net of Tax)</td>
                </tr>
            </thead>
            <tbody>
                <tr style="vertical-align:top;">
                    <td>
                        <?php 
                    $sql1 ="SELECT a.model, b.deskripsi 
                    FROM customerorder_dtl a 
                    JOIN master_produk b ON a.model = b.model
                    WHERE No_Co = '$id'";
                    $mwk = $db1->prepare($sql1);
                    $mwk ->execute();
                    $res = $mwk->get_result();
                    while ($rw= $res->fetch_assoc()){
                        echo $rw['model'].' - '. $rw['deskripsi'].'<br>';
                    }
                    ?>
                    </td>
                    <td align="right">
                        <?php
                        $sql2 ="SELECT ppn FROM customerorder_dtl WHERE No_Co = '$id'";
                        $mwk = $db1->prepare($sql2);
                        $mwk ->execute();
                        $res = $mwk->get_result();
                        while($tx = $res->fetch_assoc()){
                            echo $tx['ppn'].'<br>';
                        }
                    ?>
                    </td>
                    <td align="right">
                        <?php
                        $sql2 ="SELECT price FROM customerorder_dtl WHERE No_Co = '$id'";
                        $mwk = $db1->prepare($sql2);
                        $mwk ->execute();
                        $res = $mwk->get_result();
                        while($tx = $res->fetch_assoc()){
                            echo number_format($tx['price'],2,".",",").'<br>';
                        }
                    ?>
                    </td>
                    <td align="right">
                        <?php
                        $sql2 ="SELECT qty_kirim FROM customerorder_dtl WHERE No_Co = '$id'";
                        $mwk = $db1->prepare($sql2);
                        $mwk ->execute();
                        $res = $mwk->get_result();
                        while($tx = $res->fetch_assoc()){
                            echo $tx['qty_kirim'].'<br>';
                        }
                    ?>
                    </td>
                    <td align="right">
                        <?php
                        $sql2 ="SELECT amount FROM customerorder_dtl WHERE No_Co = '$id'";
                        $mwk = $db1->prepare($sql2);
                        $mwk ->execute();
                        $res = $mwk->get_result();
                        while($tx = $res->fetch_assoc()){
                            echo number_format($tx['amount'],2,".",",").'<br>';
                        }
                    ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php 
        $qry = "SELECT SUM(amount) AS tAmt, SUM(ppn) AS tPjk, SUM(diskon) AS tDsc, SUM(harga_total) AS total FROM customerorder_dtl WHERE No_Co = '$id'";
        $mwk = $db1->prepare($qry);
        $mwk -> execute();
        $hsl = $mwk->get_result();
        $dtl = $hsl->fetch_assoc();
        
    ?>
        <table width="100%">
            <tbody>
                <?php if ($dtl['tDsc'] !=0) { ?>
                <tr>
                    <td align="right" width="75%">Discount</td>
                    <td align="right"><?php echo number_format($dtl['tDsc'],2,".",","); ?></td>
                </tr>
                <?php } ?>
                <?php if($dtl['tPjk'] !=0) : ?>
                <tr>
                    <td align="right" width="75%">Tax</td>
                    <td align="right"><?php echo number_format($dtl['tPjk'],2,".",","); ?></td>
                </tr>
                <?php endif;?>
                <tr>
                    <?php if($row['ongkir'] != 0) { ?>
                    <td align="right" width="75%">shipping cost</td>
                    <td align="right"><?php echo number_format($row['ongkir'],2,".",","); ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td align="right" width="75%">Total (net of tax)</td>
                    <td align="right"><?php echo number_format($dtl['tAmt'],2,".",","); ?></td>
                </tr>
                <tr>
                    <td align="right" width="75%">Total (inc. tax)</td>
                    <td align="right"><?php echo number_format($dtl['total']+$row['ongkir'],2,".",","); ?></td>
                </tr>
            </tbody>
        </table>
        <table width="50%" style="min-height: 120px;">
            <thead>
                <tr>
                    <td width="50%"><b>Issued By :</b></td>
                    <td width="50%"><b>Approve By :</b></td>
                </tr>
            </thead>
            <tbody>
                <tr style="vertical-align:bottom;">
                    <td><b><?php echo $row['issuedby']; ?></b></td>
                    <td><b>Stephanie A</b></td>
                </tr>
            </tbody>
        </table>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
<script>
var nodoc = document.getElementById('nodoc')
var element = document.getElementById('elemenPrint')
html2pdf(element, {
    margin: 10,
    filename: 'ORDER-' + '<?= $id ?>' + '.pdf',
    image: {
        type: 'jpeg',
        quality: 5.00
    },
    html2canvas: {
        scale: 2,
        logging: true,
        dpi: 500,
        letterRendering: true
    },
    jsPDF: {
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait'
    }
});
</script>