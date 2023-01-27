<?php
include '../config/connection.php';

session_start();
$akses = $_SESSION['moduls'];
if (!isset($_SESSION['usernameu']) || $akses !== '1') {
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
</head>

<body>
    <div id="wrapper">
        <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
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
                            <strong>Customer</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>My Customer</h5>
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
                                    <table class="table table-bordered table-hover display" id="memListTable" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Register</th>
                                                <th data-priority="1">Nama</th>
                                                <th>Kota</th>
                                                <th>Term</th>
                                                <th>Method</th>
                                                <th>Input By</th>
                                                <th data-priority="2" style="width: 10%; text-align:center;">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="ibox-footer">
                                <small>
                                    <em>
                                        Note :<br>
                                        (-) CBD => Cash Before Delivery<br>
                                        (-) COD => Cash On Delivery
                                    </em>
                                </small>
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
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="fa fa-address-card"></span> Detail Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="viewCust">

                </div>
                <div class="modal-footer">
                    <small><em>* Data yang tidak sesuai, silahkan hubungi admin sales-marketing</em></small>
                </div>
            </div>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script>
        $(document).ready(function() {
            document.getElementById('mastercustomer').className = 'active';

            swal.fire({
                title: 'INFO',
                text: 'Jika customer kamu tidak muncul disini, silahkan kontak Sales Planer Anda',
                icon: 'info',
                confirmButtonText: 'Ok, Paham',
                showCancelButton: false,
                allowOutsideClick: false
            });
        });

        $(document).ready(function() {
            var nm_user = '<?= $data["user_id"] ?>';
            var table = $('#memListTable').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/custView_sales.php?id=" + nm_user,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-info btn-xs view_data' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-xs btn-success history' rel='tooltip' title='history customer'><span class='fa fa-history'></span></button></center>"
                }, {
                    "targets": 4,
                    "render": function(data, row) {
                        if (data == 'Cash Before Delivery') {
                            return '<b>CBD</b>'
                        } else if (data == 'Cash On Delivery') {
                            return '<b>COD</b>'
                        } else {
                            return '<b>' + data + '</b>'
                        }
                    }
                }]
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
            $('#memListTable tbody').on('click', '.view_data', function() {
                var data = table.row($(this).parents('tr')).data();
                var data3 = data[5];
                var data3 = btoa(data3);
                var id = data[0];
                $.ajax({
                    url: "modal/customer_view.php",
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
            $('#memListTable tbody').on('click', '.history', function() {
                var data = table.row($(this).parents('tr')).data();
                window.location.href = "history_customer.php?id=" + data[0];
            });
        });
    </script>
</body>

</html>