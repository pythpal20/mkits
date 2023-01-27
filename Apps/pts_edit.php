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
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <div class="row border-bottom white-bg page-heading">
                <!-- || -->
                <div class="col-lg-10">
                    <h2>Data Request Pick Ticket Sample</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="datasample.php">Request Sample</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit PTS</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $idPts = $_GET['id'];
                include '../config/connection.php';
                $query = "SELECT * FROM pts_detail WHERE idPts='".$_GET['id']."'";
                $header =  "SELECT * FROM pts_header WHERE idPts='".$_GET['id']."'";

                $result = mysqli_query($connect,$query);
                $result_header = mysqli_query($connect,$header);

                $total_row = mysqli_num_rows($result);
            ?>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form permintaan Sample</h5>
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
                                    <?php while ($hdr = mysqli_fetch_array($result_header)) : ?>
                                    <form id="formHeader">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Sales</label>
                                                    <input name="idPts" id="idPts" type="hidden" value="<?=$idPts?>">
                                                    <input type="text" name="sales" id="sales" class="form-control"
                                                        value="<?php echo $hdr['sales']; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="font-normal">Nama Customer</label>
                                                    <input type="text" class="form-control customer" name="customer"
                                                        id="customer" value="<?=$hdr['customer_nama'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tanggal Diambil</label>
                                                    <input type="date" id="tglambil" name="tglambil"
                                                        class="form-control" value="<?=$hdr['tgl_ambil'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="font-normal">Status Sample</label>
                                                    <select id="stsample" name="stsample" class="form-control" required>
                                                        <option value="<?=$hdr['status']?>">
                                                            <?php if($hdr['status'] == '1') { echo "Kembali";} elseif($hdr['status'] == '2'){echo "Tidak Kembali";} else { echo "Dibeli";} ?>
                                                        </option>
                                                        <option value="1">Kembali</option>
                                                        <option value="2">Tidak Kembali</option>
                                                        <option value="3">Dibeli </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" id="kembali">
                                                <div class="form-group">
                                                    <label>Tanggal Kembali</label>
                                                    <input type="date" name="tglkembali" id="tglkembali"
                                                        class="form-control" value="<?=$hdr['tgl_kembali']?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-5" id="dibeli">
                                                <div class="form-group">
                                                    <label>Ket. Pembelian</label>
                                                    <textarea name="ketbeli" id="ketbeli"
                                                        class="form-control"><?=$hdr['keterangan_beli']?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" id="dibeli">
                                                <div class="form-group">
                                                    <label>Kota</label>
                                                    <input type="text" id="kota" name="kota" class="form-control"
                                                        value="<?=$hdr['kota']?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="font-normal">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat"
                                                        style="height: 75px;" readonly><?=$hdr['alamat']?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="font-normal">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" id="keterang"
                                                        style="height: 75px;"><?=$hdr['keterangan']?></textarea>
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
                        <div class="ibox ">
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
                                <?php $no=0;while ($dtm = mysqli_fetch_array($result)) :$no++;?>
                                <div class="main_form">
                                    <form id="form<?=$no?>">
                                        <div class="table-responsive">
                                            <table class="table table-hovered" width="100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>SKU</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>amount</th>
                                                        <th>Ket</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input name="idPts" type="hidden" value="<?=$idPts?>">
                                                    <input type="hidden" name="iditem" id="iditem<?=$no?>"
                                                        value="<?php echo $dtm['id']; ?>">
                                                    <tr>
                                                        <td width="200px">
                                                            <select name="sku" id="sku<?=$no?>"
                                                                class="form-control chosen-select-sku pilih">
                                                                <option value="<?=$dtm['model']?>">
                                                                    <?=$dtm['model']?>
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td width="85px">
                                                            <input type="text" class="form-control" placeholder="Qty"
                                                                name="qty" id="qty<?=$no?>" value="<?=$dtm['qty']?>" />
                                                        </td>
                                                        <td width="150px">
                                                            <input type="text" class="form-control" placeholder="Harga"
                                                                name="harga" id="harga<?=$no?>"
                                                                value="<?=$dtm['harga']?>" />
                                                        </td>
                                                        <td width="150px">
                                                            <input type="text" class="form-control" placeholder="amount"
                                                                name="amount" id="amount<?=$no?>"
                                                                value="<?=$dtm['amount']?>" readonly />
                                                        </td>
                                                        <td width="120px">
                                                            <input type="text" name="ket" class="form-control"
                                                                placeholder="keterangan" id="ket<?=$no?>"
                                                                value="<?=$dtm['ket']?>">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <?php endwhile; ?>
                                <input type="hidden" name="total_row" id="total_row" value="<?=$total_row?>">
                                <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin'): ?>
                                <button class="btn btn-success float-right simpan"><span
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
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('samplerequest').setAttribute('class', 'active');
    });
    $(".back").click(function() {
        window.history.back();
    });
    </script>
    <script>
    var value = $('#total_row').val();
    $('.chosen-select-sku').select2({
        ajax: {
            url: 'modal/getSku.php',
            type: 'post',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchSku: params.term // search term
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
    for (let i = 0; i <= value; i++) {
        $("#harga" + i).keyup(function() {
            var qty_brg = $("#qty" + i).val();
            var harga_brg = $("#harga" + i).val();

            amount = harga_brg * qty_brg;
            $('#amount' + i).val(amount);
        });
        $("#qty" + i).keyup(function() {
            var qty_brg = $("#qty" + i).val();
            var harga_brg = $("#harga" + i).val();

            amount = harga_brg * qty_brg;
            $('#amount' + i).val(amount);
        });
    }
    $(".simpan").click(() => {
        var formHeader = $("#formHeader").serializeArray();
        // console.log(formHeader);
        var idPts = $('#idPts').val();
        var customer = $('#customer').val();
        var tglambil = $('#tglambil').val();
        var sales = $('#sales').val();
        var stsample = $('#stsample').val();
        var kota = $('#kota').val();
        var alamat = $('#alamat').val();
        if (customer == '' || tglambil == '' || sales == '' || stsample == '' || kota == '' ||
            alamat == '') {
            swal.fire(
                'Gagal!',
                'Lengkapi Form Header',
                'warning'
            );
        } else {
            $.ajax({
                method: "POST",
                url: "modal/ptsupdate_header.php",
                data: formHeader,
                success: function(data) {
                    //console.log(data);
                }
            });
            for (var i = 1; i <= value; i++) {
                event.preventDefault();
                var form = $('#form' + (i)).serializeArray();
                $.ajax({
                    method: "POST",
                    url: "modal/ptsupdate_detail.php",
                    data: form,
                    success: function(data) {
                        // console.log(data);
                    }
                });
            }
            swal.fire(
                'Good Job',
                'Update Berhasil!',
                'success'
            );
            var url =
                'https://api.telegram.org/bot5042604357:AAGe8tnjQG0Zb9c8dsSwivXuviNNXd9MvvE/sendMessage';
            var chat_id = ["-759758736", "-1001762497140", "-1001688464072"];
            var text = "Request Sample dari :  <i>" + customer +
                "</i>\n" +
                "No. PTS : <i><b>" + idPts + "</b></i>\n" +
                "Diajukan oleh : <i>" + sales + "</i>\n" +
                "Tanggal diambil : <b>" + tglambil + "</b>";
            for (let index = 0; index < chat_id.length; index++) {
                const element = chat_id[index];
                // console.log(element);
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        chat_id: element,
                        parse_mode: 'html',
                        text: text
                    }
                });
            }
            setTimeout(function() {
                    // your code to be executed after 1 second
                    location.assign(
                        "datasample.php");
                },
                2000);
        }
    });
    </script>
</body>

</html>