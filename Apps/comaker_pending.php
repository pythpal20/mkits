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
                    <h2>Create CO/BL/FA/PT</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="scomasuk.php">Data SCO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Create CO</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $id = $_GET['id'];

                $master = "SELECT * FROM salesorder_hdr a
                JOIN master_customer b ON a.customer_id = b.customer_id 
                JOIN list_perusahaan c ON a.id_perusahaan = c.id_perusahaan
                WHERE noso = '$id'";
                $mwk    = $db1->prepare($master);
                $mwk -> execute();
                $hasil = $mwk->get_result();
                $dt = $hasil->fetch_array();

                $query = "SELECT * FROM customerorder_dtl_pending WHERE noso='".$_GET['id']."' ORDER BY no_urut ASC";
                $result = mysqli_query($connect,$query);
                $total_row = mysqli_num_rows($result);
                
                function add_leading_zero($value, $threshold = 4) {
                    return sprintf('K-'.'%0'. $threshold . 's', $value);
                }
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container ">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-send-o (alias)"></span> Detail PO</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2"><span
                                            class="fa fa-send (alias)"></span> Detail Item</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="form_header">
                                            <form id="formHeader">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-normal">No SCO</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon1"><i
                                                                        class="fa fa-shopping-cart"></i></span>
                                                                <input type="text" class="form-control" id="nsco"
                                                                    name="nsco" value="<?php echo $dt['noso']; ?>"
                                                                    readonly>
                                                                <input type="hidden" id="sales" name="sales"
                                                                    value="<?php echo $dt['sales'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-normal">Nama Customer</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-address-book"></i></span>
                                                                <input type="hidden" id="idcustomer" name="idcustomer"
                                                                    value="<?php echo $dt['customer_id']; ?>">
                                                                <input type="text" name="customer" id="customer"
                                                                    class="form-control"
                                                                    value="<?php echo $dt['customer_nama'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="font-normal">Perusahaan</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2"><i
                                                                        class="fa fa-building"></i></span>
                                                                <input type="hidden" name="idpt" id="idpt"
                                                                    value="<?php echo $dt['id_perusahaan']; ?>">
                                                                <input type="text" name="namapt" id="namapt"
                                                                    class="form-control"
                                                                    value="<?php echo $dt['nama_pt']; ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="font-normal">Order Date</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <input type="date" class="form-control" name="tglorder"
                                                                    id="tglorder" value="<?php echo $dt['tgl_po'];?>"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="font-normal">Order Send</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <input type="date" class="form-control" name="tglkrm"
                                                                    id="tglkrm" value="<?php echo $dt['tgl_krm']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="font-normal">Ongkos Kirim</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">Rp. </span>
                                                                <input type="text" name="ongkir" id="ongkir"
                                                                    class="form-control"
                                                                    value="<?php echo $dt['ongkir']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="font-normal">Term.</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                <input type="text" name="termp" id="termp" class="form-control"
                                                                    value="<?php echo $dt['term']; ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="font-normal">Alamat Kirim</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-location-arrow"></i></span>
                                                                <textarea class="form-control" name="alamat"
                                                                    id="alamat"><?php echo $dt['alamat_krm'];?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <?php $no=0;while ($dti = mysqli_fetch_array($result)) :$no++;?>
                                        <form id="form<?=$no?>">
                                            <div class="">
                                                <table class="table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>SKU</th>
                                                            <th>Qty(Sisa)</th>
                                                            <th>Qty(Kirim)</th>
                                                            <th>Harga</th>
                                                            <th>Amount</th>
                                                            <th>Disc</th>
                                                            <th>PPN</th>
                                                            <th>Total</th>
                                                            <th>Locator</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="item" id="item<?=$no?>"
                                                                    value="<?php echo $dti['id']; ?>">
                                                                <input type="hidden" class="form-control" id="nsco"
                                                                    name="nsco" value="<?php echo $dt['noso']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="sku"
                                                                    id="sku<?=$no?>"
                                                                    value="<?php echo $dti['model']; ?>" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="qty<?=$no?>" name="qty"
                                                                    class="form-control"
                                                                    value="<?php echo $dti['qty_sisa']; ?>" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="qtyact<?=$no?>" name="qtyact"
                                                                    class="form-control"
                                                                    value="<?php echo $dti['qty_sisa']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="harga" id="harga<?=$no?>"
                                                                    class="form-control"
                                                                    value="<?php echo $dti['price']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="amt<?=$no?>" name="amt"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="disc<?=$no?>" name="disc"
                                                                    class="form-control"
                                                                    value="<?php echo $dti['diskon']; ?>" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="cek_ppn<?=$no?>"
                                                                    name="cek_ppn" value="11" disabled
                                                                    <?php if($dti['ppn'] != "0"): echo "checked"; endif;?>>
                                                                <input type="hidden" id="ppn<?=$no?>" name="ppn"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="ttl<?=$no?>" name="ttl"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <select id="keepstock<?=$no?>" name="keepstock"
                                                                    class="form-control kps">
                                                                    <option value="">Pilih</option>
                                                                    <?php
                                                                        $sqlkeep = "SELECT no_keepstock, qty_keep FROM keepstock WHERE noso ='" . $_GET['id'] . "' AND model= '" . $dti['model'] . "' AND status_keep = '1'";
                                                                        $mwk = $db1->prepare($sqlkeep);
                                                                        $mwk->execute();
                                                                        $rsl = $mwk->get_result();
                                                                        while ($kps = $rsl->fetch_assoc()){
                                                                            echo '<option value="' . add_leading_zero($kps["no_keepstock"]) . '">' . add_leading_zero($kps["no_keepstock"]) . '|' . $kps["qty_keep"] . ' pcs'.'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                                
                                                                <!--<input type="text" id="keepstock<?=$no?>"-->
                                                                <!--    name="keepstock" class="form-control">-->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                        <?php endwhile; ?>
                                        <em class="text-warning" style="font-size: 0.650;">*Note : Klik dan Enter di
                                            kolom harga/ qty supaya amount dan total terisi</em>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox">
                                <div class="ibox-content">
                                    <button class="btn btn-success simpan" disabled="">
                                        <span class="fa fa-save (alias)"></span>
                                        Simpan
                                    </button>
                                    <button class="btn btn-danger cancel">
                                        <span class="fa fa-window-close"></span>
                                        Cancel CO
                                    </button>
                                    <button class="btn btn-warning back pull-right">
                                        <span class="fa fa-window-close-o"></span>
                                        Kembali
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <input type="hidden" name="total_row" id="total_row" value="<?=$total_row?>">
    <?php include 'template/load_js.php'; ?>
    <script src="../assets/js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });
        $('input[type=checkbox]').on('change', function(evt) {
            var item = $('input[id=item]:checked');
            if (item.length = 0) {
                $('.simpan').prop("disabled", true);
            } else {
                $('.simpan').prop("disabled", false);
            }
        });
        var value = $('#total_row').val();
        for (let i = 0; i <= value; i++) {
            $('#harga' + i).keyup(function() {
                var qty_brg = parseInt($('#qtyact' + i).val());
                var nmn_disc = parseInt($('#disc' + i).val());
                var harga_brg = parseInt($('#harga' + i).val());
                var bool_ppn = $("#cek_ppn" + i).is(':checked');

                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100)
                    hasil = ((qty_brg * harga_brg) - nmn_disc) + harga_ppn;
                } else {
                    amount = qty_brg * harga_brg;
                    harga_ppn = 0;
                    discount = nmn_disc;
                    awal = ((qty_brg * harga_brg) - nmn_disc);
                    hasil = awal + harga_ppn;
                }
                $("#ppn" + i).val(harga_ppn);
                $("#amt" + i).val(amount);
                $("#ttl" + i).val(hasil);
            });

            $("#qtyact" + i).keyup(function() {
                var qty_brg = parseInt($('#qtyact' + i).val());
                var nmn_disc = parseInt($('#disc' + i).val());
                var harga_brg = parseInt($('#harga' + i).val());
                var bool_ppn = $("#cek_ppn" + i).is(':checked');

                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100)
                    hasil = ((qty_brg * harga_brg) - nmn_disc) + harga_ppn;
                } else {
                    amount = qty_brg * harga_brg;
                    harga_ppn = 0;
                    discount = nmn_disc;
                    awal = ((qty_brg * harga_brg) - nmn_disc);
                    hasil = awal + harga_ppn;
                }

                $("#ppn" + i).val(harga_ppn);
                $("#amt" + i).val(amount);
                $("#ttl" + i).val(hasil);
            });
            
            $.get('modal/listkeepstok.php', function(data) {
                // console.log(data);
                $("#keepstock" + i).typeahead({
                    source: data
                });
            }, 'json');
        }
        $(".simpan").click(() => {
            //kirim ke detail
            var formHeader = $("#formHeader").serializeArray();
            // console.log(formHeader);
            var nsco = $('nsco').val();
            var idcustomer = $('idcustomer').val();
            var customer = $('customer').val();
            var idpt = $('idpt').val();
            var tglorder = $('tglorder').val();
            var tglkrm = $('tglkrm').val();
            var ongkir = $('ongkir').val();
            var alamat_krm = $('alamat_krm').val();

            if (nsco == '' || idcustomer == '' || customer == '' || idpt == '' || tglorder == '' ||
                ongkir == '' || alamat_krm == '') {
                swal.fire(
                    'Gagal',
                    'Ada Data yang tidak lengkap!',
                    'warning'
                );
            } else {
                $.ajax({
                    method: "POST",
                    url: "comakerpending_hdr.php",
                    data: formHeader,
                    success: function(data) {
                        console.log(data);
                        IDCo = data;
                        for (var i = 1; i <= value; i++) {
                            event.preventDefault();
                            var form = $('#form' + (i)).serializeArray();
                            form.push({
                                name: "nco",
                                value: IDCo
                            });
                            form.push({
                                name: "no_urut",
                                value: i
                            });
                            $.ajax({
                                method: "POST",
                                url: "comakerpending_dtl.php",
                                data: form,
                                success: function(data) {
                                    console.log(data);
                                    var infox = data;
                                    if (infox == 'SISA') {
                                        $.ajax({
                                            method: "POST",
                                            url: "modal/link_sisa.php",
                                            data: formHeader,
                                            success: function(data) {

                                            }
                                        })
                                    }
                                }
                            });
                        }
                        swal.fire(
                            'Berhasil',
                            'Data Sudah diproses',
                            'success'
                        );
                        setTimeout(function() {
                            location.assign("orderfix.php")
                        }, 2000);
                    }
                });
            }
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        document.getElementById('tabelSco').setAttribute('class', 'active');
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