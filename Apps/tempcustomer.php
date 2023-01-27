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
                    <h2>Data Customer</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Temp. Customer</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <?php if ($data['modul'] == '1') { ?>
                        <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin') : ?>
                        <a href="addtempcustomer.php" class="btn btn-sm btn-info"><span
                                class="fa fa-plus-circle"></span>
                            Tambah Customer</a>
                           
                         <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Xls" rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data
                            </button>
                        <?php endif ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>DB Customer</h5>
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
                                <div class="">
                                    <table class="table-bordered display" id="BankDatas" style="width:100%;">
                                        <thead class="table-default">
                                            <tr>
                                                <th>No</th>
                                                <th>Customer</th>
                                                <th>Jenis Usaha</th>
                                                <th>Kota</th>
                                                <th>PIC</th>
                                                <th>Status</th>
                                                <th style="width: 15%;">Aksi</th>
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
    <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
    <?php include 'template/load_js.php'; ?>
    <script src="../assets/js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
    <script>
    $(document).ready(function() {
        document.getElementById('bankData').className = 'active';
    });
    $(document).ready(function() {
        $.get('modal/listnama.php', function(data) {
            // console.log(data);
            $("#namacust").typeahead({
                source: data
            });
        }, 'json');
    });
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        if (lvl == "admin" || lvl == "superadmin") {
            var table = $('#BankDatas').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/BankData.php",
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-info btn-circle btn-xs view_data' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-warning btn-circle btn-xs tblEdit' tooltip='Edit'><span class='fa fa-edit'></span> </button> <button class='btn btn-circle btn-xs btn-info history' rel='tooltip' title='history Kunjungan'><span class='fa fa-exchange '></span></button></center>"
                },{
                    "targets":5,
                    "render":function(data, row){
                        if(data == '0'){
                            return '<span class="label label-warning">Tutup Permanen<span>'
                        }else if(data == '1'){
                            return '<span class="label label-primary">Aktif</span>'
                        }else {
                            return '<span class="label label-warning">Tidak Aktif</span>'
                        }
                    }
                }]
            });
        } else {
            var table = $('#BankDatas').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/BankData.php",
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-info btn-circle btn-xs view_data' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-warning btn-circle btn-xs tblEdit' tooltip='Edit' disabled><span class='fa fa-edit'></span> </button> <button class='btn btn-circle btn-xs btn-info history' rel='tooltip' title='history Kunjungan'><span class='fa fa-exchange '></span></button></center>"
                },{
                    "targets":5,
                    "render":function(data, row){
                        if(data == '0'){
                            return '<span class="label label-warning">Tutup Permanen<span>'
                        }else if(data == '1'){
                            return '<span class="label label-primary">Aktif</span>'
                        }else {
                            return '<span class="label label-warning">Tidak Aktif</span>'
                        }
                    }
                }]
            });
        }
        table.on('draw.dt', function() {
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#BankDatas tbody').on('click', '.view_data', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/tempcust_view.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#viewCust').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#BankDatas tbody').on('click', '.tblEdit', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "tempcustomer_edit.php?id=" + data[0];
        });
        
        $('#BankDatas tbody').on('click', '.history', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "temp_custhistory.php?id=" + data[0];
        });
        $('#expt').click(function() {
            window.location.href = "export/ExportTempcust.php"
        });
    });
    </script>

</body>
<div id="viewDetail" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="viewCust">

            </div>
        </div>
    </div>
</div>
</html>