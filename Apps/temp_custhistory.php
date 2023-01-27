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
                    <h2>History Kunjungan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="tempcustomer.php">Bank Data</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>History</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <?php
                                $id = $_GET['id'];
                                    $cst = "SELECT * FROM temp_customer
                                    WHERE ID = '$id'";
                                    $mwk = $db1->prepare($cst);
                                    $mwk -> execute();
                                    $hsl = $mwk->get_result();

                                    $row = $hsl->fetch_assoc();
                                ?>
                                <table width="100%">
                                    <tr>
                                        <th>Nama Customer</th>
                                        <td>:</td>
                                        <td><?= $row['customer_nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Usaha</th>
                                        <td>:</td>
                                        <td><?= $row['jenis_usaha'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>PIC</th>
                                        <td>:</td>
                                        <td><?= $row['pic'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>:</td>
                                        <td><?= $row['nohp'] . ' / ' . $row['notelp'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td><?= $row['detail_alamat'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>History Customer</h5>
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
                                <table class="table table-bordered" id="histVisit">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tgl. FU</th>
                                            <th>Sales</th>
                                            <th>Jenis FU</th>
                                            <th>Hasil FU</th>
                                            <th>Deskripsi</th>
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
    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        document.getElementById('bankData').className = 'active';
    });
    $(document).ready(function() {
        var table = $('#histVisit').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "../serverside/HistVisit.php?id=<?php echo $_GET['id']; ?>"
        });
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
    });
    </script>