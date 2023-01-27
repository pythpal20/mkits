<?php
include '../../config/connection.php';
session_start();
$ids = $_SESSION['idu'];
$query = "SELECT * FROM master_user WHERE user_id='$ids'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl = $mwk->get_result();
$data = $resl->fetch_assoc();

$id = $_POST['id'];

$sql = "SELECT a.customer_id, 
    a.customer_nama, 
    a.noso, 
    b.tgl_po, 
    a.No_Co, 
    c.tgl_create, 
    a.tgl_delivery 
FROM customerorder_hdr_delivery a
JOIN salesorder_hdr b ON a.noso = b.noso
JOIN customerorder_hdr c ON a.No_Co = a.No_Co
WHERE a.No_Co = '$id'";
$pcs = $db1->prepare($sql);
$pcs->execute();
$hdr = $pcs->get_result();
$r = $hdr->fetch_assoc();

$sql_detail = "SELECT * FROM customerorder_dtl_delivery WHERE No_Co = '$id'";
$pcs = $db1->prepare($sql_detail);
$pcs->execute();
$dtl = $pcs->get_result();

?>
<div id="fheader">
    <form id="formHeader">
        <div class="form-row">
            <div class="form-group col-sm-4">
                <label for="customer">Nama Customer</label>
                <input type="text" name="nmcustomer" id="nmcustomer" class="form-control" value="<?= $r['customer_nama'] ?>" readonly>
                <input type="hidden" name="idcustomer" id="idcustomer" value="<?= $r['customer_id'] ?>">
                <input type="hidden" name="userx" id="userx" value="<?= $data['user_nama'] ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-3">
                <label for="noso">No. SO</label>
                <input type="text" name="noso" id="noso" class="form-control" value="<?= $r['noso']; ?>" readonly>
            </div>
            <div class="form-group col-sm-2">
                <label for="tglso">Tgl Order</label>
                <input type="text" name="tglorder" id="tglorder" value="<?= $r['tgl_po'] ?>" class="form-control" readonly>
            </div>
            <div class="form-group col-sm-3">
                <label for="noco">No. CO</label>
                <input type="text" name="noco" id="noco" value="<?= $r['No_Co']; ?>" class="form-control" readonly>
            </div>
            <div class="form-group col-sm-2">
                <label for="tglco">Tgl. CO</label>
                <input type="text" name="tglco" id="tglco" value="<?= $r['tgl_create']; ?>" class="form-control" readonly>
            </div>
            <div class="form-group col-sm-2">
                <label for="tgldelivery">Tgl. Delivery</label>
                <input type="text" name="tgldelivery" id="tgldelivery" value="<?= $r['tgl_delivery']; ?>" class="form-control" readonly>
            </div>
            <div class="form-group col-sm-12">
                <label for="">Isi Komplain</label>
                <textarea class="form-control komplen" name="isi" id="isi" cols="15" rows="5" placeholder="isi komplen disini"></textarea>
            </div>
            <div class="form-group col-sm-12">
                <label for="">Tindakan</label>
                <textarea class="form-control tindakan" name="tindakan" id="tindakan" cols="15" rows="5" placeholder="isi komplen disini"></textarea>
            </div>
        </div>
    </form>
</div>
<hr style="border: 1px solid blue">
<div id="fdetail">
    <?php $no = 1;
    while ($d = $dtl->fetch_assoc()) : ?>
        <form id="form<?= $no ?>">
            <div class="form-row">
                <div class="form-group col-1">
                    <input type="checkbox" name="intid" id="intid<?= $no ?>" class="form-control" value="<?= $d['id'] ?>">
                </div>
                <div class="form-group col-6">
                    <input type="text" name="sku" id="sku<?= $no ?>" value="<?= $d['model'] ?>" class="form-control" readonly>
                </div>
                <div class="form-group col-5">
                    <input type="text" name="qty" id="qty<?= $no ?>" value="<?= $d['qty_kirim'] ?>" class="form-control" >
                </div>
            </div>
        </form>
    <?php $no++; endwhile;  ?>
    <input type="hidden" name="count" id="count" value="<?= $no - 1; ?>">
</div>