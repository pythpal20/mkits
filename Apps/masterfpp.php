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
                    <h2>Data Form Perubahan PO</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data FPP</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>List Data Pengajuan Perubahan PO</h5>
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
                                    <div class="col-sm-8"></div>
                                    <div class="col-sm-4 m-b-xs">
                                        <div class="input-group m-b">
                                            <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                                                placeholder="Ketik disini untuk mencari data. . .">
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon"><span
                                                        class="fa fa-search"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table">
                                    <table class="display table table-hover table-bordered myFppList"
                                        data-filter=#filter>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>No. FPP</th>
                                                <th data-hide="phone">No. SO</th>
                                                <th data-hide="phone">Tgl. Pengajuan</th>
                                                <th>Customer</th>
                                                <th>Sales</th>
                                                <th>Proggres</th>
                                                <th data-hide="phone">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT a.fpp_id, b.noso, a.fpp_tanggal, a.inputby, c.customer_nama, a.approvl FROM master_fpp a 
                                                JOIN salesorder_hdr b ON a.noso = b.noso
                                                JOIN master_customer c ON b.customer_id = c.customer_id
                                                ORDER BY a.fpp_id DESC";
                                                $mwk = $db1->prepare($sql);
                                                $mwk->execute();
                                                $resl = $mwk->get_result();
                                                $no   = 1;
                                                if ($resl->num_rows > 0){
                                                while ($row=$resl->fetch_assoc()){
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['fpp_id']; ?></td>
                                                <td><?php echo $row['noso']; ?></td>
                                                <td><?php echo $row['fpp_tanggal']; ?></td>
                                                <td><?php echo $row['customer_nama']; ?></td>
                                                <td><?php echo $row['inputby'];?></td>
                                                <td>
                                                    <?php 
                                                        if ($row['approvl'] == '0' AND $data['level'] == 'admin') {
                                                            echo "Belum di Aprove";
                                                        } elseif($row['approvl'] == '1') {
                                                        echo '<a href="datafpp_print.php?id='.$row["fpp_id"].'" class="btn btn-sm btn-primary" target="_blank">Download</a>';
                                                        } else {
                                                        echo "Sudah diproses [ADMIN PO]";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-xs view_data" type="button"
                                                        name="view" id-fp="<?php echo $row['fpp_id'];?>"
                                                        title="View Detail" rel="tooltip"><span
                                                            class="fa fa-eye"></span></button>
                                                </td>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="8">Tidak ada data euy</td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                        <tfoot class="hide-if-no-paging">
                                            <tr>
                                                <td colspan="8">
                                                    <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
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
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('fpp').setAttribute('class', 'active');
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.myFppList').footable({
            "paging": {
                "enabled": false
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.aprove').click(function() {
            var id = $(this).attr("id-fpp");
            $.ajax({
                url: "modal/AprovalFpp.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    Swal.fire(
                        data,
                        '',
                        'success'
                    );
                    // console.log(data);
                    setTimeout(function() {
                        location.assign("datafpp.php");
                    }, 2000);
                }
            })
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
        $('.view_data').click(function() {
            var id = $(this).attr("id-fp");
            $.ajax({
                url: "modal/DetailFpp.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#dtlFpp').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
    });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Pengajuan FPP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="dtlFpp">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportData" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data </h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Filter Export</h5>
                    <form method="POST" action="export/exportfpp.php" id="formExport">
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
</body>

</html>