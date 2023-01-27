<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
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
    <?php include 'template/load_js.php';?>
    <!-- load css library -->
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
                    <h2>Keep Stock</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="list_so_mau_keep.php">Keep Stock</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Dashboard</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> Dashboard Keep Stock</h5>
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
                                    <table class="table table-hover display" id="gudang">
                                        <thead>
                                            <tr>
                                                <th>SKU</th>
                                                <th style="background-color:#6fa8dc"> SOH</th>
                                                <th class="no-sort"> Req</th>
                                                <!-- <th style="background-color:#79cc54"> Keep</th> -->
                                                <th class="no-sort"> Keep</th>
                                                <th class="no-sort"> Req Cancel</th>
                                                <th class="no-sort"> Complete</th>
                                                <th>Gudang</th>
                                                <!-- <th data-priority="1">QTY Completed</th> -->
                                            </tr>
                                        </thead>
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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.js">
    </script>

    <script>
    $(document).ready(function() {
        var gudang = $('#gudang').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_qty_gudang.php",
            // "order": [
            //     [4, 'desc']
            // ],
            "initComplete": function(settings, json) {

            },
            "columnDefs": [{
                    "targets": 1,
                    "className": "text-center",
                    "type":"num",
                    "render":$.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    "targets": 2,
                    "className": "text-center",
                    "type": "num",
                    "render":$.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    "targets": 3,
                    "className": "text-center",
                    "type": "num",
                    "render":$.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    "targets": 4,
                    "className": "text-center",
                    "type":"num",
                    "render":$.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    "targets": 5,
                    "className": "text-center",
                    "type":"num",
                    "render":$.fn.dataTable.render.number(',', '.', 0, '')
                },{
                    "targets":6,
                    "type":"num",
                    "render":$.fn.dataTable.render.number(',', '.', 0, '')
                }


            ]

        });
        gudang.on('draw.dt', function() {
            gudang.column(1, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = gudang.row(i).data()[6] - gudang.row(i).data()[3] - gudang.row(
                    i).data()[4];
                $(this).css("background-color", "#c8dcef");
                $(this).css("border-color", "black");
            });
            // gudang.column(3, {
            //     search: 'applied',
            //     order: 'applied',
            //     page: 'applied'
            // }).nodes().each(function(cell, i) {

            //     // $(this).css("background-color", "#bae8c0");
            //     // $(this).css("border-color", "black");
            // });
        });
        gudang
            .order( [ 6, 'ASC' ] )
            .draw();

    });
    </script>