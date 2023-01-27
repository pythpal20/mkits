<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu'])){
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
                    <h2>Status SCO</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Status SCO</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <a href="masterpending.php" class="btn btn-xs btn-warning"><span class="fa fa-cogs"></span>|
                            Info SCO Pending</a>
                        <?php if($data['modul'] == '2' || $data['modul'] == '1') { ?>
                        <?php if($data['level'] == 'superadmin' || $data['level'] == 'admin') { ?>
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-xs exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data CO</button>
                        <button type="button" name="exptlaporan" id="exptlaporan" class="btn btn-info btn-xs exptlaporan"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Laporan</button>
                            
                        <!--<button type="button" name="exprt" id="expert"-->
                        <!--    class="btn btn-primary btn-xs fullexport float-right"><span-->
                        <!--        class="fa fa-cloud-download"></span> | Full Export Data</button>-->
                        <?php } ?>
                        
                        <!-- agil -->
                        <?php if($data['level'] == 'superadmin' || $data['level'] == 'admin') { ?>
                        <button class="btn btn-xs btn-secondary modalExport"><span class="fa fa-cloud-download"></span>
                            Export Delivery</button>
                        <?php } ?>
                        <!-- agil -->
                        
                        <?php } ?>
                    </div>
                    <div class="col-sm-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data status Proses/ Unpreses SCO</h5>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="TableStatus" width="100%">
                                        <thead scoop="row">
                                            <tr>
                                                <th style="vertical-align: bottom;" rowspan="2">#</th>
                                                <th style="vertical-align: bottom;" rowspan="2" data-priority="1">No. SCO</th>
                                                <th style="vertical-align: bottom;" rowspan="2">Customer</th>
                                                <th style="vertical-align: bottom;" rowspan="2">Sales</th>
                                                <th style="vertical-align: bottom;" rowspan="2" data-priority="2">Tgl. Order</th>
                                                <th style="vertical-align: bottom;" rowspan="2">PT.</th>
                                                <th colspan="3">Status</th>
                                                <th style="vertical-align: bottom;" rowspan="2" data-priority="3">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th>SCO</th>
                                                <th>AK</th>
                                                <th>ADM</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="ibox-footer">
                                <table class="table-borderless" width="100%">
                                    <tr>
                                        <td colspan="4">NOTE:</td>
                                    </tr>
                                    <tr>
                                        <td>#1</td>
                                        <td class="table-info"><i class="fa fa-refresh"></i> = UNPROCESS</td>
                                        <td class="table-primary"><i class="fa fa-check"></i> = PROCESSED</td>
                                        <td class="table-warning"><i class="fa fa-info-circle"></i> = PENDING</td>
                                        <td class="table-danger"><i class="fa fa-times-circle"></i> = CANCEL</td>
                                    </tr>
                                    <tr>
                                        <td>#2</td>
                                        <td colspan="4">Icon pending dan cancel pada kolom AK bisa diklik untuk view
                                            Feedback</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="level" value="<?php echo $data['level'];?>">
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        var lvl = $('#level').val();
        // if (lvl != 'sales') {
            var table = $('#TableStatus').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/TableStatus.php?kategori; ?>",
                columnDefs: [{
                    "targets":6,
                    "render":function(data, row){
                        if(data === '1'){
                            return '<i class="fa fa-check" rel="tooltip" title="PROCESSED"></i>';
                        }else if(data === '2') {
                            return '<a class="cancelsco"><i class="fa fa-times-circle"></i></a>';
                        }else if(data === '0') {
                            return '<i class="fa fa-recycle" rel="tooltip" title="UNPROCESS"></i>';
                        }
                    }
                },{
                    "targets": 7,
                    "render": function(data, row) {
                        if (data === '0') {
                            return '<i class="fa fa-refresh" rel="tooltip" title="UNPROCESS"></i>';
                        } else if (data === '1') {
                            return '<i class="fa fa-check" rel="tooltip" title="PROCESSED"></i>';
                        } else if (data === '2') {
                            return '<a class="pending" rel="tooltip" title="Pending"><i class="fa fa-info-circle"></i></a>';
                        } else {
                            return '<a class="cancel" rel="tooltip" title="Cancel"><i class="fa fa-times-circle"></i></a>';
                        }
                    }
                }, {
                    "targets": 8,
                    "render": function(data, row) {
                        if (data === '0') {
                            return '<i class="fa fa-refresh" rel="tooltip" title="UNPROCESS"></i>';
                        } else if (data === '1') {
                            return '<i class="fa fa-check" rel="tooltip" title="PROCESSED"></i>';
                        } else if (data === '2') {
                            return '<i class="fa fa-info-circle" rel="tooltip" title="Pending"></i>';
                        }
                    }
                }, {
                    "targets": 9,
                    "render": function(data, row) {
                        if (data === '1|1') {
                            return '<button class="btn btn-xs btn-info view_data"><span class="fa fa-eye"></span></button>'
                        } else {
                            return '<button class="btn btn-xs btn-warning disabled"><span class="fa fa-eye"></span></button>'
                        }
                    }
                }]
            });
        // } else {

        // }
        table.on('draw.dt', function() { //penomoran pada tabel
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#TableStatus tbody').on('click', '.pending', function() { //view detail di modal show
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            var sts = '2';
            $.ajax({
                url: "modal/infoSco.php",
                method: "POST",
                data: {
                    id: id,
                    sts: sts
                },
                success: function(data) {
                    console.log(data);
                    $('#DataModal').html(data);
                    $('#ViewModal').modal('show');

                }
            });
        });

        $('#TableStatus tbody').on('click', '.view_data', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/viewco.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#TModal').html(data);
                    $('#IModal').modal('show');
                }
            });
        });
        
        $('#TableStatus tbody').on('click', '.cancelsco', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/viewsco_cancel.php",
                method: "POST",
                data: {
                    id: id
                },
                success: (data) => {
                        console.log(data);
                        swal.fire({
                            title: data.split("|")[0],
                            icon: 'info',
                            html: 'Cancel by : ' + data.split("|")[1],
                            showClass: {
                                popup: 'animate__animated animate__shakeX'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }

                        });
                        // $('#DataModal').html(data);
                        // $('#ViewModal').modal('show');
                    }
            });
        });
        
    });
    </script>
    <script>
    $(document).ready(function() {
        document.getElementById('status_sco').setAttribute('class', 'active');

        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
        $('.fullexport').click(function() {
            $('#ModalExprt').modal('show');
        });
    });
    </script>
    <div id="IModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">DETAIL ORDER</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="TModal">

                </div>
            </div>
        </div>
    </div>
    <div id="ViewModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">FEEDBACK</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="DataModal">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data CO</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih rentang waktu</h5>
                    <form method="POST" action="export/exportco.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tglawal" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tglakhir" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <select name="perusahaan" id="perusahaan" class="form-control">
                                        <option value="">ALL</option>
                                        <option value="1">Multi Wahana Kencana</option>
                                        <option value="2">Multi Wahana Makmur</option>
                                        <option value="3">Batavia Adimarga Kencana</option>
                                        <option value="4">Dewata Titian Mas</option>
                                        <option value="5">Food Container Indonesia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button id="simpan" type="submit" class="btn btn-success pull-right"><span
                                        class="fa fa-cloud-download"></span> Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
     <!-- agil -->
    <!-- modal -->
    <div class="modal inmodal fade" id="modalExport" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Export Data Delivery</h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body" id="detailModalExport">
                    <form target="_blank" action="exportExcelDelivery.php" method="post">
                        <div class="form-group" id="data_5">
                            <label class="font-normal">Range select</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control" name="start"
                                    value="<?=date("m/d/Y")?>">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" name="end"
                                    value="<?=date("m/d/Y")?>">
                                <button class="btn btn-primary btn-sm export">export</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss='modal'>close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- export laporan -->
    <div class="modal fade" id="ModalExprtlaporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Laporan</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih rentang waktu SCO</h5>
                    <form method="POST" action="export/export_laporan_all.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tglawal" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tglakhir" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button id="simpan" type="submit" class="btn btn-success pull-right"><span
                                        class="fa fa-cloud-download"></span> Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- agil -->
    
    <div class="modal fade" id="ModalExprt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data CO</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih rentang waktu tanggal order</h5>
                    <form method="POST" action="export/laporansm.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tglawal" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tglakhir" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <select name="perusahaan" id="perusahaan" class="form-control">
                                        <option value="">ALL</option>
                                        <option value="1">Multi Wahana Kencana</option>
                                        <option value="2">Multi Wahana Makmur</option>
                                        <option value="3">Batavia Adimarga Kencana</option>
                                        <option value="4">Dewata Titian Mas</option>
                                        <option value="5">Food Container Indonesia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button id="simpan" type="submit" class="btn btn-success pull-right"><span
                                        class="fa fa-cloud-download"></span> Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


<!-- agil -->
<script>
$(document).ready(function() {
    $('.modalExport').click(function() {
        $("#modalExport").modal("show");
    });

    $('.export').click(function() {
        $("#modalExport").modal("hide");
    });
    
    $('.exptlaporan').click(function() {
            $('#ModalExprtlaporan').modal('show');
        });

    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
});
</script>
<!-- agil -->