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
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
</head>

<body>
    <style>
    /* Ensure that the demo table scrolls */
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    </style>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Penagihan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Penagihan Berjalan</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- carousel end -->
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
                                        <div class="">
                                            <table class="table table-responsive w-100 d-block d-md-table"
                                                id="tableMWK">
                                                <thead>
                                                    <tr>
                                                        <th>No. SCO</th>
                                                        <th>PT.</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Tgl. Inv</th>
                                                        <th>No. Inv</th>
                                                        <th>Nom. Awal</th>
                                                        <th>Nom. Aktual</th>
                                                        <th>Tgl. Kontrabon</th>
                                                        <th>Tgl. Duedate</th>
                                                        <th>Overdue</th>
                                                        <th>Total Bayar</th>
                                                        <th>Selisih</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-responsive w-100 d-block d-md-table"
                                                id="tableMWM">
                                                <thead>
                                                    <tr>
                                                        <th>No. SCO</th>
                                                        <th>CV.</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Tgl. Inv</th>
                                                        <th>No. Inv</th>
                                                        <th>Nom. Awal</th>
                                                        <th>Nom. Aktual</th>
                                                        <th>Tgl. Kontrabon</th>
                                                        <th>Tgl. Duedate</th>
                                                        <th>Overdue</th>
                                                        <th>Total Bayar</th>
                                                        <th>Selisih</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" width="100%" id="tableBAK">
                                                <thead>
                                                    <tr>
                                                        <th>No. SCO</th>
                                                        <th>PT.</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Tgl. Inv</th>
                                                        <th>No. Inv</th>
                                                        <th>Nom. Awal</th>
                                                        <th>Nom. Aktual</th>
                                                        <th>Tgl. Kontrabon</th>
                                                        <th>Tgl. Duedate</th>
                                                        <th>Overdue</th>
                                                        <th>Total Bayar</th>
                                                        <th>Selisih</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" width="100%" id="tableFCI">
                                                <thead>
                                                    <tr>
                                                        <th>No. SCO</th>
                                                        <th>PT.</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Tgl. Inv</th>
                                                        <th>No. Inv</th>
                                                        <th>Nom. Awal</th>
                                                        <th>Nom. Aktual</th>
                                                        <th>Tgl. Kontrabon</th>
                                                        <th>Tgl. Duedate</th>
                                                        <th>Overdue</th>
                                                        <th>Total Bayar</th>
                                                        <th>Selisih</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" width="100%" id="tableDTM">
                                                <thead>
                                                    <tr>
                                                        <th>No. SCO</th>
                                                        <th>PT.</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Tgl. Inv</th>
                                                        <th>No. Inv</th>
                                                        <th>Nom. Awal</th>
                                                        <th>Nom. Aktual</th>
                                                        <th>Tgl. Kontrabon</th>
                                                        <th>Tgl. Duedate</th>
                                                        <th>Overdue</th>
                                                        <th>Total Bayar</th>
                                                        <th>Selisih</th>
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
    <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
    <?php include 'template/load_js.php'; ?>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
    $(document).ready(function() {
        document.getElementById('billing').className = 'active';
    });
    //dataTable PT MWK
    $(document).ready(function() {
        var table = $('#tableMWK').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/BillingMWK.php",
            "scrollY": 400,
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns": true,
            columnDefs: [{
                "targets": 12,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }, {
                "targets": 6,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 7,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 10,
                "render": function(data, row) {
                    if (data === null) {
                        return '-'
                    } else if (data < 0) {
                        return '<span class="label label-warning">' + data +
                            '<span>'
                    } else if (data > 0) {
                        return '<span class="label label-info">' + data +
                            '</span>'
                    }
                }
            }]
        });
    });
    //dataTable CV MWM
    $(document).ready(function() {
        var table2 = $('#tableMWM').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/BillingMWM.php",
            "scrollY": 400,
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns": true,

            columnDefs: [{
                "targets": 12,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }, {
                "targets": 6,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 7,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 10,
                "render": function(data, row) {
                    if (data === null) {
                        return '-'
                    } else if (data < 0) {
                        return '<span class="label label-warning">' + data +
                            '<span>'
                    } else if (data > 0) {
                        return '<span class="label label-info">' + data +
                            '</span>'
                    }
                }
            }]
        });
    });
    //dataTable PT BAK
    $(document).ready(function() {
        var table3 = $('#tableBAK').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/BillingBAK.php",
            "scrollY": 400,
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns": true,
            columnDefs: [{
                "targets": 12,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }, {
                "targets": 6,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 7,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 10,
                "render": function(data, row) {
                    if (data === null) {
                        return '-'
                    } else if (data < 0) {
                        return '<span class="label label-warning">' + data +
                            '<span>'
                    } else if (data > 0) {
                        return '<span class="label label-info">' + data +
                            '</span>'
                    }
                }
            }]
        });
    });
    // //dataTable PT FCI
    $(document).ready(function() {
        var table4 = $('#tableFCI').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/BillingFCI.php",
            "scrollY": 400,
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns": true,
            columnDefs: [{
                "targets": 12,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }, {
                "targets": 6,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 7,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 10,
                "render": function(data, row) {
                    if (data === null) {
                        return '-'
                    } else if (data < 0) {
                        return '<span class="label label-warning">' + data +
                            '<span>'
                    } else if (data > 0) {
                        return '<span class="label label-info">' + data +
                            '</span>'
                    }
                }
            }]
        });
    });
    // //dataTable PT DTM
    $(document).ready(function() {
        var table5 = $('#tableDTM').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/BillingDTM.php",
            "scrollY": 400,
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns": true,
            columnDefs: [{
                "targets": 12,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }, {
                "targets": 6,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 7,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

            }, {
                "targets": 10,
                "render": function(data, row) {
                    if (data === null) {
                        return '-'
                    } else if (data < 0) {
                        return '<span class="label label-warning">' + data +
                            '<span>'
                    } else if (data > 0) {
                        return '<span class="label label-info">' + data +
                            '</span>'
                    }
                }
            }]
        });
    });
    </script>
</body>

</html>