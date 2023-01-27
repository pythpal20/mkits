<?php

include '../../config/connection.php';
$id = $_GET['id'];


$sql = mysqli_query($connect, "SELECT * FROM tb_komplain_hdr WHERE komplain_id = '$id'");
$row = mysqli_fetch_array($sql);

$query = mysqli_query($connect, "SELECT * FROM customerorder_hdr_delivery WHERE No_Co = '" . $row['No_Co'] . "'");
$er = mysqli_fetch_array($query);

$sql_dua = mysqli_query($connect, "SELECT * FROM tb_komplain_dtl WHERE komplain_id = '" . $id . "'");
?>
<style>
    th,
    td {
        padding: 5px;
    }
</style>
<table border="1" style="border:1px solid black ; border-collapse:collapse; " width="100%">
    <tr>
        <td style="vertical-align:center; text-align: center" colspan="5" width="60%">
            <h2>MINUTES OF MEETING</h2>
        </td>
        <td colspan="4" style="text-align: center;"><img src="../../img/system/mkc3.png" alt="" width="180px"></td>
    </tr>
    <tr>
        <td rowspan="2" colspan="5">Subject : Komplain untuk "<b><?= $row['nama_customer'] ?></b>"</td>
        <td colspan="4">
            <table border="0" width="100%" style="font-size: 0.820em;">
                <td>Date</td>
                <td width="50%">: <?= date('d/m/Y', $row['date_created']) ?></td>
                <td></td>
                <td>Place</td>
                <td width="50%">: MKITS/ Sales</td>
                <td></td>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <table border="0" width="100%" style="font-size: 0.820em;">
                <td>Time</td>
                <td width="50%">: <?= date('H:i', $row['date_created']) ?> PM</td>
                <td></td>
                <td>Page</td>
                <td width="50%">:</td>
                <td></td>
            </table>
        </td>
    </tr>
    <tr>
        <td rowspan="2" width="15%" height="55px">Agenda :</td>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td rowspan="3" align="left" width="15%">Person Attending :</td>
    </tr>
    <tr style="font-size: 0.820em;">
        <td width="15%">1. <?= $row['sales'] ?></td>
        <td width="15%">2. </td>
        <td width="15%">3. </td>
        <td width="15%" colspan="2">4. </td>
        <td width="15%">5. </td>
        <td width="16%" colspan="2">6. </td>
    </tr>
    <tr style="font-size: 0.820em;">
        <td width="15%">7. </td>
        <td width="15%">8. </td>
        <td width="15%">9. </td>
        <td width="15%" colspan="2">10. </td>
        <td width="15%">11</td>
        <td width="16%" colspan="2">12. </td>
    </tr>
    <tr>
        <td colspan="9" style="height: 650px; vertical-align: top;">
            <div style="padding-top: 10px">
                <table style="border: 0; collapse: collapse; align: left; font-size:0.845em" width="100%" rules="rows" >
                <tr>
                    <td colspan="6" style="text-align: center;">ID Komplain : <?= $row["komplain_id"] ?></td>
                </tr>
                    <tr>
                        <td>No. SCO</td>
                        <td>: <?= $row['noso'] ?></td>
                        <td>Tgl. SCO</td>
                        <td>: <?= $row['tgl_noso'] ?></td>
                        <td>Sales</td>
                        <td>: <?= $row['sales'] ?></td>
                    </tr>
                    <tr>
                        <td>No. CO</td>
                        <td>: <?= $row['No_Co'] ?></td>
                        <td>Tgl. CO</td>
                        <td>: <?= $row['tgl_Co'] ?></td>
                        <td>Dikirim Oleh</td>
                        <td>: <?= $er['kenek'] ?></td>
                    </tr>
                    <tr>
                        <td rospan="2">Tgl. Kirim</td>
                        <td rospan="2">: <?= $row['tgl_delivery'] ?></td>
                        <td rospan="2">Alamat Kirim</td>
                        <td rospan="2" colspan="3">: <?= $er['alamat_krm'] ?></td>
                    </tr>
                </table>
            </div>
            <!-- <hr style="border: 1px solid black"> -->
            <div style="padding-top: 25px">
                <table style="border: 1px solid black; border-collapse: collapse;" border="1" width="75%">
                    <thead>
                        <tr>
                            <th>SKU/ Item</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_array($sql_dua)) : ?>
                            <tr>
                                <td><?= $data['model'] ?></td>
                                <td><?= $data['qty'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <p><b>Alasan</b> : </p>
            <p><?= $row['txt_komplain'] ?></p>
            <p><b>Tindakan selanjutnya</b> :</p>
            <p><?= $row['txt_tindakan'] ?></p>
        </td>
    </tr>
</table>
<script>
    window.print();
</script>