<?php
include '../../config/connection.php';

session_start();
$akses = $_SESSION['moduls'];
if (isset($_SESSION['usernameu']) || $akses == '3') {
} else {
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
                    <h2>Penagihan Berjalan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Penagihan</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>PT. Dewata Titian Mas</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title bg-info">
                                <h5>Tabel Penagihan Berjalan PT. Dewata Titian Mas</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content" style="background-color:AliceBlue ;">
                                <table class="table table-borderless" id="example" data-toggle="example" data-show-toggle="true" data-show-columns="true" data-id-field="No_Co" data-show-footer="false" data-show-print="true">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tgl. Inv </th>
                                            <th class="text-center">No Inv </th>
                                            <th class="text-center">No SO </th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Sales</th>
                                            <th class="text-center" data-priority="8">Nominal FA Awal</th>
                                            <th class="text-center" data-priority="7">Nominal Konfirmasi</th>
                                            <th class="text-center" data-priority="6">tgl Kontrabon </th>
                                            <th class="text-center" data-priority="5">tgl Duedate </th>
                                            <th class="text-center" data-priority="4">Overdue </th>
                                            <th class="text-center" data-priority="3">Total Bayar </th>
                                            <th class="text-center" data-priority="2">Selisih </th>
                                            <th class="text-center" data-priority="1">Aksi </th>
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
    <script src="DataScript/ptdtm.js"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                document.getElementById('invdtm').setAttribute('class', 'active');
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            });
            $('.exportBtn').click(function() {
                $('#exportModal').modal("show");
            });
        })
    </script>
</body>

</html>