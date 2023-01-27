<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '1'){
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
    <?php include 'template/load_css.php';?>
    <!-- load css library -->
</head>

<body>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Form Perubahan PO</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="dataposales.php">Data PO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Form Perubahan PO</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $noso = $_GET['id'];
                $sql = "SELECT * FROM salesorder_hdr sh
                JOIN master_customer ms ON sh.customer_id = ms.customer_id
                JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id
                WHERE noso = '$noso'";
                $mwk = $db1->prepare($sql);
                $mwk -> execute();
                $hsl = $mwk->get_result();
                $rw = $hsl->fetch_assoc();
            ?>
            <?php 
                $cek = "SELECT * FROM master_fpp WHERE noso = '".$_GET['id']."' AND approvl !='1'";
                $mwk = $db1->prepare($cek);
                $mwk -> execute();
                $result_cek = $mwk->get_result();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <?php if($result_cek->num_rows > 0) { ?>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Perubahan PO</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <h4>Pengajuan untuk PO ini sudah ada!</h4>
                            </div>
                            <div class="ibox-footer">
                                <button class="btn btn-warning back"><span
                                        class="glyphicon glyphicon-arrow-left"></span> Kembali
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Perubahan PO</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" width="100%" style="font-size: 0.817em">
                                                <tr>
                                                    <th>Nama Konsumen</th>
                                                    <td>:</td>
                                                    <td><?php echo $rw['customer_nama'];?></td>
                                                    <th>Kota</th>
                                                    <td>:</td>
                                                    <td><?php echo $rw['wilayah_nama']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <hr />
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="noso">No. SCO</label>
                                            <input type="text" name="noso" class="form-control"
                                                value="<?php echo $rw['noso'];?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-md-pull-2">
                                        <div class="form-group">
                                            <label>Tanggal PO</label>
                                            <input type="text" name="" class="form-control"
                                                value="<?php echo $rw['tgl_po']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-md-push-2">
                                        <div class="form-group">
                                            <label>Tanggal Kirim</label>
                                            <input type="text" name="" class="form-control"
                                                value="<?php echo $rw['tgl_krm']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formHeader">
                        <form id="formHdr">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Alasan Perubahan PO</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <input type="hidden" name="noso" id="noso" value="<?php echo $rw['noso']; ?>">
                                        <input type="hidden" name="cs" id="cs"
                                            value="<?php echo $rw['customer_id']; ?>">
                                        <input type="hidden" name="tglpo" id="tglpo"
                                            value="<?php echo $rw['tgl_po']; ?>">
                                        <input type="hidden" name="tglkrm" id="tglkrm"
                                            value="<?php echo $rw['tgl_krm']; ?>">
                                        <input type="hidden" name="tglfpp" id="tglfpp"
                                            value="<?php echo date('Y-m-d'); ?>">
                                        <input type="hidden" name="uinput" id="uinput"
                                            value="<?php echo $data['user_nama'];?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als1" id="als1"
                                                            value="Spesifikasi barang tidak sesuai (salah SKU)"> <i></i>
                                                        Spesifikasi barang tidak sesuai (salah SKU) </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als2" id="als2"
                                                            value="Kualitas barang tidak sesuai (rusak)"> <i></i>
                                                        Kualitas barang tidak sesuai (rusak) </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als3" id="als3"
                                                            value="Informasi order dari sales/ Marketing tidak sesuai">
                                                        <i></i> Informasi order dari sales/ Marketing tidak sesuai
                                                    </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als4" id="als4"
                                                            value="Waktu pengadaan barang terlalu lama"> <i></i> Waktu
                                                        pengadaan barang terlalu lama </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als5" id="als5"
                                                            value="Pengiriman barang terlalu lama"> <i></i> Pengiriman
                                                        barang terlalu lama </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als6" id="als6"
                                                            value="Jumlah pesanan tidak sesuai (Kurang/ Lebih)"> <i></i>
                                                        Jumlah pesanan tidak sesuai (Kurang/ Lebih) </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="als7" id="als7"
                                                            value="Kesalahan Input ke Dolibar"> <i></i> Kesalahan Input
                                                        ke Dolibar </label>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lain-lain :</label>
                                                    <textarea class="form-control" id="als_ln" name="als_ln"
                                                        placeholder="lain-lain..."></textarea>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-12">
                                                <h5 class="ibox-titlex">Tindak Lanjut Perubahan PO</h5>
                                                <hr>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="pros1" id="pros1"
                                                            value="cancle"> <i></i> Cancle </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="pros2" id="pros2"
                                                            value="Revisi Invoice"> <i></i> Revisi Invoice </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="pros3" id="pros3"
                                                            value="Lengkapi kekurangan jumlah"> <i></i> Lengkapi
                                                        kekurangan jumlah </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="pros4" id="pros4"
                                                            value="Tukar SKU yang sama"> <i></i> Tukar SKU yang sama
                                                    </label>
                                                </div>
                                                <div class="i-checks">
                                                    <label> <input type="checkbox" name="pros5" id="pros5"
                                                            value="Tukar SKU yang berbeda"> <i></i> Tukar SKU yang
                                                        berbeda </label>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lain-lain :</label>
                                                    <textarea class="form-control" id="pros_ln" name="pros_ln"
                                                        placeholder="lain-lain..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Catatan :</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group">
                                            <textarea class="form-control" style="height:75px" name="catatan"
                                                id="catatan" placeholder="tambahkan catatan disni ..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                        $sql_dtl = "SELECT * FROM salesorder_dtl WHERE noso = '$noso'";
                        $mwk = $db1->prepare($sql_dtl);
                        $mwk -> execute();
                        $hsl_dtl= $mwk->get_result();
                        $tot = $hsl_dtl->num_rows;
                    ?>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Data PO</h5><small> <em>Ceklis SKU yang mengalami Peruahan</em></small>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <?php $no=0; while($dtl=$hsl_dtl->fetch_assoc()) :$no++; ?>
                                <div class="formDetail">
                                    <form id="form<?=$no?>">
                                        <div class="text-center label label-danger">Item <?=$no?></div>
                                        <table class="table-responsive" style="font-size: 0.857em" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>SKU</th>
                                                    <th>Qty</th>
                                                    <th>Ket</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="item" id="item<?=$no?>"
                                                            value="<?php echo $dtl['id']; ?>">
                                                    </td>
                                                    <td width="40%"><input type="text" class="form-control" name="sku"
                                                            id="sku<?=$no?>" value="<?php echo $dtl['model']; ?>"
                                                            readonly></td>
                                                    <td width="20%"><input type="text" class="form-control" name="qty"
                                                            id="qty<?=$no?>" value="<?php echo $dtl['qty']; ?>" readonly
                                                            style="font-size: 0.856em"></td>
                                                    <td width="30%"><input type="text" class="form-control" name="ket"
                                                            id="ket<?=$no?>" value="<?php echo $dtl['keterangan']; ?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                    </form>
                                </div>
                                <?php endwhile; ?>
                                <input type="hidden" name="total_row" id="total_row" value="<?=$tot?>">
                                <?php if($data['level'] == 'sales'): ?>
                                <button class="btn btn-success float-right simpan" name="simpan"><span
                                        class="fa fa-save (alias)"></span>
                                    Simpan
                                </button>
                                <?php endif; ?>
                                <button class="btn btn-warning back"><span class="fa fa-arrow-circle-left"></span>
                                    Kembali
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });
        var value = $('#total_row').val();
        var userinput = $('#uinput').val();
        var nomorpo = $('#noso').val();
        $(".simpan").click(() => {
            var formHdr = $("#formHdr").serializeArray();
            $.ajax({
                method: "POST",
                url: "modal/FppHdr.php",
                data: formHdr,
                success: function(data) {
                    var idFpp = data;
                    for (var i = 1; i <= value; i++) {
                        event.preventDefault();
                        var tgl = $("#tglfpp").val();
                        var form = $('#form' + (i)).serializeArray();
                        form.push({
                            name: "tgl",
                            value: tgl
                        });
                        form.push({
                            name: "idFpp",
                            value: idFpp
                        });
                        form.push({
                            name: "no_urut",
                            value: i
                        });

                        $.ajax({
                            method: "POST",
                            url: "modal/FppDetail.php",
                            data: form,
                            success: function(data) {
                                // console.log(data);
                            }
                        });
                    }
                    var url =
                        'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                    // var chat_id = "1857799344";
                    var chat_id = "-759758736";
                    var text = "Ada Pengajuan Perubahan PO ~ " +
                        " No. FPP : " + idFpp + " " +
                        " No. PO : " + nomorpo + " " +
                        " Diajukan Oleh : " + userinput;
                    $.ajax({
                        url: url,
                        method: "get",
                        data: {
                            chat_id: chat_id,
                            text: text
                        }
                    });
                    Swal.fire(
                        'Good Job!',
                        'Pengajuan berhasil dibuat!',
                        'success'
                    );
                    // console.log(data);
                    setTimeout(function() {
                        location.assign("datafppsales.php");
                    }, 2000);
                }
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        document.getElementById('fpp').setAttribute('class', 'active');
    });
    </script>
</body>

</html>