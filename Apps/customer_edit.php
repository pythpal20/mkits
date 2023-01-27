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
                            <a href="customer.php">Customer</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit Customer</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $idc = $_GET['id'];
                
                $qry = "SELECT * FROM master_customer WHERE customer_id = '$idc'";
				$mwk = $db1->prepare($qry);
				$mwk->execute();
				$reslt = $mwk->get_result();
				$rw = $reslt->fetch_assoc();
				
				$sls = "SELECT user_id, user_nama FROM master_user WHERE user_id = '" . $rw["customer_sales"] . "'";
				$mwk = $db1-> prepare($sls);
				$mwk-> execute();
				$resls = $mwk->get_result();
				$rws = $resls->fetch_assoc();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Ubah Customer</h5>
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
                                        <input type="hidden" name="idc" id="idc" value="<?php echo $idc; ?>">
                                        <input type="hidden" name="idRegister" id="idRegister"
                                            value="<?php echo $rw['customer_idregister']; ?>">
                                        <input type="hidden" name="inputby" id="inputby"
                                            value="<?php echo $data['user_nama']; ?>">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nama Customer <sup style="color:red">*</sup></label>
                                                <input type="text" name="nama_customer" id="nama_customer"
                                                    class="form-control" autocomplete="off"
                                                    value="<?php echo $rw['customer_nama']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Nama Sales <sup style="color:red">*</sup></label>
                                                <select name="idsales" id="idsales" class="form-control">
                                                  <option value="<?= $rws['user_id'];?>"><?= $rws['user_nama'];?></option>
                                                    <?php 
                                                        $qry_sales = "SELECT * FROM master_user WHERE `level` = 'sales' AND status = '1'";
                                                        $mwk = $db1->prepare($qry_sales);
                                                        $mwk -> execute();
                                                        $res_sales = $mwk->get_result();
                                                        while ($r_sales = $res_sales->fetch_assoc()) {
                                                            echo '<option value = "' . $r_sales['user_id'] .'">' . $r_sales['user_nama'] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Kategori Customer</label>
                                                <select name="kategori" id="kategori" class="form-control" required="">
                                                    <option value="<?php echo $rw['customer_kategori']; ?>">
                                                        <?php echo $rw['customer_kategori']; ?></option>
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
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Telp.</label>
                                                <input type="text" name="telp" class="form-control"
                                                    placeholder="No. telp" value="<?php echo $rw['customer_telp']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>No. Handphone <sup style="color:red">*</sup></label>
                                                <input type="text" name="nohp" class="form-control"
                                                    placeholder="Nomor HP Customer"
                                                    title="No Hp. Harus lengkap dan benar ya ..."
                                                    pattern="[0-9]{2}[1-9]{2}[0-9]{4,9}"
                                                    value="<?php echo $rw['customer_nohp']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">No. Fax</label>
                                                <input type="text" name="nofax" class="form-control" id="nofax"
                                                    value="<?php echo $rw['customer_fax']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">E-Mail</label>
                                                <input type="text" id="email" class="form-control" name="email"
                                                    placeholder="customer-acc@domain.com"
                                                    value="<?php echo $rw['customer_email']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Web-Site</label>
                                                <input type="text" id="web" class="form-control" name="web"
                                                    placeholder="www.your-url.com"
                                                    value="<?php echo $rw['customer_web']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border:1px solid red;">
                                    <?php
										error_reporting(0);
										$qry2 = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE wilayah_id = '". $rw['customer_provinsi'] ."'";
										$mwk = $db1->prepare($qry2);
										$mwk->execute();
										$hasil = $mwk->get_result();
										$prop = $hasil->fetch_assoc();
									?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Provinsi <sup style="color:red">*</sup></label>
                                                <select id="prov" name="prov" class="form-control selectProv" required>
                                                    <option value="<?php echo $prop['wilayah_id']; ?>">
                                                        <?php echo $prop['wilayah_nama']; ?></option>
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
                                        <?php
                                            error_reporting(0);
                                            $qry3 = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE wilayah_id = '". $rw['customer_kota'] ."'";
                                            $mwk = $db1->prepare($qry3);
                                            $mwk->execute();
                                            $hasil = $mwk->get_result();
                                            $prop3 = $hasil->fetch_assoc();
									    ?>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Kabupaten/Kota <sup style="color:red">*</sup></label>
                                                <select name="kab" id="kab" class="form-control selectKab" required>
                                                    <option value="<?php echo $prop3['wilayah_id']; ?>">
                                                        <?php echo $prop3['wilayah_nama']; ?></option>
                                                    <?php
													$provinsi = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE CHAR_LENGTH(wilayah_id)=5 ORDER BY wilayah_id";
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
                                        <?php
                                            error_reporting(0);
                                            $qry4 = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE wilayah_id = '". $rw['customer_kecamatan'] ."'";
                                            $mwk = $db1->prepare($qry4);
                                            $mwk->execute();
                                            $hasil = $mwk->get_result();
                                            $prop4 = $hasil->fetch_assoc();
									    ?>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Kecamatan <sup style="color:red">*</sup></label>
                                                <select name="kec" id="kec" class="form-control selectKec" required>
                                                    <option value="<?php echo $prop4['wilayah_id']; ?>">
                                                        <?php echo $prop4['wilayah_nama']; ?></option>
                                                    <?php
													$provinsi = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE CHAR_LENGTH(wilayah_id)=8 ORDER BY wilayah_id";
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
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Alamat Customer <sup style="color:red">*</sup></label>
                                                <textarea class="form-control" name="almtCustomer" id="almtCustomer"
                                                    required="" style="height:75px"> <?php echo $rw['customer_alamat']; ?>
                                                    </textarea>
                                            </div>
                                        </div>
                                        <div class=" col-sm-6">
                                            <div class="form-group">
                                                <label>Alamat Kirim <sup style="color:red">*</sup></label>
                                                <textarea class="form-control" name="almtKirim" id="almtKirim"
                                                    style="height:75px"> <?php echo $rw['customer_alamat_krm']; ?> 
                                                   </textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="kode_wilayah" id="kodeWil">
                                        <div class="col-sm-2">
                                            <div class="from-group">
                                                <label for="">Kode POS</label>
                                                <input type="text" class="form-control" id="kodepos" name="kodepos"
                                                    placeholder="kode pos" value="<?php echo $rw['customer_pos']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border:1px solid red;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nama <small>Penanggung Jawab</small> (1) <sup
                                                        style="color:red">*</sup></label>
                                                <input type="text" name="pic" id="pic" class="form-control"
                                                    value="<?php echo $rw['pic_nama'];?>" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="jabatan">Jabatan <small>(person-1)</small> <sup
                                                        style="color:red">*</sup></label>
                                                <select name="jabatan1" id="jabatan1" class="form-control" required>
                                                    <option value="<?= $rw['pic_jabatan'];?>">
                                                        <?= $rw['pic_jabatan'];?>
                                                    <option value="PIC">PIC</option>
                                                    <option value="GM">GM</option>
                                                    <option value="PEMILIK">OWNER</option>
                                                    <option value="PURCHASING">PURCHASING</option>
                                                    <option value="KEUANGAN">ACCOUNTING</option>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Hp/ Telp <small>Penanggung
                                                        jawab</small> (1)<sup style="color:red">*</sup></label>
                                                <input type="text" name="kontak" id="kontak" class="form-control"
                                                    value="<?php echo $rw['pic_kontak'];?>" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">E-Mail</label>
                                                <input type="text" class="form-control" id="emailpic1" name="emailpic1"
                                                    value="<?php echo $rw['pic_email'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="noktp">No KTP <small>Penanggung jawab</small>
                                                    (1)</label>
                                                <input type="number" class="form-control" id="noktp1" name="noktp1"
                                                    placeholder="16 Digit" value="<?php echo $rw['pic_noktp'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Alamat PIC</label>
                                                <textarea class="form-control" name="almtPic" id="almtPic"
                                                    style="height:75px"><?php echo $rw['pic_alamat'];?>
                                                   </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <a class="btn btn-rounded btn-primary addperson"><span
                                                        class="fa fa-plus text-white" id="addperson"></span> <b
                                                        class="text-white">Tambah
                                                        Penanggung Jawab</b></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="persontwo">
                                        <hr style="border: 1px solid red;">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Nama <small>Penanggung Jawab</small> (2)</label>
                                                    <input type="text" name="pic2" id="pic2" class="form-control"
                                                    value="<?php echo $rw['pic_nama2'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="jabatan">Jabatan <small>(person-2)</small></label>
                                                    <select name="jabatan2" id="jabatan2" class="form-control">
                                                        <option value="<?= $rw['pic_jabatan2'];?>
                                                            <?= $rw['pic_jabatan2'];?>
                                                        <option value="PIC">PIC</option>
                                                        <option value="GM">GM</option>
                                                        <option value="PEMILIK">OWNER</option>
                                                        <option value="PURCHASING">PURCHASING</option>
                                                        <option value="KEUANGAN">ACCOUNTING</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Hp/ Telp <small>Penanggung
                                                            jawab</small> (2)</label>
                                                    <input type="text" name="kontak2" id="kontak2" class="form-control"
                                                    value="<?php echo $rw['pic_kontak2'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">E-Mail</label>
                                                    <input type="text" class="form-control" id="emailpic2" name="emailpic2"
                                                    value="<?php echo $rw['pic_email2'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="noktp">No KTP <small>Penanggung jawab</small>
                                                        (2)</label>
                                                    <input type="number" class="form-control" id="noktp2" name="noktp2"  placeholder="16 Digit"
                                                    value="<?php echo $rw['pic_noktp2'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Alamat <small>Penanggung Jawab</small> (2)</label>
                                                    <textarea class="form-control" name="almtPic2" id="almtPic2"
                                                        placeholder="alamat penanggung jawab"
                                                        style="height:75px"><?php echo $rw['pic_alamat2'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border: 1px solid red;">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Nama <small>Penanggung Jawab</small> (3)</label>
                                                    <input type="text" name="pic3" id="pic3" class="form-control"
                                                    value="<?php echo $rw['pic_nama3'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="jabatan">Jabatan <small>(person-3)</small></label>
                                                    <select name="jabatan3" id="jabatan3" class="form-control">
                                                        <option value="<?= $rw['pic_jabatan3'];?>">
                                                            <?= $rw['pic_jabatan3'];?>
                                                        <option value="PIC">PIC</option>
                                                        <option value="GM">GM</option>
                                                        <option value="PEMILIK">OWNER</option>
                                                        <option value="PURCHASING">PURCHASING</option>
                                                        <option value="KEUANGAN">ACCOUNTING</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Hp/ Telp <small>Penanggung
                                                            jawab</small> (3)</label>
                                                    <input type="text" name="kontak3" id="kontak3" class="form-control"
                                                    value="<?php echo $rw['pic_kontak3'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">E-Mail</label>
                                                    <input type="text" class="form-control" id="emailpic3"  name="emailpic3"
                                                    value="<?php echo $rw['pic_email3'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="noktp">No KTP <small>Penanggung jawab</small>
                                                        (3)</label>
                                                    <input type="number" class="form-control" id="noktp3" name="noktp3" placeholder="16 Digit"
                                                    value="<?php echo $rw['pic_noktp3'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Alamat <small>Penanggung Jawab</small> (3)</label>
                                                    <textarea class="form-control" name="almtPic3" id="almtPic3"
                                                        placeholder="alamat penanggung jawab"
                                                        style="height:75px"><?php echo $rw['pic_alamat3'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid red;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="from-group">
                                                <label for="">Nama Bank</label>
                                                <select name="namabank" id="namabank" class="form-control namabank">
                                                    <option value="<?= $rw['bank_nama'];?>"><?= $rw['bank_nama'];?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Atas Nama/ Nama pemilik</label>
                                                <input type="text" class="form-control" id="atasnama" name="atasnama"
                                                    placeholder="Nama pemilik akun bank"
                                                    value="<?php echo $rw['bank_nama_akun'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">No. Rekening</label>
                                                <input type="text" class="form-control" id="rekening" name="rekening"
                                                    value="<?php echo $rw['bank_norek'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Cabang Bank</label>
                                                <input type="text" class="form-control" id="cabang" name="cabang"
                                                    value="<?php echo $rw['bank_cabang'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="">Alamat Bank</label>
                                                <textarea name="alamatbank" id="alamatbank" cols="40" rows="5"
                                                    style="height:75px"
                                                    class="form-control"> <?php echo $rw['bank_alamat'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger back"><span class="fa fa-arrow-circle-left"></span>
                                        Batal</button>
                                    <button class="btn btn-success simpan"><span class="fa fa-save (alias)"></span>
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

    </script>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('mastercustomer').setAttribute('class', 'active');

    });

    $(document).ready(function() {
        $.getJSON('../config/data_bank.json', function(data) {
            $.each(data, function(key, value) {
                var obj = value;

                $(" .namabank").append('<option value="' + value.name + '">' + value.code +
                    ' | ' +
                    value.name + '</option>')
                // console.log(value.code);
            });
        });
        $("#namabank").select2({
            placeholder: 'Pilih: Kode Bank | Nama Bank'
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".back").click(function() {
            window.history.back();
        });
        $.get('modal/listnama.php', function(data) {
            // console.log(data);
            $("#nama_customer").typeahead({
                source: data
            });
        }, 'json');
        $('.dataMethod').chosen();
        $('.dataTerm').chosen();
        $('.dataCtr').chosen();
        $('#idsales').select2();
        $('#jabatan1').chosen();
        // sembunyikan form kabupaten, kecamatan dan desa
        // $("#kab").hide();
        $('.selectProv').select2();
        $('.selectKec').select2();
        $('.selectKab').select2();
        // ambil data kabupaten ketika data memilih provinsi
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

        $('body').on("change", "#kab", function() {
            var id = $(this).val();
            var data = "id=" + id + "&data=kecamatan";
            $.ajax({
                type: "POST",
                url: "modal/getKabupaten.php",
                data: data,
                success: function(hasil) {
                    $("#kec").html(hasil);
                    $(".selectKec").select2();
                    $("#kec").show();
                }
            });
        });
        $("#kategori").change(() => {
            var idKat = $("#kategori").val();
            // console.log(idKat);
            $.ajax({
                url: 'modal/getKodeKat.php',
                method: 'post',
                dataType: "json",
                data: {
                    idKat: idKat
                },
                success: (data) => {
                    // console.log(data);
                    $("#kodeKat").val(data);
                }
            });
        });
        $("#kab").change(() => {
            var idKab = $("#kab").val();
            // console.log(idKab);
            $.ajax({
                url: 'modal/getKodeKab.php',
                method: 'post',
                dataType: "json",
                data: {
                    idKab: idKab
                },
                success: (data) => {
                    // console.log(data);
                    $("#kodeWil").val(data);
                }
            });
        });
        $("#persontwo").hide();
        $(".addperson").click(() => {
            $("#persontwo").show();
            $(".addperson").hide();
        });
        $('#updateForm').on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: "customer_editproses.php",
                method: "POST",
                data: $('#updateForm').serialize(),
                beforeSend: function() {
                    $('#insert').val(
                        "Inserting");
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire(data);
                    setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "customer.php"
                            );
                        },
                        2000);
                }
            });
        });
    });
    </script>
</body>

</html>