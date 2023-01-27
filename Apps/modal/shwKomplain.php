<?php
$id = $_POST['id'];

include '../../config/connection.php';

$sql = "SELECT * FROM tb_komplain_hdr WHERE komplain_id = '$id'";
$pcs = $db1->prepare($sql);
$pcs->execute();
$res = $pcs->get_result();
$row = $res->fetch_assoc();

$sql_dua = "SELECT * FROM tb_komplain_dtl WHERE komplain_id = '$id'";
$pcs_dua = $db1->prepare($sql_dua);
$pcs_dua->execute();
$res_dua = $pcs_dua->get_result();
?>
<div class="table-responsive">
    <table class="table table-borderless" width="100%">
        <tr>
            <th>ID Komplain</th>
            <th>: <?= $row['komplain_id'] ?></th>
            <th>Customer</th>
            <th>: <?= $row['nama_customer'] ?></th>
        </tr>
        <tr>
            <th>No SO</th>
            <th>: <?= $row['noso'] ?></th>
            <th>Tgl. SO</th>
            <th>: <?= $row['tgl_noso'] ?></th>
        </tr>
        <tr>
            <th>No CO</th>
            <th>: <?= $row['No_Co'] ?></th>
            <th>Tgl. CO</th>
            <th>: <?= $row['tgl_Co'] ?></th>
        </tr>
        <tr>
            <th>Tgl Kirim</th>
            <th>: <?= $row['tgl_delivery'] ?></th>
            <th>Tgl. Komplain</th>
            <th>: <?= date('d/m/Y', $row['date_created']) ?></th>
        </tr>
        <tr>
            <th>Isi Komplain</th>
            <td colspan="3">: <?= $row['txt_komplain'] ?></td>
        </tr>
        <tr>
            <th>Tindakan</th>
            <td colspan="3">: <?= $row['txt_tindakan'] ?></td>
        </tr>
    </table>
</div>
<hr style="border: 1px solid blue;">
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SKU</th>
                <th>QTY</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_dua = $res_dua->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row_dua['model'] ?></td>
                    <td><?= $row_dua['qty'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>