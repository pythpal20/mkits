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
    <input type="hidden" id="lvls" value="<?php echo $data['modul']; ?>">
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Pengguna System
                        <?php if($data['modul'] == '1') { echo 'Sales & Marketing'; } elseif($data['modul'] == '2'){ echo 'Akunting & Finance';} elseif($data['modul'] == '3'){ echo 'Admin Penjualan'; }elseif($data['modul'] == '4'){ echo 'Delivery';}  ?>
                    </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data User</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <?php if($data['level'] == 'admin' OR $data['level'] == 'superadmin') : ?>
                        <button type="button" name="usr" id="usr" data-toggle="modal" data-target="#add_data_Modal"
                            class="btn btn-sm btn-info"><span class="fa fa-plus-circle"></span> Tambah User</button>
                        <?php endif ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data Pengguna</h5>
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
                                    <?php
                                        $mdl = $data['modul'];
                                    ?>
                                    <input type="hidden" name="level" id="lvlUser"
                                        value="<?php echo $data['level']; ?>">
                                    <table class="table table-striped" id="tableUser" width="100%">
                                        <thead scoop="row">
                                            <tr>
                                                <th style="min-width:5px">#</th>
                                                <th data-priority="1">Nama User</th>
                                                <th>No. Hp/Telp</th>
                                                <th>Email</th>
                                                <th>Company</th>
                                                <th>Level</th>
                                                <th>Status</th>
                                                <th data-priority="2">Aksi</th>
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
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('akun').setAttribute('class', 'active');
    });
    $(document).ready(function() {
        var lev = $('#lvls').val();
        if (lev == 3) {
            setInterval(function() {
                $.ajax({
                    url: 'modal/getQtysco_in.php',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        var reslt = data;
                        $('#sqty').html(reslt.dataun);
                        $('#sqlqty').html(reslt.dataun);
                    }
                });
            }, 1000);
        } else if (lev == 2) {
            setInterval(function() {
                $.ajax({
                    url: 'modal/getLabel.php',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        var reslt = data;
                        $('#aklabel').html(reslt.dataun);
                    }
                });
            }, 1000);
        }

    });
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        if (lvl == "admin" || lvl == "superadmin") {
            var table = $('#tableUser').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/data_user.php?ide=<?php echo $mdl; ?>",
                responsive: true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-primary btn-xs tblEdit' tooltip='Edit'><span class='fa fa-edit'></span> </button> <button class='btn btn-danger btn-xs tblDelete'><span class='fa fa-trash'></span> </button></center>"
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return '<span class="label label-info">Aktif</label>'
                        } else {
                            return '<span class="label label-danger">Non-Aktif</label>'
                        }
                    }
                }]
            });
        } else {
            var table = $('#tableUser').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/data_user.php?ide=<?php echo $mdl; ?>",
                responsive: true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-info btn-sm disabled' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button></center>"
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == '1') {
                            return '<span class="label label-info">Aktif</label>'
                        } else {
                            return '<span class="label label-danger">Non-Aktif</label>'
                        }
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

        $('#tableUser tbody').on('click', '.view_data', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "route/dtlCustomer.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#viewCust').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });

        $('#tableUser tbody').on('click', '.tblEdit', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var iduser = data[0];
            $.ajax({
                url: "user_edit.php",
                method: "POST",
                data: {
                    iduser: iduser
                },
                success: function(data) {
                    $('#form_edit').html(data);
                    $('#editModal').modal('show');
                }
            });
        });

        $('#tableUser tbody').on('click', '.tblDelete', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            swal.fire({
                title: 'Non-aktifkan user?',
                text: "Akun yang dinon-aktifkan tidak dapat login MKITS lagi",
                imageUrl: '../img/system/undraw_Questions.png',
                imageHeight: 200,
                showCancelButton: true,
                confirmButtonColor: '#66CDAA',
                cancelButtonColor: '#F4A460',
                confirmButtonText: 'Yes, Non-aktifkan',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        url: "user_delete.php",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire({
                                title:'Di Non-Aktifkan',
                                text:'Akun ini telah dinon-aktifkan',
                                icon:'success',
                                showCancelButton: false,
                                allowOutsideClick: false
                            }).then((rlt) => {
                                if(rlt.isConfirmed) {
                                    location.assign("user.php");
                                }
                            });
                        }
                    });
                } else if(
                        result.dismiss == Swal.DismissReason.cancel
                ) {
                    swal.fire(
                        'Batal',
                        'Non-aktifkan dibatalkan',
                        'error'
                    )
                }
            });
        });

    });
    </script>
    <script>
    $(document).ready(function() {
        $('#insert_form').on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: "user_add.php",
                method: "POST",
                data: $('#insert_form').serialize(),
                beforeSend: function() {
                    $('#insert').val("Inserting");
                },
                success: function(data) {
                    $('#insert_form')[0].reset();
                    $('#add_data_Modal').modal('hide');
                    // console.log(data);
                    Swal.fire(data);
                    setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "user.php");
                        },
                        2000);
                }
            });
        });
    });
    </script>
    <script>
    function change() {
        var x = document.getElementById('password').type;
        if (x == 'password') {
            document.getElementById('password').type = 'text';
            document.getElementById('mybutton').innerHTML = `<i class="fa fa-eye-slash"></i>`;
        } else {
            document.getElementById('password').type = 'password';
            document.getElementById('mybutton').innerHTML = `<i class="fa fa-eye"></i>`;
        }
    }
    </script>
    <div id="add_data_Modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <?php
                    $ambil = "SELECT MAX(user_id) as idArr FROM master_user";
                    $mwk = $db1->prepare($ambil);
                    $mwk -> execute();
                    $res1 = $mwk->get_result();
                    while ($sb = $res1->fetch_assoc()) {
                    $IdUser  = $sb['idArr'];
                    $urutan = (int) substr($IdUser, 3, 3);
                    $urutan++;
                    $huruf = "SO";
                    $IdUser = $huruf ."-". sprintf("%03s", $urutan);
                    }
                ?>
                <div class="modal-body" id="add_data_Modal">
                    <div class="container">
                        <form method="post" id="insert_form">
                            <input type="hidden" name="iduser" id="iduser" class="form-control"
                                value="<?php echo $IdUser; ?>" readonly>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nama User</label>
                                        <input type="text" name="nama" id="nama" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>No. HP/Telp</label>
                                        <input type="text" name="kontak" id="kontak" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" id="email" class="form-control" required=""
                                            placeholder="youremail@domain">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Username</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control"
                                                required="">
                                            <div class="input-group-append">
                                                <span id="mybutton" onclick="change()" class="input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Company</label>
                                        <select class="form-control" name="comm" id="comm" required="">
                                            <option value="">Pilih Company</option>
                                            <option value="Foodpack">Foodpack</option>
                                            <option value="Mr.Kitchen">Mr. Kitchen</option>
                                            <option value="Marketplace">Marketplace</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Level User</label>
                                        <select class="form-control" name="level" id="level" required="">
                                            <option value="">Pilih Level</option>
                                            <!-- modul sales & marketing -->
                                            <?php if($data['modul'] == '1'){ ?>
                                            <?php if ($data['level'] == 'superadmin') : ?>
                                            <option value="superadmin">Super Admin</option>
                                            <?php endif ?>
                                            <option value="admin">Admin</option>
                                            <option value="sales">Sales</option>
                                            <option value="guest">Guest</option>
                                            <!-- modul akunting & Finance -->
                                            <?php } elseif($data['modul'] == '2'){ ?>
                                            <?php if($data['level'] == 'superadmin') : ?>
                                            <option value="superadmin">Super Admin</option>
                                            <?php endif; ?>
                                            <option value="admin">Admin</option>
                                            <option value="guest">Guest</option>
                                            <!-- modul Admin Penjualan -->
                                            <?php }elseif($data['modul'] == '3') { ?>
                                            <option value="superadmin">Super Admin</option>
                                            <option value="admin">Admin</option>
                                            <option value="guest">Guest</option>
                                            <!-- modul Delivery -->
                                            <?php }elseif($data['modul'] == '4'){ ?>
                                            <?php if($data['level'] == 'superadmin') : ?>
                                            <option value="superadmin">Super Admin</option>
                                            <?php endif; ?>
                                            <option value="admin">Admin</option>
                                            <?php }elseif($data['modul'] == '5') { ?>
                                            <?php if($data['level'] == 'superadmin') : ?>
                                            <option value="superadmin">Super Admin</option>
                                            <?php endif; ?>
                                            <option value="admin">Admin</option>
                                            <option value="sopir">Sopir</option>
                                            <option value="guest">Guest</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="addBy" id="addBy" value="<?php echo $data['user_nama']; ?>">
                            <input type="hidden" name="addDate" id="addDate" value="<?php echo date('Y-m-d'); ?>">
                            <input type="hidden" name="modultype" id="modultype" value="<?php echo $data['modul']; ?>">
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <button class="btn btn-primary" id="submit" type="submit"><span
                                            class="fa fa-check"></span>
                                        Simpan</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span
                                            class="fa fa-window-close"></span> Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="form_edit">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>