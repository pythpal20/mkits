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
                    <div class="col-sm-12 m-b-xs">
                        <?php if ($data['modul'] == '1') { ?>
                        <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin') : ?>
                        <a href="customer_add.php" class="btn btn-sm btn-info"><span class="fa fa-plus-circle"></span>
                            Tambah
                            Customer</a>
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
                        <?php endif ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data Customer</h5>
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
                                    <table class="table table-hover display" id="memListTable" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Register</th>
                                                <th data-priority="1">Customer</th>
                                                <th>Kota</th>
                                                <th>Term</th>
                                                <th>Method</th>
                                                <th>Sales</th>
                                                <th>Input By</th>
                                                <th data-priority="2" style="width: 15%; text-align:center;">Aksi</th>
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
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('mastercustomer').className = 'active';
    });
    </script>

    <script>
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        if (lvl == "admin" || lvl == "superadmin") {
            var table = $('#memListTable').DataTable({
                // pageLength: 15,
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/data_customer.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-info btn-xs view_data' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-primary btn-xs tblEdit' tooltip='Edit'><span class='fa fa-edit'></span> </button> <button class='btn btn-danger btn-xs tblDelete'><span class='fa fa-trash'></span> </button> <button class='btn btn-xs btn-success history' rel='tooltip' title='history customer'><span class='fa fa-history'></span></button></center>"
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
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return data.split(" ")[0]
                    }
                }]
            });
        } else {
            var table = $('#memListTable').DataTable({
                pageLength: 15,
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/data_customer.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-info btn-xs view_data' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button></center>"
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        return data.split(" ")[0]
                    }
                }]
            });
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
        // table.on( 'order.dt search.dt', function () {
        // table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        // cell.innerHTML = i+1;
        //     } );
        // } ).draw();
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

        $('#memListTable tbody').on('click', '.tblEdit', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "customer_edit.php?id=" + data[0];
        });

        $('#memListTable tbody').on('click', '.tblDelete', function() {
            var data = table.row($(this).parents('tr')).data();
            window.location.href = "customer_delete.php?id=" + data[0];
        });
        $('#memListTable tbody').on('click', '.history', function() {
            var data = table.row($(this).parents('tr')).data();
            window.location.href = "history_customer.php?id=" + data[0];
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
        $('.selectkota').chosen({
            no_results_text: "Duh, Nggak Ketemu euy!",
            width: "100%"
        });
        $('.selectKategori').chosen({
            no_results_text: "Duh, Nggak Ketemu euy!",
            width: "100%"
        });
    });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog" style="max-width:75%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="fa fa-address-card"></span> Detail Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="viewCust">

                </div>
                <div class="modal-footer">
                    <small><em>* Data yang tidak sesuai, silahkan hubungi admin sales-marketing</em></small>
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
                    <form method="POST" action="export/exportcsvcustomer.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control selectKategori">
                                        <option value="">ALL</option>
                                        <?php
                                            $kat = "SELECT * FROM master_kategori ORDER BY kategori_nama ASC";
                                            $mwk = $db1->prepare($kat);
                                            $mwk->execute();
                                            $reslt = $mwk->get_result();
                                            while ($ktr=$reslt->fetch_assoc()){
                                            echo '<option value='.$ktr['kategori_nama'].'>'.$ktr['kategori_nama'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kota</label>
                                    <select name="kota" id="kota" class="form-control selectkota">
                                        <option value="">ALL</option>
                                        <?php
                                            $kot = "SELECT * FROM master_wilayah WHERE CHAR_LENGTH(wilayah_id)=5 ORDER BY wilayah_nama";
                                            $mwk = $db1->prepare($kot);
                                            $mwk->execute();
                                            $resltt = $mwk->get_result();
                                            while ($kta=$resltt->fetch_assoc()){
                                            echo '<option value='.$kta['wilayah_id'].'>'.$kta['wilayah_nama'].'</option>';
                                            }
                                        ?>
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