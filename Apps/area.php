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
                    <h2>Data Provinsi dan Kabupaten</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data Area</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data Wilayah</h5>
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
                                <div class="col-sm-6">
                                    <div class="from-group">
                                        <label>Pilih Provinsi</label>
                                        <select name="prov" id="prov" class="form-control chosen-select1 pilih">
                                            <option value="">--Pilih Provinsi--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="viewWilayah" style="display: none">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data Kab./ Kota</h5>
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
                                <div class="col-sm-12">
                                    <div id="tableWilayah" class="tblData">

                                    </div>
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
        document.getElementById('masterarea').setAttribute('class', 'active');
    });
    </script>

    <script>
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });
        $.ajax({
            url: "modal/getProvinsi.php",
            method: "get",
            success: function(data) {
                $('.chosen-select1').select2({

                });
                $('.chosen-select1').append(data);
                $('.chosen-select1').trigger("chosen:updated");
            },
        });

        $("#prov").change(() => {
            var idprov = $("#prov").val();
            $.ajax({
                url: 'modal/viewKota.php', // buat file selectData.php terpisah
                method: 'POST',
                data: {
                    idprov: idprov
                },
                success: function(data) {
                    // console.log(data);
                    $("#viewWilayah").show();
                    $('.tblData').footable();
                    $('#tableWilayah').empty(data);
                    $("#tableWilayah").append(data);
                }
            });
        });
    });
    </script>
</body>

</html>