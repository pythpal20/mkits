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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
                        <li class="breadcrumb-item active">
                            <strong>Master Promo</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- line of content -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin') { ?>
                    <div class="col-lg-12 m-b-xs">
                        <div class="btn-group pull-right">
                            <button class="btn btn-success float-md-right" id="downloadData" data-toggle="tooltip" title="Download Data"><span class="fa fa-download"></span></button>
                            <a class="btn btn-info" id="InsertNew" href="NewPromo.php" title="Tambah Data Promo" data-toggle="tooltip"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Tabel Promo</h5>
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
                                <table class="table table-borderless display" id="tablePromo" width="100%" style="border: 1px solid blue; border-collapse: collapse">
                                    <thead>
                                        <tr class="table-danger">
                                            <th>No.</th>
                                            <th>Code</th>
                                            <th>Promo Name</th>
                                            <th>Num Of SKU</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <th>Create By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <div id="modalPromo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Detail Promo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="dataPromo">

                </div>
            </div>
        </div>
    </div>
    
    <div id="DownloadData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportData">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Download Data Promo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="data_5">
                        <label class="font-normal">Pilih Rentang Waktu</label>
                        <form action="export/exp_promo.php" method="post" target="_blank">
                            <div class="input-daterange input-group" id="datepicker">
                                <!-- from export excel -->
                                <input type="text" class="form-control-sm form-control" name="start" id="start" value="<?= date("m/d/Y") ?>" autocomplete="off">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control-sm form-control" name="end" id="end" value="<?= date("m/d/Y") ?>" autocomplete="off">
                            </div>
                            <hr>
                            <div class="btn-group m-b-xs">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Download</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script src="DataScript/promo_datatables.js"></script>
    <script>
        $(document).ready(function() {
            document.getElementById('bundlePromotion').setAttribute('class', 'active');
            
            $("#downloadData").click(() => {
                $("#DownloadData").modal('show');

                $('#data_5 .input-daterange').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
            });

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            });

            swal.fire({
                title: 'INFO',
                text: 'Fitur Ini Sudah Bisa digunakan, Yossh...!',
                icon: 'info',
                confirmButtonText: 'Baiklah :)',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__rollOut'
                }
            });
        });
    </script>
</body>

</html>