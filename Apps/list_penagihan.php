<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls']; 
    if (isset($_SESSION['usernameu']) || $akses == '2' ){
        
    }else
    {
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
    <style>
    .swal2-popup {
        font-size: 0.7rem !important;
        font-family: Georgia, serif;
        text-align: center;
    }
    </style>
</head>

<body>
    <div id="wrapper">
        <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
        <input type="hidden" name="namauser" id="namauser" value="<?php echo $data['user_nama']; ?>">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Penagihan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Penagihan</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>List FA</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> List FA</h5>
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
                                    <div class="col-12">
                                        <button class="btn btn-primary pull-right exportBtn">
                                            <i class="fa fa-file-excel-o"></i> export
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-hover display" id="example" width="100%">
                                        <thead class="table-info">
                                            <tr>
                                                <!-- <th class="text-center"> No </th> -->
                                                <th class="text-center" > Tanggal FA </th>
                                                <th class="text-center"> No FA </th>
                                                <th class="text-center"> No SO </th>
                                                <th class="text-center">
                                                    Customer
                                                <th class="text-center" > Sales
                                                <th class="text-center" data-priority="8" >
                                                    Nominal FA Awal
                                                </th>
                                                <th class="text-center" data-priority="7">Nominal Konfirmasi </th>
                                                <!-- <th class="text-center">NO FA Akhir </th> -->
                                                <th class="text-center" data-priority="6">tgl Kontrabon </th>
                                                <th class="text-center" data-priority="5">tgl Duedate </th>
                                                <th class="text-center" data-priority="4">Overdue </th>
                                                <th class="text-center" data-priority="3">Total Bayar </th>
                                                <th class="text-center" data-priority="2">Selisih </th>
                                                <th class="text-center" data-priority="1">Aksi </th>
                                                <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
                                            </tr>
                                        </thead>
                                    </table>
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

    <!-- modal export -->
    <div class="modal inmodal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Export Penagihan</h4>
                </div>
                <div class="modal-body" id="">
                    <div class="form-group" id="data_5">
                        <label class="font-normal">Range select</label>
                        <form action="exportPenagihan.php" method="post" target="_blank">
                            <div class="input-daterange input-group" id="datepicker">
                                <!-- from export excel -->
                                <input type="text" class="form-control-sm form-control" name="start" id="start"
                                    value="<?=date("m/d/Y")?>">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" name="end" id="end"
                                    value="<?=date("m/d/Y")?>">
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn-group btn btn-primary ">Download</button>
                    </form>
                    <!--akhir from export excel -->
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <?php include 'template/load_js.php';?>
    <script>
    $(document).ready(function() {
        var table = $("#example").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "serverside_agil/serverside_penagihan.php",
            columnDefs: [{
                "targets": 11,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }]
        });

        $('.exportBtn').click(function() {
            $('#exportModal').modal("show");
        });
        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

    });
    </script>