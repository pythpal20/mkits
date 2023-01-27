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
                    <h2>Data Customer</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="customer.php">Temp. Customer</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Temp. Customer</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form tambah Customer</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" id="lvl" value="<?php echo $data['level']; ?>">
                            <div class="ibox-content">
                                <form method="POST" id="insert_form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ID Register <small class="text-warning">(*Tidak
                                                        Wajib)</small></label>
                                                <input type="text" name="idRegis" id="idRegis" class="form-control"
                                                    placeholder="Isi jika sudah teregisterasi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nama Customer</label>
                                                <input type="text" name="nama_customer" id="nama_customer" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Kategori Customer</label>
                                                <select name="kategori" id="kategori" class="form-control dataCtr"
                                                    required="">
                                                    <option value="">= Pilih Kategori =</option>
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
                                                    placeholder="No. telp">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>No. Hp</label>
                                                <input type="text" name="nohp" class="form-control"
                                                    placeholder="No. Hp" title="Yang bener input nomornya" pattern="[0-9]{2}[1-9]{2}[0-9]{4,9}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Provinsi</label>
                                                <select id="prov" name="prov" class="form-control selectProv"
                                                    required="">
                                                    <option value="">Pilih Provinsi</option>
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
                                                    <option value="">*Pilih Provinsi Terlebih Dahulu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Pemilik/PIC/Penanggung Jawab</label>
                                                <input type="text" name="pic" id="pic" class="form-control"
                                                    placeholder="Nama PIC" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Alamat Customer</label>
                                                <textarea class="form-control" name="almtCustomer" id="almtCustomer"
                                                    required=""></textarea>
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

        $('#insert_form').on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: "modal/tempcustomer_add.php",
                method: "POST",
                data: $('#insert_form').serialize(),
                beforeSend: function() {
                    $('#insert').val("Inserting . . .");
                },
                success: function(data) {
                    // console.log(data);
                    Swal.fire(
                        'Sukses',
                        'Data sudah ditambahkan',
                        'success'
                    );
                    setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "tempcustomer.php");
                        },
                        3000);
                }
            });
        });
    });
    </script>
</body>

</html>