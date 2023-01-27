<?php
include '../config/connection.php';

session_start();
$akses = $_SESSION['moduls'];
if (!isset($_SESSION['usernameu']) || $akses !== '1') {
    header("Location: ../index.php");
}
$id = $_SESSION['idu'];
$query = "SELECT * FROM master_user WHERE user_id='$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl = $mwk->get_result();
$data = $resl->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'template/load_css.php'; ?>
    <!-- load css library -->
</head>

<body>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- breadcum -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>List Promo DSO</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="promoBundling.php">Master Promo</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add New Promo</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- line of content -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title bg-info">
                                <h5>Form Add Promo</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link back">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content" style="background-color: LightCyan;">
                                <div id="formHeader">
                                    <form method="POST" id="promoHeader">
                                    <input type="hidden" name="addby" id="addby" value="<?= $data['user_nama']?>">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">Nama Promo <sup style="color:red">*</sup></label>
                                                    <input type="text" class="form-control" name="namapromo" id="namapromo" placeholder="Type Here for Promo Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="">Jenis Promo</label>
                                                    <select id="jenis_promo1" name="jenis_promo" class="form-control">

                                                        <option value="">Pilih</option>
                                                        <option value="0">Satuan | Note: Qty barang promo 1</option>
                                                        <option value="1">Banyak | Note: Qty barang promo lebih dari 1</option>
                                                        <option value="2">Akumulatif | Note: Promo sesuai jumlah Qty</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Deskripsi Promo <sup style="color:red">*</sup></label>
                                                    <textarea name="deskripsi" id="deskripsi" class="form-control" style="height: 75px;" placeholder="Type here for more information"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr style="background-color: red;">
                                <div id="formDetail">
                                    <form method="POST" id="promoDetail1">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>SKU</label>
                                                    <select id="sku1" name="sku" class="form-control pilih1 chosen-container-multi">
                                                        <option value="">= PILIH =</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="">Harga Dasar</label>
                                                    <input type="text" name="hargadasar" id="hargadasar1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <label for="">Disc (%)</label>
                                                    <input type="text" name="diskon_persen" id="diskon_persen1" class="form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="">Nominal Diskon</label>
                                                    <input type="text" name="nom_disc" id="nom_disc1" class="form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">Harga Diskon</label>
                                                    <input type="text" name="harga_diskon" id="harga_diskon1" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3" id="sQty1">
                                                <div class="form-group">
                                                    <label for="">Min Pembelian Promo</label>
                                                    <input type="number" name="promo_qty" id="promo_qty1"  class="form-control" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr style="background-color: red;">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info simpan float-right" id="save"><span class="fa fa-save"></span> Simpan</button> 
                                    <button class="btn btn-warning tambah" id="tambah"><span class="fa fa-plus"></span> Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script src="DataScript/addPromos.js"></script>
</body>

</html>