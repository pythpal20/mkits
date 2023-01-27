<?php
    include '../../config/connection.php';
    $id = $_POST['id'];

    $query = "SELECT a.noso, b.tgl_po, c.customer_nama, c.pic_nama, c.customer_telp, c.pic_kontak, b.sales, b.term, a.alamat_krm, d.nama_pt
    FROM customerorder_hdr_pending a
    JOIN salesorder_hdr b ON a.noso = b.noso
    JOIN master_customer c ON a.customer_id = c.customer_id
    JOIN list_perusahaan d ON b.id_perusahaan = d.id_perusahaan
    WHERE a.noso = '$id'";
    $mwk=$db1->prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    $hdr = $resl->fetch_assoc();
?>
<table class="table" width="100%">
    <tr>
        <th>No. SCO</th>
        <td>:</td>
        <td><?php echo $hdr['noso']; ?></td>
        <th>Tanggal SCO</th>
        <td>:</td>
        <td><?php echo $hdr['tgl_po']; ?></td>
    </tr>
    <tr>
        <th>Nama Customer</th>
        <td>:</td>
        <td><?php echo $hdr['customer_nama']; ?></td>
        <th>UP</th>
        <td>:</td>
        <td><?php echo $hdr['pic_nama']; ?></td>
    </tr>
    <tr>
        <th>Sales</th>
        <td>:</td>
        <td><?php echo $hdr['sales']; ?></td>
        <th>PT</th>
        <td>:</td>
        <td><?php echo $hdr['nama_pt']; ?></td>
    </tr>
    <tr>
        <th>Term</th>
        <td>:</td>
        <td><?php echo $hdr['term']; ?></td>
        <th>kontak</th>
        <td>:</td>
        <td><?php echo $hdr['pic_kontak']; ?></td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>:</td>
        <td colspan="4"><?php echo $hdr['alamat_krm']; ?></td>
    </tr>
</table>
<hr>
<?php
    $query2 = "SELECT * FROM customerorder_dtl_pending WHERE noso = '$id' ORDER BY no_urut ASC";
    $mwk = $db1->prepare($query2);
    $mwk -> execute();
    $resl2 = $mwk->get_result();
    $no = 1;
?>
<table class="table table-bordered">
    <thead class="table-info">
        <tr class="text-center">
            <th>#</th>
            <th>SKU</th>
            <th>Terkirim</th>
            <th>Sisa Pending</th>
            <th>Harga</th>
            <th>Diskon</th>
            <th>PPN</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($dtl = $resl2->fetch_assoc()){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $dtl['model']; ?></td>
            <td><?php echo $dtl['qty_kirim']; ?></td>
            <td><?php echo $dtl['qty_sisa']; ?></td>
            <td><?php echo $dtl['price']; ?></td>
            <td><?php echo $dtl['diskon']; ?></td>
            <td>
                <?php 
                    if($dtl['ppn'] == '0'){
                        echo 'No';
                    } else{
                        echo 'Yes';
                    }
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>