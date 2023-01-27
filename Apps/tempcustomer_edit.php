<?php
    // var_dump($_GET);
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
                    <h2>Temp. Customer</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="tempcustomer.php">Temp. Customer</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $idc = $_GET['id'];
                
                $qry = "SELECT * FROM temp_customer a JOIN master_wilayah b
                ON a.kota = b.wilayah_id WHERE a.ID = '$idc'";
				$mwk = $db1->prepare($qry);
				$mwk->execute();
				$reslt = $mwk->get_result();
				$rw = $reslt->fetch_assoc();

                $wil = "SELECT wilayah_nama, wilayah_id FROM master_wilayah WHERE wilayah_id = '". substr($rw['kota'],0,2) ."'";
                $mwk = $db1->prepare($wil);
				$mwk->execute();
				$res = $mwk->get_result();
				$rws = $res->fetch_assoc();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Ubah data</h5>
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
                                <form method="POST" id="updateForm">
                                    <div class="row">
                                        <?php if($rw['customer_idregister'] == NULL) : ?>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ID Register</label>
                                                <input type="text" name="idRegis" id="idRegis" class="form-control"
                                                    placeholder="Isi jika sudah teregisterasi">
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nama Customer</label>
                                                <input type="text" name="nama_customer" id="nama_customer"
                                                    class="form-control" value="<?= $rw['customer_nama'] ?>" required>
                                                <input type="hidden" name="idcust" id="idcust" value="<?= $rw['ID']?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Kategori Customer</label>
                                                <select name="kategori" id="kategori" class="form-control dataCtr"
                                                    required>
                                                    <option value="<?= $rw['jenis_usaha'] ?>">
                                                        <?= $rw['jenis_usaha'] ?>
                                                    </option>
                                                    <?php
                                                        $sql = "SELECT * FROM master_kategori ORDER BY kategori_nama";
                                                        $mwk = $db1->prepare($sql);
                                                        $mwk->execute();
                                                        $resl = $mwk->get_result();
                                                        while ($ct=$resl->fetch_assoc()){
                                                        echo '<option value="'.$ct['kategori_nama'].'">'.$ct['kategori_nama'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Telp.</label>
                                                <input type="text" name="telp" class="form-control"
                                                    placeholder="No. telp" value="<?= $rw['notelp'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>No. Hp</label>
                                                <input type="text" name="nohp" class="form-control" placeholder="No. Hp"
                                                    value="<?= $rw['nohp']?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Provinsi</label>
                                                <select id="prov" name="prov" class="form-control selectProv" required>
                                                    <option value="<?= $rws['wilayah_id']?>">
                                                        <?= $rws['wilayah_nama']?></option>
                                                    <?php
                                                        $provinsi = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE CHAR_LENGTH(wilayah_id)=2 ORDER BY wilayah_id";
                                                        $mwk = $db1->prepare($provinsi);
                                                        $mwk->execute();
                                                        $resl = $mwk->get_result();
                                                        while($pv=$resl->fetch_assoc()){
                                                        echo '<option value="'.$pv['wilayah_id'].'">'.$pv['wilayah_nama'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Kabupaten/Kota</label>
                                                <select name="kab" id="kab" class="form-control selectKab" required="">
                                                    <option value="<?= $rw['wilayah_id']?>"><?= $rw['wilayah_nama']?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php 
                                            if($rw['status'] == '0'){
                                                $stat = 'Tutup Permanen';
                                            }elseif($rw['status'] == '1'){
                                                $stat = 'Aktif';
                                            }else {
                                                $stat = 'Tidak Aktif';
                                            }
                                        ?>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select id="sts" name="sts" class="form-control">
                                                    <option value="<?= $rw['status']?>"><?= $stat ?></option>
                                                    <option value="0">Tutup Permanen</option>
                                                    <option value="1">Aktif</option>
                                                    <option value="2">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Pemilik/PIC/Penanggung Jawab</label>
                                                <input type="text" name="pic" id="pic" class="form-control"
                                                    placeholder="Nama PIC" required value="<?= $rw['pic'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Alamat Customer</label>
                                                <textarea class="form-control" name="almtCustomer" id="almtCustomer"
                                                    required><?= $rw['detail_alamat']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger back"><span class="fa fa-arrow-circle-left"></span>
                                        Batal</button>
                                    <button class="btn btn-info simpan"><span class="fa fa-save (alias)"></span>
                                        Simpan</button>
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
    <script src="../assets/js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
    <script>
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });
        document.getElementById('bankData').setAttribute('class', 'active');
    });
    $(document).ready(function() {

        $('.selectProv').select2();
        $('#kategori').select2();

        $('body').on("change", "#prov", function() {
            var id = $(this).val();
            var data = "id=" + id + "&data=kabupaten";
            $.ajax({
                type: 'POST',
                url: "modal/getKabupaten.php",
                data: data,
                success: function(hasil) {
                    $("#kab").html(hasil);
                    $('.selectKab').select2();
                    $("#kab").show();
                    // console.log(hasil);
                }
            });
        });

        $.get('modal/listnama.php', function(data) {
            // console.log(data);
            $("#nama_customer").typeahead({
                source: data
            });
        }, 'json');
        $(document).ready(function() {
            document.getElementById('bankData').setAttribute('class', 'active');
        });
        $(document).ready(function() {
            $(".back").click(function() {
                window.history.back();
            });

            $('.selectProv').select2();
            $('#kategori').select2();

            $('body').on("change", "#prov", function() {
                var id = $(this).val();
                var data = "id=" + id + "&data=kabupaten";
                $.ajax({
                    type: 'POST',
                    url: "modal/getKabupaten.php",
                    data: data,
                    success: function(hasil) {
                        $("#kab").html(hasil);
                        $('.selectKab').select2();
                        $("#kab").show();
                        // console.log(hasil);
                    }
                });
            });

            $.get('modal/listnama.php', function(data) {
                console.log(data);
                $("#nama_customer").typeahead({
                    source: data
                });
            }, 'json');

            $('#updateForm').on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "modal/tempcust_edit.php",
                    method: "POST",
                    data: $('#updateForm').serialize(),
                    beforeSend: function() {
                        $('#insert').val("Inserting");
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire(
                            'Good Job!',
                            'Data berhasil diubah',
                            'success'
                        );
                        setTimeout(function() {
                                // your code to be executed after 1 second
                                location.assign(
                                    "tempcustomer.php");
                            },
                            2000);
                    }
                });
            });
        });
    });
    </script>

</body>

</html>