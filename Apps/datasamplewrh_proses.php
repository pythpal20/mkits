<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '4'){
        header("Location: ../index.php");
    }
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc(); 

    $ptsID = $_GET['id'];
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
                    <h2>Konfirmasi RPT aktual</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="datasamplewrh.php">Pengajuan Sample</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Konfirmasi Aktual</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                //show all data from data pts header
                $query_hdr = "SELECT * FROM pts_header WHERE idPts = '$ptsID'";
                $mwk = $db1->prepare($query_hdr);
                $mwk -> execute();
                $resl_hdr = $mwk->get_result();
                $hdr = $resl_hdr->fetch_assoc();
                //shwo all data from data pts detail 
                $query_dtl = "SELECT * FROM pts_detail WHERE idPts = '$ptsID'";
                $resl_dtl = mysqli_query($connect,$query_dtl);
                $total_row = mysqli_num_rows($resl_dtl);
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Konfirmasi Aktual PTS</h5> <small> <em>Isi aktual SKU dan Qty yang
                                        dikirim</em></small>
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
                                <div class="FormHeader">
                                    <form id="Form_Header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="panel panel-danger">
                                                    <div class="panel-body">
                                                        <table width="100%">
                                                            <tr>
                                                                <th>ID PTS</th>
                                                                <td> : </td>
                                                                <td><?= $ptsID ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tgl. Diajukan</th>
                                                                <td> : </td>
                                                                <td><?= date_format(date_create($hdr['tgl_create']), 'l, d F Y') ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tgl. diambil</th>
                                                                <td> : </td>
                                                                <td><?= date_format(date_create($hdr['tgl_ambil']), 'l, d F Y') ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td> : </td>
                                                                <td>
                                                                    <?php
                                                                        if($hdr['status'] == 1) {
                                                                            echo "Kembali";
                                                                        }elseif ($hdr['status'] == 2){
                                                                            echo "Tidak Kembali";
                                                                        }elseif($hdr['status'] == 3) {
                                                                            echo "Dibeli";
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php if($hdr['status'] == 1) { ?>
                                                            <tr>
                                                                <th>Tgl. Kembali</th>
                                                                <td> : </td>
                                                                <td><?= date_format(date_create($hdr['tgl_kembali']), 'l, d F Y') ?>
                                                                </td>
                                                            </tr>
                                                            <?php } elseif($hdr['status'] == 3) { ?>
                                                            <tr>
                                                                <th>Keterangan Beli</th>
                                                                <td> : </td>
                                                                <td><?= $hdr['keterangan_beli'] ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <th>Keterangan</th>
                                                                <td> : </td>
                                                                <td><?= $hdr['keterangan'] ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="panel panel-danger">
                                                    <div class="panel-body">
                                                        <table width="100%">
                                                            <tr>
                                                                <th>Customer</th>
                                                                <td> : </td>
                                                                <td><?= $hdr['customer_nama'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alamat</th>
                                                                <td> : </td>
                                                                <td><?= $hdr['alamat'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sales</th>
                                                                <td> : </td>
                                                                <td><?= $hdr['sales'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Approval Admin / Finance</th>
                                                                <td> : </td>
                                                                <td><?= date_format(date_create($hdr['tgl_adminapp']), 'd-m-Y') . " / " . date_format(date_create($hdr['tgl_akuntingapp']), 'd-m-Y') ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <input type="hidden" id="wrh" name="wrh" value="<?= $data['user_nama'] ?>">
                                                        <input type="hidden" id="idPTS" name="idPTS" value="<?= $ptsID ?>">
                                                        <input type="hidden" id="cstmr" name="cstmr" value="<?= $hdr['customer_nama'] ?>">
                                                        <input type="hidden" id="jenis" name="jenis" value="<?= $hdr['status'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <?php $no = 0; while($dtl = $resl_dtl->fetch_assoc()) : $no++ ?>
                                <div class="FormDetail">
                                    <form id="form<?= $no ?>">
                                        <table style="width: 100%;" class="">
                                            <tr>
                                                <th>#</th>
                                                <th>SKU</th>
                                                <th>Qty. Request</th>
                                                <th>Qty Aktual</th>
                                                <th>Keterangan</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="item" id="item<?=$no?>"
                                                        class="i-checks" value="<?= $dtl['id']; ?>">
                                                    <input type="hidden" id="idPts" name="idPts"
                                                        value="<?php echo $dtl['idPts']; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="sku" id="sku<?= $no ?>"
                                                        class="form-control" value="<?= $dtl['model']?>" readonly>
                                                </td>
                                                <td width="20%">
                                                    <input type="text" name="jumlah" id="jumlah<?= $no ?>"
                                                        class="form-control" value="<?= $dtl['qty']?>" readonly>
                                                </td>
                                                <td width="20%">
                                                    <input type="text" name="qty" id="qty<?=$no?>" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="ket" id="ket<?= $no ?>"
                                                        class="form-control" value="<?= $dtl['ket'] ?>">
                                                </td>
                                                <input type="hidden" id="hrg<?=$no?>" name="hrg"
                                                    value="<?= $dtl['harga']?>">
                                                <input type="hidden" id="amt<?=$no?>" name="amt"
                                                    value="<?= $dtl['amount']?>">
                                                <input type="hidden" id="amounts<?=$no?>" name="amounts">
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <br>
                                <?php endwhile ?>
                                <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin'): ?>
                                <button class="btn btn-success float-right simpan" disabled="" id="simpan"><span
                                        class="fa fa-save (alias)"></span>
                                    Simpan
                                </button>
                                <?php endif; ?>
                                <button class="btn btn-warning back"><span class="fa fa-arrow-circle-left"></span>
                                    Kembali
                                </button>
                            </div>
                            <div class="ibox-footer">
                                <b>Note*</b> : <em>Silahkan Ceklis Pada SKU yang diproses, apabli SKU tidak ada maka
                                    UNCHECKLIST</em>
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
    <input type=" hidden" name="total_row" id="total_row" value="<?=$total_row?>">
    <?php include 'template/load_js.php'; ?>

    <script>
    $(document).ready(function() {
        document.getElementById('ptsampleakt').setAttribute('class', 'active');
    });
    </script>
    <script>
    $(document).ready(function() {
        $('input[type=checkbox]').on('change', function(evt) {
            var items = $('input[id=item]:checked');
            if (items.length = 0) {
                $('#simpan').prop("disabled", true);
            } else {
                $('#simpan').prop("disabled", false);
            }
        });
        var value = $('#total_row').val();
        for (let i = 0; i <= value; i++) {
            $("#qty" + i).keyup(function() {
                var jlh_barang = $("#qty" + i).val();
                var harga_brg = $("#hrg" + i).val();

                // console.log(jlh_barang);
                // console.log(harga_brg);
                // console.log(amnt);

                amount = harga_brg * jlh_barang;
                // console.log(amount);
                $('#amounts' + i).val(amount);
            });
        }
        $(".simpan").click(() => {
            // console.log(formHeader);
            var formHeader = $("#Form_Header").serializeArray();
            var customer = $('#cstmr').val();
            var idPTS = $('#idPTS').val();
            var wrh = $('#wrh').val();
            $.ajax({
                method: "POST",
                url: "modal/ptsaktual_hdr.php",
                data: formHeader,
                success: function(data) {
                    console.log(data);
                    swal.fire(
                        'GOOD',
                        'Berhasil Update data',
                        'success'
                    );
                }
            });

            for (var i = 1; i <= value; i++) {
                var bool_check = $('#item' + i).is(':checked');
                event.preventDefault();
                var form = $('#form' + (i)).serializeArray();

                if (bool_check) {
                    form.push({
                        name: "norut",
                        value: i
                    });
                    var ket = $('#ket' + i).val();
                    var item = $('#item' + i).val();
                    var qtys = $('#qty' + i).val();
                    var sku = $('#sku' + i).val();
                    var amts = $('#amounts' + i).val();
                    var hrg = $('#hrg' + i).val();
                    if (qtys == '' || amts == '') {
                        swal.fire(
                            'Uppss..!',
                            'Kolom "Qty Aktual" tidak boleh kosong',
                            'warning'
                        );
                    } else {

                        $.ajax({
                            method: "POST",
                            url: "modal/ptsaktual_detail.php",
                            data: form,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    }
                }
            }
            var url =
                'https://api.telegram.org/bot5042604357:AAGe8tnjQG0Zb9c8dsSwivXuviNNXd9MvvE/sendMessage';
            var chat_id = ["-759758736", "-1001762497140", "-1001688464072"];
            var text = "Request Sample dari :  <i>" + customer +
                "</i>\n" +
                "No. PTS : <i><b>" + idPTS + "</b></i>\n" +
                "Diproses Oleh  : <b>" + wrh + "</b> dari Tim Gudang";
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
                        "datasampleaktual.php");
                },
                2500);
        });
    });
    </script>
</body>

</html>