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
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Master Produk</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="masterproduk.php">Data Produk</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Tambah Produk</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Tambah Produk</h5>
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
                                <form method="POST" id="formProduk">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>SKU</label>
                                                <input type="text" name="model" id="model" class="form-control"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Barcode</label>
                                                <input type="text" name="barcode" id="barcode" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <input type="text" name="kat" id="kat" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <input type="text" name="desk" id="desk" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input type="text" name="hrg" id="hrg" class="form-control" required
                                                    placeholder="Rp. ">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success simpan"><span class="fa fa-save (alias)"></span>
                                        Simpan</button>
                                    <button class="btn btn-warning back"><span
                                            class="fa fa-times-rectangle (alias)"></span> Batal</button>
                                </form>
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
        document.getElementById('masterproduk').setAttribute('class', 'active');
    });
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });
        $('#formProduk').on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: "masterproduk_addproses.php",
                method: "POST",
                data: $('#formProduk').serialize(),
                beforeSend: function() {
                    $('#insert').val("Inserting");
                },
                success: function(data) {
                    // console.log(data);
                    Swal.fire(data);
                    setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "masterproduk.php");
                        },
                        2000);
                }
            });
        });
    });
    </script>
</body>

</html>