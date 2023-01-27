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
                            <strong>Lunas (Selesai)</strong>
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
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Tabel Penagihan Lunas (Selesai)</h5>
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
                                <table class="table table-responsive w-100 d-block d-md-table" id="TBillingdone">
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
    //dataTable Script
    $(document).ready(function() {
        var table = $('#TBillingdone').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/Billingdone.php",
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
                        return '<span class="label label-warning">' + data + '<span>'
                    } else if (data > 0) {
                        return '<span class="label label-info">' + data + '</span>'
                    }
                }
            }]
        });
    });
    </script>
</body>

</html>