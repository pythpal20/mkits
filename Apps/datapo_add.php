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
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <?php include 'template/load_css.php';?>
    <!-- load css library -->
</head>

<body>
    <?php
    $ambil_customer ="SELECT * FROM master_customer ORDER BY customer_nama ASC";
    $ambil_perusahaan ="SELECT * FROM list_perusahaan ";
    $hasil_customer = mysqli_query($connect, $ambil_customer);
    $hasil_perusahaan = mysqli_query($connect, $ambil_perusahaan); 
  
    date_default_timezone_set('Asia/Jakarta');
    ?>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data PO Sales</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="datapo.php">Data PO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Data PO</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Input data Order Baru</h5>
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
                                <div class="form_header">
                                    <form id="formHeader">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Jenis Transaksi</label>
                                                    <select name="jTrans" id="jTrans" class="form-control" required>
                                                        <option value="">Pilih Jenis Transaksi</option>
                                                        <?php if($data['company'] == 'Showroom' || $data['company'] == 'Marketplace') { ?>
                                                            <option value="SHOWROOM">Showroom</option>
                                                            <option value="MARKETPLACE">Marketplace</option>
                                                            <option value="ONLINESTORE">Toko Online</option>
                                                        <?php } else { ?>
                                                            <option value="TELEPON">By Telepon</option>
                                                            <option value="KUNJUNGAN">By Kunjungan</option>
                                                            <!-- <option value="PTS">By PTS</option> -->
                                                        <?php } ?>
                                                        <?php if ($data['level'] == 'superadmin') { ?>
                                                        <option value="INTERNAL">Internal</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Nama Customer</label>
                                                    <select id="customer" class="form-control chosen-select-karyawan"
                                                        name="customer" data-placeholder="Pilih Customer ..."
                                                        tabindex="2" required>
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Status Customer</label>
                                                    <select id="statcust" name="statcust" class="form-control">
                                                        <option value="">= Pilih =</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="font-normal">No So Referensi</label>
                                                <input type="text" class="form-control" id="nopo_ref" name="nopo_ref">
                                            </div>
                                            <?php 
                                              $getwaktu = date('H:i');
                                              if ($getwaktu > '14:55') {
                                                $tglnow = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
                                                $waktu = '08:15:00';
                                              } else {
                                                $tglnow=date('Y-m-d');
                                                $waktu = date('H:i:s');
                                              }
                                            ?>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Sales</label>
                                                    <input type="text" name="sales" id="sales" class="form-control"
                                                        value="<?php echo $data['user_nama']; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="font-normal">Term Of Payment</label>
                                                    <input type="text" class="form-control" id="top" name="top" required
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Payment Method</label>
                                                    <input type="text" class="form-control" id="method" name="method"
                                                        required readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Tanggal Kirim</label>
                                                    <input type="date" id="tglkirim" name="tglkirim"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Jenis Perusahaan</label>
                                                    <select id="jenisPerusahaan" class="form-control "
                                                        name="jenisPerusahaan" data-placeholder="Pilih ..." tabindex="2"
                                                        required>
                                                        <option value="">--Pilih--</option>
                                                        <?php while($row_jenis_p = mysqli_fetch_array($hasil_perusahaan)) : ?>
                                                        <option value="<?= $row_jenis_p['id_perusahaan'] ?>">
                                                            <?=  $row_jenis_p['nama_pt']  ?>
                                                        </option>
                                                        <?php endwhile ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="font-normal">Ongkos Kirim</label>
                                                    <input type="text" name="ongkir" id="ongkir" class="form-control"
                                                        placeholder="Rp. ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="font-normal">Alamat Kirim</label>
                                                    <textarea id="alamatKirim" name="alamatKirim"
                                                        class="form-control prdalamatKirim"
                                                        style="height:100px"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="font-normal">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><input type="checkbox" class="i-checks pengajuan"
                                                            id="pengajuan" name="pengajuan" value="1"> <b>AJUKAN
                                                        HARGA</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Detail Pesanan</h5>
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
                                <div class="main_form">
                                    <form id="form1">
                                        <div class="text-center label label-danger">Item 1</div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>SKU</label>
                                                    <select name="sku" id="sku1" class="form-control chosen-select1 pilih">
                                                        <option value="">--Pilih SKU OR Barcode--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Harga Referensi</label>
                                                    <input type="text" name="prdHarga" placeholder="Harga Reff"
                                                        id="prdHarga1" class="form-control" readonly>
                                                    <input type="hidden" name="HrgBot" id="HrgBot1" class="form-control"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" id="sPromo1">
                                                <div class="form-group">
                                                    <label for="">Promo</label>
                                                    <select name="dsopromo" id="dsopromo1" class="form-control"></select>
                                                </div>
                                            </div>
                                              <input type="hidden" name="jenisPromo1" id="jenisPromo1">
                                            <input type="hidden" name="qty_min" id="qty_min1">
                                            <input type="hidden" name="diskon_tetap" id="diskon_tetap1">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="text" class="form-control" placeholder="Qty" name="qty"
                                                        id="qty1" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Harga</label>
                                                    <input type="text" class="form-control" placeholder="Harga"
                                                        name="harga" id="harga1" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="text" class="form-control" placeholder="amount"
                                                        name="amount" id="amount1" readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <label>Disc(%)</label>
                                                    <input type="text" class="form-control" placeholder="%disc"
                                                        value="0" name="percent_discount" id="percent_discount1" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Nom. Disc</label>
                                                    <input type="text" class="form-control" placeholder="Rp.disc"
                                                        name="nominal_discount" value="0" id="nominal_discount1" />
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <label> </label>
                                                    <div class="i-checks"><label> <input type="checkbox" id="ppn1"
                                                                name="ppn" value="10" class="form-control"> <i></i>PPN
                                                        </label></div>
                                                    <input type="hidden" name="hitungan_ppn" id="hitungan_ppn1">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Harga Total</label>
                                                    <input type="text" class="form-control" placeholder="total"
                                                        name="harga_total" id="harga_total1" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" name="ket" class="form-control"
                                                        placeholder="keterangan" id="ket1">
                                                </div>
                                            </div>
                                            <div class="col-sm-3" id="colpengajuan1">
                                                <div class="form-group">
                                                    <label>Harga Pengajuan</label>
                                                    <input type="text" name="hrg_pengajuan" id="hrg_pengajuan1"
                                                        class="form-control" placeholder="RP. " id="ket1">
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-success btn-xs m-b-xs text-white" id="pengajuan1">Ajukan
                                            Harga</a>
                                        <a class="btn btn-warning btn-xs m-b-xs" id="resetajuan1">Reset</a>
                                        <hr />
                                    </form>
                                </div>
                            </div>
                            <div class="ibox-footer">
                                <button class="btn btn-success simpan"><span class="fa fa-save (alias)"></span>
                                    Simpan</button>
                                <button class="btn btn-primary tambah"><span class="fa fa-plus"></span>
                                    Tambah Item</button>
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
    <script src="DataScript/addSco.js"></script>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('purchaseorder').setAttribute('class', 'active');
    });
    </script>
    <script type="text/javascript">
    // $("#statcust").hide();
    $('#customer').change(function() {
        var idcust = $("#customer").val();
        $.ajax({
            url: 'modal/getAlamat.php',
            method: 'post',
            dataType: 'json',
            data: {
                idcust: idcust
            },
            success: function(data) {
                // console.log(data);
                var reslt = data;
                $('#alamatKirim').val(reslt.alamat);
                $('#top').val(reslt.term);
                $('#method').val(reslt.method);
            }
        });

        $.ajax({
            url: 'modal/getStatus.php',
            method: 'POST',
            data: {
                idcust: idcust
            },
            success: function(hasil) {
                $("#statcust").html(hasil);
                // $("#statcust").show();
            }
        });
    });
    
    $("#jTrans").select2({
        allowClear: true,
        placeholder: "Pilih Jenis Transaksi"
    });
    </script>
</body>

</html>