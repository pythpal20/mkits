<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '3'){
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
                    <h2>Data Order (CO)</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="orderfix.php">Data Order</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit Order</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $noco = $_GET['id'];
                include '../config/connection.php';
                $ambil_perusahaan ="SELECT * from list_perusahaan ";
                $query = "SELECT * FROM customerorder_dtl WHERE No_Co ='".$_GET['id']."'";
                $header =  "SELECT * FROM customerorder_hdr WHERE No_Co='".$_GET['id']."'";
                $ambil_customer ="SELECT * from master_customer where customer_idregister !=''";

                $result = mysqli_query($connect,$query);
                $result_header = mysqli_query($connect,$header);
                $hasil_customer = mysqli_query($connect, $ambil_customer);
                $hasil_perusahaan = mysqli_query($connect, $ambil_perusahaan);

                $total_row = mysqli_num_rows($result);
                function cari_nama_customer($id){
                    include '../config/connection.php';
                    $query = "SELECT customer_nama FROM master_customer WHERE customer_id='$id'";
                    $result = mysqli_query($connect,$query);
                    $arr ="";
                    while ($row = mysqli_fetch_array($result)) {
                        # code...
                    $arr =  $row['customer_nama'];
                    }
                    return $arr;
                }

                function cari_customer_nama($id){
                    include '../config/connection.php';
                    $query = "SELECT * FROM list_perusahaan WHERE id_perusahaan='$id'";
                    $result = mysqli_query($connect,$query);
                    $arr ="";
                    while ($row = mysqli_fetch_array($result)) {
                        # code...
                        $arr =  $row['nama_pt'];
                    }
                    return $arr;
                }
            ?>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Form Edit CO</h5>
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
                                <div class="form_header">
                                    <?php while ($item = mysqli_fetch_array($result_header)) : ?>
                                    <form id="formHeader">
                                        <div class="row">
                                            <input type="hidden" id="sales" name="sales" value="<?= $item['sales']?>">
                                            <input type="hidden" id="noso" name="noso" value="<?= $item['noso']?>">
                                            <input type="hidden" id="idpt" name="idpt"
                                                value="<?= $item['id_perusahaan']?>">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">No CO</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"
                                                            id="basic-addon1"><?= substr($item['No_Co'],0,3); ?></span>
                                                        <input type="text" class="form-control" id="" name=""
                                                            value="<?php echo substr($item['No_Co'],4); ?>" disabled>
                                                        <input type="hidden" id="nsco" name="nsco"
                                                            value="<?= $item['No_Co']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Nama Customer</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-address-book"></i></span>
                                                        <input type="text" name="customer" id="customer"
                                                            class="form-control"
                                                            value="<?php echo $item['customer_nama'] ?>" >
                                                        <input type="hidden" name="idcust" id="idcust"
                                                            class="form-control"
                                                            value="<?php echo $item['customer_id'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">No FPP</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-stack-exchange"></i>
                                                        </span>
                                                        <input type="text" class="form-control idFPP" name="idFpp"
                                                            id="idFPP" value="<?= $item['fpp_id']?>" placeholder="No. FPP / Alasan Revisi">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Order Send</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        <input type="date" class="form-control" name="tglkrm"
                                                            id="tglkrm" value="<?php echo $item['tgl_krm']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Invoice Date</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        <input type="date" class="form-control" name="tglinv"
                                                            id="tglinv" value="<?php echo $item['tgl_inv']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Ongkos Kirim</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp. </span>
                                                        <input type="text" name="ongkir" id="ongkir"
                                                            class="form-control" value="<?php echo $item['ongkir']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Must Approval by<sup style="color:red">*</sup></label>
                                                    <select name="appby" id="appby" class="form-control appby">
                                                        <option value="<?= $item['ttd_by'] ?>"><?= $item['ttd_by'] ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-normal">Alamat Kirim</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-location-arrow"></i></span>
                                                        <textarea class="form-control" name="alamat"
                                                            id="alamat" style="height:80px"><?php echo $item['alamat_krm'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Form Detail Pesanan</h5>
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
                                <div class="main_form">
                                    <?php $no=0;while ($detail_item = mysqli_fetch_array($result)) :$no++;?>
                                    <form id="form<?=$no?>">
                                        <table class="" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th width="15%">Qty</th>
                                                    <th width="15%">Harga</th>
                                                    <th width="15%">Amount</th>
                                                    <th width="10%">Disc</th>
                                                    <th width="5%">PPN</th>
                                                    <th width="15%">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td>
                                                    <input type="hidden" id="itemid<?=$no?>" name="itemid"
                                                        value="<?=$detail_item['id']?>">
                                                    <input type="text" class="form-control" name="sku" id="sku<?=$no?>"
                                                        value="<?php echo $detail_item['model']; ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="hidden" id="qty_save<?=$no?>" name="qty_save"
                                                        class="form-control"
                                                        value="<?php echo $detail_item['qty_kirim']; ?>">
                                                    <input type="text" id="qty<?=$no?>" name="qty" class="form-control"
                                                        value="<?php echo $detail_item['qty_kirim']; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="harga" id="harga<?=$no?>"
                                                        class="form-control"
                                                        value="<?php echo $detail_item['price']; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" id="amt<?=$no?>" name="amt" class="form-control"
                                                        value="<?php echo $detail_item['amount']; ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="hidden" id="diss<?= $no ?>" value="<?= $detail_item['diskon'] ?>">
                                                    <input type="text" id="disc<?=$no?>" name="disc"
                                                        class="form-control"
                                                        value="<?php echo $detail_item['diskon']; ?>">
                                                </td>
                                                <td>
                                                    <input type="checkbox" id="ppn<?=$no?>" name="ppn" value="10"
                                                        <?php if($detail_item['ppn'] != "0"): echo "checked"; endif;?>>
                                                    <input type="hidden" name="hitungan_ppn" id="hitungan_ppn<?=$no?>"
                                                        value="<?php echo $detail_item['ppn']; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" id="ttl<?=$no?>" name="ttl" class="form-control"
                                                        value="<?php echo $detail_item['harga_total'];?>" readonly>
                                                </td>
                                            </tbody>
                                        </table>
                                    </form>
                                    <?php endwhile; ?>
                                </div>
                                <input type="hidden" name="total_row" id="total_row" value="<?=$total_row?>">
                            </div>
                            <div class="ibox-footer">
                                <?php if ($data['level'] == 'admin' || $data['level'] == 'superadmin') : ?>
                                <button class="btn btn-success simpan"><span class="fa fa-save (alias)"></span>
                                    Simpan
                                </button>
                                <?php endif; ?>
                                <button class="btn btn-warning back"><span class="fa fa-arrow-circle-left"></span>
                                    Kembali
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script src="../assets/js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
            $('.appby').select2({
                placeholder: 'Pilih: Nama User | Company',
                allowClear: true,
                ajax: {
                    url: 'modal/data_admin.php',
                    type: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchNama: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        // console.log(response);
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });
    $(document).ready(function() {
        $.get('modal/listfpp.php', function(data) {
            console.log(data);
            $("#idFPP").typeahead({
                source: data
            });
        }, 'json');
        var value = $('#total_row').val();
        for (let i = 0; i <= value; i++) {
            $("#harga" + i).keyup(function() {
                var qty_brg = $("#qty" + i).val();
                var nmn_disc = $("#disc" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;

                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11/100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amt" + i).val(amount);
                $("#ttl" + i).val(hasil);
                $("#disc" + i).val(discount);
            });
            $("#disc" + i).keyup(function() {
                var qty_brg = $("#qty" + i).val();
                var nmn_disc = $("#disc" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;
                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amt" + i).val(amount);
                $("#ttl" + i).val(hasil);
                $("#disc" + i).val(discount);
            });
            $("#qty" + i).keyup(function() {
                var qty_brg = $("#qty" + i).val();
                var qty_awal = $("#qty_save" + i).val();
                var dis_awal = $("#diss" + i).val();
                var nmn_disc = $("#disc" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;
                disskon = (dis_awal / qty_awal) * qty_brg;
                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = disskon;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = disskon;

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amt" + i).val(amount);
                $("#ttl" + i).val(hasil);
                $("#disc" + i).val(discount);
            });
            $("#ppn" + i).click(function() {
                var qty_brg = $("#qty" + i).val();
                var nmn_disc = $("#disc" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;
                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amt" + i).val(amount);
                $("#ttl" + i).val(hasil);
                $("#disc" + i).val(discount);
            });
        }
        $(".simpan").click(() => {
            var formHeader = $("#formHeader").serializeArray();
            // console.log(formHeader);
            var nsco = $('#nsco').val();
            var customer = $('#idcust').val();
            var tgl = $('#tglkrm').val();
            var tglinv = $('#tglinv').val();;
            var alamat_kirim = $('#alamat').val();
            var fpp = $('#idFPP').val();
            var appby = $('#appby').val();
            if (nsco == '' || customer == '' || tgl == '' || tglinv == '' || alamat_kirim == '' || appby == '') {
                swal.fire(
                    'Gagal',
                    'Periksa Form Header',
                    'warning'
                );
            } else {
                $.ajax({
                    method: "POST",
                    url: "orderfix_hdr.php",
                    data: formHeader,
                    success: function(data) {
                        console.log(data);
                        var revs = data;
                        for (var i = 1; i <= value; i++) {
                            event.preventDefault();
                            // console.log(revs);
                            var NoCo = $('#nsco').val();
                            var noso = $('#noso').val();
                            var form = $('#form' + (i)).serializeArray();
                            // console.log(form);
                            form.push({
                                name: "NoCo",
                                value: NoCo
                            });
                            form.push({
                                name: "revs",
                                value: revs
                            });
                            form.push({
                                name: "noso",
                                value: noso
                            });
                            form.push({
                                name: "urt",
                                value: i
                            });
                            $.ajax({
                                method: "POST",
                                url: "orderfix_dtl.php",
                                data: form,
                                success: function(data) {
                                    console.log(data);
                                    var infox = data;

                                    if (infox == 'SISA') {
                                        $.ajax({
                                            method: "POST",
                                            url: "modal/createpending.php",
                                            data: formHeader,
                                            success: function(data) {

                                            }
                                        })
                                    }
                                }
                            });
                        }
                        swal.fire(
                            'Good Job',
                            'Update Berhasil!',
                            'success'
                        );
                        setTimeout(function() {
                                // your code to be executed after 1 second
                                location.assign(
                                    "orderfix.php");
                            },
                            2000);
                    }
                });
            }
        });
    });
    </script>
    <script>
    $(".back").click(function() {
        window.history.back();
    });
    $(document).ready(function() {
        document.getElementById('datafix').setAttribute('class', 'active');
    });
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: 'modal/getQtysco_in.php',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var reslt = data;
                    $('#sqty').html(reslt.dataun);
                    $('#sqlqty').html(reslt.dataun);
                }
            });
        }, 1000);
    });
    </script>
</body>

</html>