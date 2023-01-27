<?php
    include '../config/connection.php';
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) && ($akses !== '1' || $akses == '3')){
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
                    <h2>Form Kunjungan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="tempcustomer.php">Temp Customer</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Form & Data Kunjungan</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Kunjungan Sales</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link back">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <form method="POST" id="insert_form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nama Customer</label>
                                                <select id="customer" class="form-control chosen-select-karyawan"
                                                    name="customer" data-placeholder="Pilih Customer ..." tabindex="2"
                                                    required>
                                                    <option value="">--Pilih--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="pic">PIC</label>
                                                <input type="text" id="pic" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="Kontak">Kontak</label>
                                                <input type="text" id="kontak" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Jenis Followup</label>
                                                <select name="jenis" id="jenis" class="form-control selectjenis"
                                                    required="">
                                                    <option value="">= Pilih Jenis Followup =</option>
                                                    <option value="kunjungan">Kunjungan</option>
                                                    <option value="telepon">Telp.</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="data_1">
                                                <label>Tanggal Kunjungan</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i
                                                            class="fa fa-calendar"></i></span><input type="text"
                                                        name="tglkunjungan" id="tglkunjungan" class="form-control"
                                                        required placeholder="mm/dd/yyyy">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Sales</label>
                                                <select name="salest" id="salest" class="form-control">
                                                    <option value="">= Pilih Sales =</option>
                                                    <?php
                                                        $sql = "SELECT * FROM master_user WHERE level = 'sales'";
                                                        $mwk = $db1->prepare($sql);
                                                        $mwk -> execute();
                                                        $hasil = $mwk->get_result();
                                                        while ($usr = $hasil->fetch_assoc()) {
                                                            echo '<option value='. $usr["user_id"] .'>'.$usr['user_id'] . ' - '.$usr['user_nama'] .'</option>';
                                                            // var_dump($usr['namasales']);
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Hasil Followup</label>
                                                <select name="ket" id="ket" class="form-control" required>
                                                    <option value="">= Pilih =</option>
                                                    <option value="PO">PO</option>
                                                    <option value="PENAWARAN">Penawaran</option>
                                                    <option value="REGULER">Reguler</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea style="height: 85px;" class="form-control" id="alamat"
                                                    disabled></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea class="form-control" style="height: 75px;" name="deskripsi"
                                                    id="deskripsi" placeholder="Tulis keterangan . . ."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="penginput" id="penginput"
                                        value="<?= $data['user_nama']?>">
                                    <button class="btn btn-success simpan"><span class="fa fa-save (alias)"></span>
                                        Simpan</button>
                                </form>
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
    <?php include 'template/load_js.php'; ?>
    <script src="../assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="../assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('mastercustomer').setAttribute('class', 'active');
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });

        $('#salest').select2();

        var mem = $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        var yearsAgo = new Date();
        yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

        $("#customer").select2({
            ajax: {
                url: "modal/ambilCustomer.php",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        
        $('#customer').change(function() {
            var idcust = $("#customer").val();
            $.ajax({
                url: 'modal/infoCustomer.php',
                method: 'post',
                dataType: 'json',
                data: {
                    idcust: idcust
                },
                success: function(data) {
                    // console.log(data);
                    var reslt = data;
                    $('#alamat').val(reslt.alamat);
                    $('#pic').val(reslt.pic);
                    $('#kontak').val(reslt.kontak);
                }
            });
        });

        $('#insert_form').on("submit", function(event) {
            event.preventDefault();
            // var formatas = $('#insert_form').serializeArray();
            // console.log(formatas);
            $.ajax({
                url: "modal/addkunjungan.php",
                method: "POST",
                data: $('#insert_form').serialize(),
                beforeSend: function() {
                    $('#insert').modal("show");
                },
                success: function(data) {
                    // console.log(data);
                    $('#insert').modal("hide");
                    Swal.fire(
                        'Good Job!',
                        'Berhasil Menyimpan Data',
                        'success');
                    setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "formkunjungan.php");
                        },
                        3000);
                }
            });
        });
    });
    </script>
</body>
<div class="modal inmodal" id="insert" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-body">
                <label>Menyimpan Data . . .</label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-info"
                        style="width: 100%" role="progressbar" aria-valuenow="100%" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</html>