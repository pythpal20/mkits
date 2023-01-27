<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '2'){
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
        <input type="hidden" id="lvl" value="<?php echo $data['level']; ?>">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Aproval & Cek AR</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Aproval & Check</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $sql1 = "SELECT COUNT(noso) AS unprocessed FROM salesorder_hdr WHERE aproval_finance = '0' AND status ='1'";
                $mwk = $db1->prepare($sql1);
                $mwk -> execute();
                $res1 = $mwk->get_result();
                $row1 = $res1->fetch_assoc();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link active tabse" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-send-o (alias)"></span> Belum Diproses
                                        <?php if($row1['unprocessed'] !== 0) : ?><span
                                            class="label label-info"><?php echo $row1['unprocessed']; ?></span><?php endif; ?></a>
                                </li>
                                <li><a class="nav-link tabso" data-toggle="tab" href="#tab-2"><span
                                            class="fa fa-send (alias)" id="tabso"></span> Diproses</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <?php $uapv = 0; ?>
                                        <div class="row">
                                            <div class="col-sm-12 m-b-xs">
                                                <?php if ($data['modul'] == '2') { ?>
                                                <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin') : ?>
                                                <button type="button" name="expt" id="expt"
                                                    class="btn btn-success btn-sm exportData pull-right"
                                                    title="Export To Csv." rel="tooltip"><span
                                                        class="fa fa-cloud-download"></span> Export
                                                    Data</button>
                                                <?php endif ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="">
                                            <table class="table table-striped" id="tabelUnProses" width="100%">
                                                <thead scoop="row">
                                                    <tr>
                                                        <th style="min-width: 1px;">#</th>
                                                        <th>No. So</th>
                                                        <th>Tgl. Order</th>
                                                        <th data-priority="1">Nama Customer</th>
                                                        <th>PT.</th>
                                                        <th>TERM</th>
                                                        <th>Amount </th>
                                                        <th>Sales</th>
                                                        <th data-priority="2">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <?php $apv = 0; ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="tableProses" width="100%"
                                                style="margin: 0 auto;">
                                                <thead scoop="row">
                                                    <tr>
                                                        <th style="min-width: 1px;">#</th>
                                                        <th>No. So</th>
                                                        <th>Tgl. Order</th>
                                                        <th>Nama Customer</th>
                                                        <th>PT</th>
                                                        <th>TERM</th>
                                                        <th>Status</th>
                                                        <th>Apprv By.</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
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
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    // 1. table unprocess
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var tablen = $('#tabelUnProses').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/getDataUnprocess.php?stat=<?php echo $uapv; ?>",
                columnDefs: [{
                    "targets": 6,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

                }, {
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs aprove' title='Setujui' rel='tooltip'><span class='fa fa-check-square'></span> </button> <button class='btn btn-warning btn-xs pending' title='Pending' rel='tooltip'><span class='fa fa-clock-o'></span></button> <button class='btn btn-danger btn-xs cancel' title='Cancel' rel='tooltip'><span class='fa fa-window-close'></span></button></div></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 3,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        } else {
            var tablen = $('#tabelUnProses').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/getDataUnprocess.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": 6,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-xs btn-warning' disabled>Content Disable</button></div></center>"
                }]
            });

        }

        // Penomoran 
        tablen.on('draw.dt', function() {
            var info = tablen.page.info();
            tablen.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#tabelUnProses tbody').on('click', '.aprove', function() {
            var data = tablen.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            var sts = 1;
            var cust = data[3];
            var sals = data[7];
            $.ajax({
                url: "modal/approval_ar.php",
                method: "POST",
                data: {
                    id: id,
                    sts: sts
                },
                success: function(data) {
                    var url =
                        'https://api.telegram.org/bot2128412393:AAE0RnWM0uKbjf4FjEdr6xW4NBXAp2MlqoI/sendMessage';
                    // var chat_id = "1857799344";
                    var chat_id = ["-759758736","-1001762497140"];
                    var text = "Approval By : " +
                        "<i><b><?= $data['user_nama']; ?></b> Dari Tim Akunting</i>\n" +
                        "No SO : <i><b>" + id + "</b></i>\n" +
                        "Customer : <i>" + cust + "</i>\n" +
                        "Sales : <i>" + sals + "</i>";
                    for (let index = 0; index < chat_id.length; index++) {
                            const element = chat_id[index];
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
                    // console.log(data);
                    swal.fire(data);
                    setTimeout(function() {
                        location.assign("cek_ar.php");
                    }, 2000);
                }
            });
        });
        // KLIK PENDING BUTTON
        $('#tabelUnProses tbody').on('click', '.pending', function() {
            var data = tablen.row($(this).parents('tr')).data();
            var id = data[0];
            var sts = 2;
            $.ajax({
                url: "modal/pendingar.php",
                method: "POST",
                data: {
                    id: id,
                    sts: sts
                },
                success: function(data) {
                    $('#FormPending').html(data);
                    $('#EditModal').modal('show');
                }
            });
        });
        //KLIK CANCEL BUTTON
        $('#tabelUnProses tbody').on('click', '.cancel', function() {
            var data = tablen.row($(this).parents('tr')).data();
            var id = data[0];
            var sts = 3;
            $.ajax({
                url: "modal/cancelar.php",
                method: "POST",
                data: {
                    id: id,
                    sts: sts
                },
                success: function(data) {
                    $('#FormPending').html(data);
                    $('#EditModal').modal('show');
                }
            });
        });
        $('#tabelUnProses tbody').on('click', '.see_more', function() {
            var data = tablen.row($(this).parents('tr')).data();
            var id = data[7];
            // console.log(id);
            $.ajax({
                url: "modal/see_sales.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailSales').html(data);
                    $('#ModalDetail').modal('show');
                }
            });
        });

        $('#tabelUnProses tbody').on('click', '.see_customer', function() {
            var data = tablen.row($(this).parents('tr')).data();
            var id = data[3];
            // console.log(id);
            $.ajax({
                url: "modal/see_customer.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailCustomer').html(data);
                    $('#ModalCustomer').modal('show');
                }
            });
        });

    });
    //2. table proses
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tableProses').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/getdataProcess.php?stat=<?php echo $apv; ?>",
                "responsive": true,
                "columnDefs": [{
                    "width": "2%",
                    "targets": 0
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data === 'PENDING') {
                            return '<span class="label label-warning label-xs">[' +
                                data +
                                ']</span>' + ' ' +
                                '<button class="btn btn-info btn-xs lanjut" title="Proses" rel="tooltio"><span class="fa fa-check"></span></button> <button class="btn btn-danger btn-xs cancel" title="Cancel" rel="tooltip"><span class="fa fa-window-close"></span></button>';
                        } else if (data === 'PROCESS') {
                            return '<span class="label label-info label-xs">[' +
                                data +
                                ']</span>';
                        } else if (data === 'CANCEL') {
                            return '<span class="label label-danger label-xs">[' +
                                data +
                                ']</span>';
                        } else {
                            return 'INVALID DATA';
                        }
                    },
                    "orderable": true,
                    "searchable": true
                }, {
                    "targets": 3,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }, {
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs see_data' title='view' rel='tooltip'><span class='fa fa-eye'></span> </button></div></center>"
                }]
            });
        } else {
            var table = $('#tableProses').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/getdataProcess.php?stat=<?php echo $apv; ?>",
                responsive: true,
                "columnDefs": [{
                    "targets": 6,
                    "render": function(data, row) {
                        if (data === 'PENDING') {
                            return '<span class="label label-warning label-xs">[' +
                                data + ']</span>';
                        } else if (data === 'PROCESS') {
                            return '<span class="label label-info label-xs">[' +
                                data +
                                ']</span>';
                        } else if (data === 'CANCEL') {
                            return '<span class="label label-danger label-xs">[' +
                                data +
                                ']</span>';
                        } else {
                            return 'INVALID DATA';
                        }
                    }

                }]
            })
        }

        // Penomoran 
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
        $('#tableProses tbody').on('click', '.see_data', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo_2.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });

        $('#tableProses tbody').on('click', '.lanjut', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            var sts = 1;
            var cust = data[3];
            var sals = data[7];
            $.ajax({
                url: "modal/approval_ar.php",
                method: "POST",
                data: {
                    id: id,
                    sts: sts
                },
                success: function(data) {
                    var url =
                        'https://api.telegram.org/bot2128412393:AAE0RnWM0uKbjf4FjEdr6xW4NBXAp2MlqoI/sendMessage';
                    // var chat_id = "1857799344";
                    var chat_id = ["-759758736","-1001762497140"];
                    var text = "Approval By : " +
                        "<i><b><?= $data['user_nama']; ?></b> Dari Tim Akunting</i>\n" +
                        "No SO : <i><b>" + id + "</b></i>\n" +
                        "Customer : <i>" + cust + "</i>\n" +
                        "Sales : <i>" + sals + "</i>";
                    for (let index = 0; index < chat_id.length; index++) {
                            const element = chat_id[index];
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
                    // console.log(data);
                    swal.fire(data);
                    setTimeout(function() {
                        location.assign("cek_ar.php");
                    }, 2000);
                }
            });
        });

        $('#tableProses tbody').on('click', '.cancel', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            var sts = 3;
            $.ajax({
                url: "modal/cancelar.php",
                method: "POST",
                data: {
                    id: id,
                    sts: sts
                },
                success: function(data) {
                    $('#FormPending').html(data);
                    $('#EditModal').modal('show');
                }
            });
        });
        $('#tableProses tbody').on('click', '.see_customer', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[3];
            // console.log(id);
            $.ajax({
                url: "modal/see_customer.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailCustomer').html(data);
                    $('#ModalCustomer').modal('show');
                }
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        document.getElementById('soaprove').setAttribute('class', 'active');

        setInterval(function() {
            $.ajax({
                url: 'modal/getLabel.php',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var reslt = data;
                    $('#aklabel').html(reslt.dataun);
                    $('#labelhdr').html(reslt.dataun);
                }
            });
        }, 1000);
    });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="detaiOrder">

                </div>
            </div>
        </div>
    </div>
    <div id="ModalDetail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Sales</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body" id="DetailSales">

                </div>
                <div class="modal-footer">
                    <button type="button" id="close" data-dismiss="modal" class="btn btn-warning btn-sm">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="ModalCustomer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Customer</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body" id="DetailCustomer">

                </div>
                <div class="modal-footer">
                    <button type="button" id="close" data-dismiss="modal" class="btn btn-warning btn-sm">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="EditModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Give Feedback</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="FormPending">

                </div>
            </div>
        </div>
    </div>
</body>

</html>