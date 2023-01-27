<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '4'){
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
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <div class="row border-bottom white-bg page-heading">
                <!-- || -->
                <div class="col-lg-10">
                    <h2>Data Request Pick Ticket Sample</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Pengajuan Sample</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- || -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Pick Ticket Sample</h5> <small> Data sudah melalui aproval Admin dan Finance</small>
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
                                <table class="table table-bordered display" id="TablePts" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">#</th>
                                            <th data-priority="1">No. PTS</th>
                                            <th>Tgl. Request</th>
                                            <th>Tgl. Ambil</th>
                                            <th>Status</th>
                                            <th>Customer</th>
                                            <th>Sales</th>
                                            <th style="width:8%" data-priority="2">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <input type="hidden" name="level" id="level" value="<?php echo $data['level']; ?>">
    <script>
    $(document).ready(function() {
        var lvl = $('#level').val();
        if (lvl === "admin" || lvl === "superadmin") {
            var table = $('#TablePts').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/datasamplewrh.php",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span></button> <button class='btn btn-primary btn-xs tblEdit' tooltip='Edit'><span class='fa fa-edit'></span> </button></center>"
                }, {
                    "targets": 4,
                    "render" : function(data, row) {
                        if (data == 1) {
                            return 'Kembali'
                        }else if(data == 2) {
                            return 'Tidak Kembali'
                        }else if(data == 3) {
                            return 'Dibeli'
                        }
                    }
                }]
            });
        } else {
            var table = $('#TablePts').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/datasamplewrh.php",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span></button></center>"
                }, {
                    "targets": 4,
                    "render" : function(data, row) {
                        if (data == 1) {
                            return 'Kembali'
                        }else if(data == 2) {
                            return 'Tidak Kembali'
                        }else if(data == 3) {
                            return 'Dibeli'
                        }
                    }
                }]
            });
        }
        //penomoran pada table berdasarkan ID
        table.on('draw.dt', function() {
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied',
                sort: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        // klik tombol see data (icon mata)
        $('#TablePts tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/pts_view.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#viewPts').html(data);
                    $('#PtsModal').modal('show');
                }
            });

        });
        $('#TablePts tbody').on('click', '.tblEdit', function() { // tombol ubah data po
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "datasamplewrh_proses.php?id=" + data[0];
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        document.getElementById('ptsamplesm').setAttribute('class', 'active');
    });
    </script>
</body>
<div id="PtsModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail PTS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="viewPts">

            </div>
        </div>
    </div>
</div>

</html>