<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses != '2'){
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
                    <h2>Data Order (CO)</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data Order</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-xs exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
                    </div>
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-building-o"></span> PT. MWK</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span
                                            class="fa fa-building-o"></span> CV. MWM</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span
                                            class="fa fa-building-o"></span> PT. BAK </a></li>
                                <li><a class="nav-link tab4" data-toggle="tab" href="#tab-4" id="tab4"><span
                                            class="fa fa-building-o"></span> PT. FCI </a></li>
                                <li><a class="nav-link tab5" data-toggle="tab" href="#tab-5" id="tab5"><span
                                            class="fa fa-building-o"></span> PT. DTM </a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <table class="tabel table-striped" id="tableMwk">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. CO</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Tgl. Kirim</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th data-priority="3">Sales</th>
                                                    <th>Term</th>
                                                    <th>Method</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="tableMwm" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                    <th data-priority="1">No. CO</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Tgl. Kirim</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th data-priority="3">Sales</th>
                                                    <th>Term</th>
                                                    <th>Method</th>
                                                    <th data-priority="2">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="tabel table-striped" id="tableBak" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                    <th data-priority="1">No. CO</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Tgl. Kirim</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th data-priority="3">Sales</th>
                                                    <th>Term</th>
                                                    <th>Method</th>
                                                    <th data-priority="2">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="tabel table-striped" id="tableFci" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                    <th data-priority="1">No. CO</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Tgl. Kirim</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th data-priority="3">Sales</th>
                                                    <th>Term</th>
                                                    <th>Method</th>
                                                    <th data-priority="2">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="tabel table-striped" id="tableDtm" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th data-priority="1">No. CO</th>
                                                        <th>Tgl. Order</th>
                                                        <th>Tgl. Kirim</th>
                                                        <th>Customer</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th data-priority="3">Sales</th>
                                                        <th>Term</th>
                                                        <th>Method</th>
                                                        <th data-priority="2">Aksi</th>
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
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
        $.fn.dataTable.tables({
                visible: true,
                api: true
            })
            .columns.adjust()
            .responsive.recalc()
            .draw();
    });
    //1. data co PT. MWK
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tableMwk').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_mwk.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "render": function(data, row) {
                        if (data == 2) {
                            return '<center><div class="btn-group"><button class="btn btn-info btn-xs seedata" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span> </button> <button class="btn btn-xs btn-block btn-outline btn-warning forwards" rel="tooltip" title="Bring back Data to Pending table"><span class="fa fa-mail-forward (alias)"></span></button> </div></center>'
                        } else {
                            return "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> <button class='btn btn-xs btn-success revisi'><span class='fa fa-edit'></span> </button>"
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return "<span class='label label-info'>PROSES</span>";
                        } else if (data == '2') {
                            return "<span class='label label-danger'>CANCEL</span>";
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        } else {
            var table = $('#tableMwk').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_mwk.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> </div></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>PROSES</span>"
                        } else if (data == 2) {
                            return "<span class='label label-danger'>CANCEL</span>"
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        }
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
        $('#tableMwk tbody').on('click', '.see_customer', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[4];
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
        $('#tableMwk tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/detail_co.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailView').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tableMwk tbody').on('click', '.see_more', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[7];
            // console.log(id);
            $.ajax({
                url: "modal/see_sales.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#DetailSales').html(data);
                    $('#ModalDetail').modal('show');
                }
            });
        });
        $('#tableMwk tbody').on('click', '.revisi', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/gantiterm.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#FormTop').html(data);
                    $('#TopEdit').modal('show');
                    console.log(data);
                }
            });
        });
    });
    //2. data co CV. MWM
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tableMwm').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_mwm.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "render": function(data, row) {
                        if (data == 2) {
                            return '<center><div class="btn-group"><button class="btn btn-info btn-xs seedata" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span> </button> <button class="btn btn-xs btn-block btn-outline btn-warning forwards" rel="tooltip" title="Bring back Data to Pending table"><span class="fa fa-mail-forward (alias)"></span></button> </div></center>'
                        } else {
                            return "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> <button class='btn btn-xs btn-success revisi'><span class='fa fa-edit'></span> </button>"
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return "<span class='label label-info'>PROSES</span>";
                        } else if (data == '2') {
                            return "<span class='label label-danger'>CANCEL</span>";
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        } else {
            var table = $('#tableMwm').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_mwm.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> </div></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>PROSES</span>"
                        } else if (data == 2) {
                            return "<span class='label label-danger'>CANCEL</span>"
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        }
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
        $('#tableMwm tbody').on('click', '.see_customer', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[4];
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
        $('#tableMwm tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/detail_co.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailView').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tableMwm tbody').on('click', '.see_more', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[7];
            // console.log(id);
            $.ajax({
                url: "modal/see_sales.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#DetailSales').html(data);
                    $('#ModalDetail').modal('show');
                }
            });
        });
        $('#tableMwm tbody').on('click', '.revisi', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/gantiterm.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#FormTop').html(data);
                    $('#TopEdit').modal('show');
                    console.log(data);
                }
            });
        });
    });
    //3. data co PT. BAK
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tableBak').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_bak.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "render": function(data, row) {
                        if (data == 2) {
                            return '<center><div class="btn-group"><button class="btn btn-info btn-xs seedata" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span> </button> <button class="btn btn-xs btn-block btn-outline btn-warning forwards" rel="tooltip" title="Bring back Data to Pending table"><span class="fa fa-mail-forward (alias)"></span></button> </div></center>'
                        } else {
                            return "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> <button class='btn btn-xs btn-success revisi'><span class='fa fa-edit'></span> </button>"
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return "<span class='label label-info'>PROSES</span>";
                        } else if (data == '2') {
                            return "<span class='label label-danger'>CANCEL</span>";
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        } else {
            var table = $('#tableBak').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_bak.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> </div></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>PROSES</span>"
                        } else if (data == 2) {
                            return "<span class='label label-danger'>CANCEL</span>"
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        }
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
        $('#tableBak tbody').on('click', '.see_customer', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[4];
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
        $('#tableBak tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/detail_co.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailView').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tableBak tbody').on('click', '.see_more', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[7];
            // console.log(id);
            $.ajax({
                url: "modal/see_sales.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#DetailSales').html(data);
                    $('#ModalDetail').modal('show');
                }
            });
        });
        $('#tableBak tbody').on('click', '.revisi', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/gantiterm.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#FormTop').html(data);
                    $('#TopEdit').modal('show');
                    console.log(data);
                }
            });
        });
    });
    //4. data co PT. FCI
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tableFci').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_fci.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "render": function(data, row) {
                        if (data == 2) {
                            return '<center><div class="btn-group"><button class="btn btn-info btn-xs seedata" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span> </button> <button class="btn btn-xs btn-block btn-outline btn-warning forwards" rel="tooltip" title="Bring back Data to Pending table"><span class="fa fa-mail-forward (alias)"></span></button> </div></center>'
                        } else {
                            return "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> <button class='btn btn-xs btn-success revisi'><span class='fa fa-edit'></span> </button>"
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return "<span class='label label-info'>PROSES</span>";
                        } else if (data == '2') {
                            return "<span class='label label-danger'>CANCEL</span>";
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        } else {
            var table = $('#tableFci').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_fci.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> </div></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>PROSES</span>"
                        } else if (data == 2) {
                            return "<span class='label label-danger'>CANCEL</span>"
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        }
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
        $('#tableFci tbody').on('click', '.see_customer', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[4];
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
        $('#tableFci tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/detail_co.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailView').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tableFci tbody').on('click', '.see_more', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[7];
            // console.log(id);
            $.ajax({
                url: "modal/see_sales.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#DetailSales').html(data);
                    $('#ModalDetail').modal('show');
                }
            });
        });
        $('#tableFci tbody').on('click', '.revisi', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/gantiterm.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#FormTop').html(data);
                    $('#TopEdit').modal('show');
                    console.log(data);
                }
            });
        });
    });
    //5. data co PT. DTM
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tableDtm').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_dtm.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "render": function(data, row) {
                        if (data == 2) {
                            return '<center><div class="btn-group"><button class="btn btn-info btn-xs seedata" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span> </button> <button class="btn btn-xs btn-block btn-outline btn-warning forwards" rel="tooltip" title="Bring back Data to Pending table"><span class="fa fa-mail-forward (alias)"></span></button> </div></center>'
                        } else {
                            return "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> <button class='btn btn-xs btn-success revisi'><span class='fa fa-edit'></span> </button>"
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return "<span class='label label-info'>PROSES</span>";
                        } else if (data == '2') {
                            return "<span class='label label-danger'>CANCEL</span>";
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        } else {
            var table = $('#tableDtm').DataTable({
                "processing": true,
                "serverSide": true,
                colReorder: true,
                "responsive": true,
                "ajax": "../serverside/ak_dtm.php?stat=",
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 10,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> </button> </div></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return "<a class='see_more'>" + data + "</a>"
                    }
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>PROSES</span>"
                        } else if (data == 2) {
                            return "<span class='label label-danger'>CANCEL</span>"
                        }
                    }
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        return "<a class='see_customer'>" + data + "</a>"
                    }
                }]
            });
        }
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
        $('#tableDtm tbody').on('click', '.see_customer', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[4];
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
        $('#tableDtm tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/detail_co.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailView').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tableDtm tbody').on('click', '.see_more', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[7];
            // console.log(id);
            $.ajax({
                url: "modal/see_sales.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#DetailSales').html(data);
                    $('#ModalDetail').modal('show');
                }
            });
        });
        $('#tableDtm tbody').on('click', '.revisi', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/gantiterm.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#FormTop').html(data);
                    $('#TopEdit').modal('show');
                    console.log(data);
                }
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        // document.getElementById('datafix').setAttribute('class', 'active');
        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
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

    <div id="TopEdit" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah TOP</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="FormTop">

                </div>
            </div>
        </div>
    </div>

    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="DetailView">

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
    <div class="modal fade" id="exportData" tabindex="-1" role="dialog" aria-hidden="true">
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
</body>

</html>