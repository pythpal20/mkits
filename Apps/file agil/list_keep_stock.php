<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) ){
        header("Location: ../index.php");
    }
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc(); 


    $ambil_id_terakhir = "SELECT max(no_keepstock) as idmax FROM keepstock ";
    $result_id = $db1->query($ambil_id_terakhir);
    $no_keep = (int)$result_id->fetch_assoc()['idmax']+1;

      // function id
      function add_leading_zero($value, $threshold = 4) {
        return sprintf('%0' . $threshold . 's', $value);
    }
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
        <input type="hidden" name="level" id="leveluser" value="<?php echo $data['level']; ?>">
        <input type="hidden" name="namauser" id="namauser" value="<?php echo $data['user_nama']; ?>">
        <input type="hidden" name="moduluser" id="moduluser" value="<?php echo $data['modul']; ?>">

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
                            <strong>List Keep Stock</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Keep Stock</h5>
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
                                    <table class="table table-hover display" id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-priority="2">No Keep Stock</th>
                                                <th>Status</th>
                                                <th>Print</th>
                                                <th data-priority="1">Action</th>
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
    <!-- modal detail keepstock -->
    <div class="modal inmodal fade" id="modalview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Detail Keep Stock</h4>
                </div>
                <div class="modal-body" id="detailModal">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.js">
    </script>
    <script>
    $(document).ready(function() {
        var buttonView =
            "<button class='btn btn-default btn-sm seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var buttonCancel =
            "<button class='btn btn-danger btn-sm cancel' title='Cancel' rel='tooltip'><span class='fa fa-close'></span></button>";
        var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_keepstock.php",
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center> " +
                        buttonView + buttonCancel + " </center>"
                }, {
                    "targets": 0,
                    "className": "text-center",
                },
                {
                    "targets": 1,
                    "className": "text-center",

                },
                {
                    "targets": 2,
                    "className": "text-center",
                },
                {
                    "targets": 3,
                    "className": "text-center",
                },
                {
                    "targets": 4,
                    "className": "text-center",
                },

            ]
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



        $('#example tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            var leveluser = $("#leveluser").val();
            var moduluser = $("#moduluser").val();

            $.ajax({
                url: 'modal_agil/ambilDetailKeepStock.php',
                method: 'post',
                data: {
                    "id": id,
                    "level": leveluser,
                    "modul": moduluser,
                },
                success: (data) => {
                    console.log(data);
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    $('.keepstock').click(function() {
                        var no_keepstock = $(this).attr("no_keepstock");
                        var id = $(this).attr("id");
                        var noso = $(this).attr("noso");
                        var sku = $(this).attr("sku");
                        var status = $(this).attr("status");
                        var qty_req = $(this).attr("qty_req");
                        var qty_keep = $(this).attr("qty_keep");
                        var jml_req = $('#input_' + id).val();
                        var user = $("#namauser").val();
                        var total_hitung = parseInt(jml_req) + parseInt(
                            qty_keep);
                        // kondisi pengecekan proses (edit qty keep atau approve)
                        if (status == "edit") {
                            if (total_hitung <= qty_req && parseInt(jml_req) >
                                "0" &&
                                parseInt(jml_req) != " ") {
                                $.ajax({
                                    url: 'modal_agil/editKeep.php',
                                    method: 'post',
                                    data: {
                                        "qty_req": jml_req,
                                        "no_keepstock": no_keepstock,
                                        "status_keep": '0',
                                        "id": id,
                                    },
                                    success: (data) => {
                                        $('#modalview').modal('hide');
                                    }
                                });
                            } else {
                                alert('tidak bisa melakukan aksi!');
                            }
                        } else {
                            if (total_hitung <= qty_req && parseInt(jml_req) >
                                "0" &&
                                parseInt(jml_req) != " ") {
                                $.ajax({
                                    url: 'modal_agil/updateKeep.php',
                                    method: 'post',
                                    data: {
                                        "qty_keep": jml_req,
                                        "qty_req": qty_req,
                                        "no_keepstock": no_keepstock,
                                        "status_keep": '1',
                                        "id": id,
                                        "user": user,
                                    },
                                    success: (data) => {
                                        $('#modalview').modal('hide');
                                        location.reload(true);
                                    }
                                });
                            } else {
                                alert('tidak bisa melakukan aksi!');
                            }
                        }
                    });

                    $('.hapus').click(function() {
                        $('#modalview').modal('hide');

                        var id = $(this).attr('id');
                        var qty_req = $(this).attr('qty_req');
                        var sku = $(this).attr('sku');
                        var noso = $(this).attr('noso');
                        Swal.fire({
                            title: 'Apakah yakin sku' + sku +
                                ' dengan qty req ' + qty_req + ' di noso ' +
                                noso + ' akan dihapus?',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            denyButtonText: `jangan`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'modal_agil/hapus_detail_keepstock.php',
                                    method: 'post',
                                    data: {
                                        "id": id
                                    },
                                    success: (data) => {
                                        console.log(data);
                                        if (data == "1") {
                                            Swal.fire(
                                                'terhapus!',
                                                '',
                                                'success')
                                            location.reload(
                                                true);
                                        } else {
                                            Swal.fire(
                                                'Data keep gagal dihapus',
                                                '',
                                                'danger')
                                            location.reload(
                                                true);
                                        }
                                    }
                                });
                            } else if (result.isDenied) {
                                Swal.fire('Data keep tidak dihapus', '',
                                    'info')
                            }
                        })
                    });
                    $('.selesai').click(function() {
                        var id = $(this).attr('id');
                        var user = $("#namauser").val();
                        var nosh = $("#nosh").val();
                        if (nosh != "") {
                            $.ajax({
                                url: 'modal_agil/selesaiKeep.php',
                                method: 'post',
                                data: {
                                    "user": user,
                                    "id": id,
                                    "sh": nosh,
                                },
                                success: (data) => {
                                    location.reload(true);
                                }
                            });
                        } else {
                            alert('Mohon isi No SH!');
                        }
                    });
                }
            });
        });


        $('#example tbody').on('click', '.cancel', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            var leveluser = $("#leveluser").val();
            var moduluser = $("#moduluser").val();
            alert(id);
        });
    });
    </script>