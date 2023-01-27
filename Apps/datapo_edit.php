<?php
include '../config/connection.php';

session_start();
$akses = $_SESSION['moduls'];
if (!isset($_SESSION['usernameu']) || $akses !== '1') {
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
    <?php include 'template/load_css.php'; ?>
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
                    <h2>Data PO Sales</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="datapo.php">Data PO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit Data PO</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php
            $noso = $_GET['id'];
            include '../config/connection.php';
            $ambil_perusahaan = "SELECT * from list_perusahaan ";
            $query = "SELECT * FROM salesorder_dtl WHERE noso='" . $_GET['id'] . "'";
            $header =  "SELECT * FROM salesorder_hdr WHERE noso='" . $_GET['id'] . "'";
            $ambil_customer = "SELECT * from master_customer where customer_idregister !=''";

            $result = mysqli_query($connect, $query);
            $result_header = mysqli_query($connect, $header);
            $hasil_customer = mysqli_query($connect, $ambil_customer);
            $hasil_perusahaan = mysqli_query($connect, $ambil_perusahaan);

            $total_row = mysqli_num_rows($result);
            function cari_nama_customer($id)
            {
                include '../config/connection.php';
                $query = "SELECT customer_nama FROM master_customer WHERE customer_id='$id'";
                $result = mysqli_query($connect, $query);
                $arr = "";
                while ($row = mysqli_fetch_array($result)) {
                    # code...
                    $arr =  $row['customer_nama'];
                }
                return $arr;
            }

            function cari_customer_nama($id)
            {
                include '../config/connection.php';
                $query = "SELECT * FROM list_perusahaan WHERE id_perusahaan='$id'";
                $result = mysqli_query($connect, $query);
                $arr = "";
                while ($row = mysqli_fetch_array($result)) {
                    # code...
                    $arr =  $row['nama_pt'];
                }
                return $arr;
            }
            ?>
            <?php while ($item = mysqli_fetch_array($result_header)) : ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Form Edit data Order Baru</h5>
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
                                    <div class="form_header">
                                        <form id="formHeader">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <!-- nama customer -->
                                                    <div class="form-group">
                                                        <input name="nopo" type="hidden" value="<?= $noso ?>">
                                                        <label class="font-normal">Nama Customer</label>
                                                        <select id="customer" class="form-control chosen-select-karyawan" name="customer" data-placeholder="Pilih Konsumen ..." tabindex="2" required>
                                                            <option value="<?= $item['customer_id'] ?>">
                                                                <?= cari_nama_customer($item['customer_id']) ?>
                                                            </option>
                                                            <?php while ($row = mysqli_fetch_array($hasil_customer)) : ?>
                                                                <option value="<?= $row['customer_id'] ?>">
                                                                    <?= $row['customer_nama']  ?>
                                                                </option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <!--  -->
                                                    <div class="form-group">
                                                        <label class="font-normal">Nopo Referensi</label>
                                                        <input type="text" class="form-control" id="nopo_ref" name="nopo_ref" value="<?= $item['noso_ref'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="font-normal">Tanggal Order</label>
                                                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $item['tgl_po'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Sales</label>
                                                        <input type="text" value="<?= $item['sales'] ?>" name="sales" id="sales" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="font-normal">Tanggal Kirim</label>
                                                        <input type="date" id="tglkirim" name="tglkirim" class="form-control" required="" value="<?= $item['tgl_krm'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="font-normal">Term Of Payment</label>
                                                        <select id="top" name="top" class="form-control chosen-select-top">
                                                            <option value="<?= $item['term'] ?>"><?= $item['term'] ?></option>
                                                            <option value="Cash On Delivery">Cash On Delivery</option>
                                                            <option value="Cash Before Delivery">Cash Before Delivery
                                                            </option>
                                                            <option value="Transfer">Transfer</option>
                                                            <option value="TOP 7 Hari">TOP 7 Hari</option>
                                                            <option value="TOP 14 Hari">TOP 14 Hari</option>
                                                            <option value="TOP 30 Hari">TOP 30 Hari</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="font-normal">Payment Method</label>
                                                        <select id="top" name="method" class="form-control chosen-select-top">
                                                            <option value="<?= $item['method'] ?>"><?= $item['method'] ?>
                                                            </option>
                                                            <option value="Cash/Tunai">Cash/Tunai</option>
                                                            <option value="Transfer">Transfer</option>
                                                            <option value="Check/Giro">Check/Giro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="font-normal">Jenis Perusahaan</label>
                                                        <select id="jenisPerusahaan" class="form-control " name="jenisPerusahaan" data-placeholder="Pilih ..." tabindex="2" required>
                                                            <option value="<?= $item['id_perusahaan'] ?>">
                                                                <?= cari_customer_nama($item['id_perusahaan']) ?></option>
                                                            <?php while ($row_jenis_p = mysqli_fetch_array($hasil_perusahaan)) : ?>
                                                                <option value="<?= $row_jenis_p['id_perusahaan'] ?>">
                                                                    <?= $row_jenis_p['nama_pt']  ?>
                                                                </option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="font-normal">Ongkos Kirim</label>
                                                        <input type="text" name="ongkir" id="ongkir" class="form-control" placeholder="Rp. " value="<?= $item['ongkir'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label class="font-normal">Alamat Kirim </label> (alternatif)
                                                        <textarea id="alamatKirim" name="alamatKirim" style="height:75px" class="form-control prdalamatKirim"><?= $item['alamat_krm'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="font-normal">Keterangan</label>
                                                        <textarea class="form-control" name="keterangan" id="keterangan"><?= $item['keterangan'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
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
                                    <?php $no = 0;
                                    while ($detail_item = mysqli_fetch_array($result)) : $no++; ?>
                                        <div class="main_form">
                                            <form id="form<?= $no ?>">
                                                <div class="table-responsive">
                                                    <table class="table-borderless" width="100%">
                                                        <thead>
                                                            <tr class="text-center ">
                                                                <th>SKU</th>
                                                                <th> Harga Reff</th>
                                                                <th>Qty</th>
                                                                <th>Harga</th>
                                                                <th>Pengajuan</th>
                                                                <th>amount</th>
                                                                <th>Disc(%)</th>
                                                                <th>Disc(Rp.)</th>
                                                                <th style="vertical-align:middle;">PPN</th>
                                                                <th>Total</th>
                                                                <th>Promo ID</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <input name="nopo" type="hidden" value="<?= $noso ?>">
                                                            <input type="hidden" name="iditem" value="<?php echo $detail_item['id']; ?>">
                                                            <tr>
                                                                <td width="22%">
                                                                    <select name="sku" id="sku<?= $no ?>" class="form-control chosen-select-sku pilih">
                                                                        <option value="<?= $detail_item['model'] ?>">
                                                                            <?= $detail_item['model'] ?>
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td width="95px">
                                                                    <input type="text" name="prdHarga" placeholder="Harga Reff" value="<?= $detail_item['harga_ref'] ?>" id="prdHarga<?= $no ?>" class="form-control" readonly>
                                                                </td>
                                                                <td width="80px">
                                                                    <input type="text" class="form-control" placeholder="Qty" name="qty" id="qty<?= $no ?>" value="<?= $detail_item['qty'] ?>" />
                                                                </td>
                                                                <td width="95px">
                                                                    <input type="text" class="form-control" placeholder="Harga" name="harga" id="harga<?= $no ?>" value="<?= $detail_item['price'] ?>" />
                                                                </td>
                                                                <td width="95px">
                                                                    <input type="text" class="form-control" name="pengajuan" id="pengajuan<?= $no ?>" value="<?= $detail_item['harga_request'] ?>" disabled />
                                                                </td>
                                                                <td width="100px">
                                                                    <input type="text" class="form-control" placeholder="amount" name="amount" id="amount<?= $no ?>" value="<?= $detail_item['amount'] ?>" readonly />
                                                                </td>
                                                                <td width="15px">
                                                                    <input type="text" class="form-control" placeholder="%disc" value="0" name="percent_discount" id="percent_discount<?= $no ?>" />
                                                                </td>
                                                                <td width="95px">
                                                                    <input type="text" class="form-control" placeholder="Rp.disc" name="nominal_discount" value="<?= $detail_item['diskon'] ?>" id="nominal_discount<?= $no ?>" />
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" id="ppn<?= $no ?>" name="ppn" value="11" <?php if ($detail_item['ppn'] != "0") : echo "checked";
                                                                                                                                    endif; ?>>
                                                                    <input type="hidden" name="hitungan_ppn" id="hitungan_ppn<?= $no ?>" value="<?php echo $detail_item['ppn']; ?>">
                                                                    PPN
                                                                </td>
                                                                <td width="100px">
                                                                    <input type="text" class="form-control" placeholder="total" name="harga_total" id="harga_total<?= $no ?>" value="<?= $detail_item['harga_total'] ?>" readonly>
                                                                </td>
                                                                <td width="120px">
                                                                    <select name="dsopromo" id="dsopromo<?= $no ?>" class="form-control dsopromo">
                                                                        <option value="<?= $detail_item['promo_id'] ?>"><?= $detail_item['promo_id'] ?></option>
                                                                        <?php
                                                                        $krik = "SELECT a.promo_id, a.promo_name, a.promo_jenis FROM bundle_promo a JOIN bundle_promo_dtl b ON a.promo_id = b.promo_id WHERE b.model ='" . $detail_item['model'] . "' AND promo_status='1'";
                                                                        $pcs = $db1->prepare($krik);
                                                                        $pcs->execute();
                                                                        $hax = $pcs->get_result();
                                                                        while ($hx = $hax->fetch_assoc()) {
                                                                            echo '<option value="' . $hx['promo_id'] . "|" .  $hx['promo_jenis'] . '">' . $hx["promo_name"] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <input type="hidden" name="jenisPromo" id="jenisPromo<?= $no ?>">
                                                                    <input type="hidden" name="diskon_tetap" id="diskon_tetap<?= $no ?>">
                                                                    <input type="hidden" name="qty_min" id="qty_min<?= $no ?>">
                                                                </td>
                                                                <td width="95px">
                                                                    <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" value="<?= $detail_item['keterangan'] ?>" id="keterangan<?= $no ?>" />
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endwhile; ?>
                                    <input type="hidden" name="total_row" id="total_row" value="<?= $total_row ?>">
                                    <?php if ($data['level'] !== 'sales') : ?>
                                        <button class="btn btn-success float-right simpan"><span class="fa fa-save (alias)"></span> Simpan</button>
                                    <?php endif; ?>
                                    <button class="btn btn-warning back"><span class="fa fa-arrow-circle-left"></span> Kembali</button>
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
            document.getElementById('purchaseorder').setAttribute('class', 'active');
        });
    </script>
    <script>
        $(".back").click(function() {
            window.history.back();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.chosen-select-karyawan').select2();
            var value = $('#total_row').val();
            $('.chosen-select-sku').select2({
                ajax: {
                    url: 'modal/getSku.php',
                    type: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchSku: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        // console.log(response);
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            // perumusan
            for (let i = 0; i <= value; i++) {
                $("#sku" + i).change(() => {
                    var sku4 = $("#sku" + i).val();
                    $.ajax({
                        url: 'modal/getPrice.php', // buat file selectData.php terpisah
                        method: 'post',
                        dataType: "json",
                        data: {
                            sku4: sku4
                        },
                        success: function(data) {
                            console.log(data);
                            $("#prdHarga" + i).val(data[0]);
                        }
                    });
                });

                $("#dsopromo" + i).change(() => {
                    var xpromo = $("#dsopromo" + i).val();
                    var id_promo = xpromo.split("|")[0];
                    var jenis_pro = xpromo.split('|')[1];
                    $("#jenisPromo" + i).val(jenis_pro); //jenis promo 
                    var id_sku = $("#sku" + i).val();
                    // console.log
                    console.log(jenis_pro);
                    // endconsole.loh
                    $.ajax({
                        method: "POST",
                        url: "modal/getPromoDtl.php",
                        dataType: "JSON",
                        data: {
                            id: id_promo,
                            sku: id_sku
                        },
                        success: (data) => {
                            console.log(data);
                            var hsl = data;
                            var min_req = parseInt(hsl.qty_min);
                            switch (jenis_pro) {
                                case '0':
                                    $("#prdHarga" + i).val(hsl.hargadef);
                                    $("#harga" + i).val(hsl.harga_disc);

                                    $("#harga" + i).prop("readonly", true);
                                    $("#percent_discount" + i).prop("readonly", true);
                                    $("#nominal_discount" + i).prop("readonly", true);
                                    break;
                                case '1':
                                    $("#prdHarga" + i).val(hsl.hargadef);
                                    $("#harga" + i).val(hsl.hargadef);
                                    $("#percent_discount" + i).val(hsl.disc_percent);
                                    $("#qty_min" + i).val(hsl.qty_min);

                                    $("#harga" + i).prop("readonly", true);
                                    $("#percent_discount" + i).prop("readonly", true);
                                    $("#nominal_discount" + i).prop("readonly", true);
                                    break;
                                case '2':
                                    $("#prdHarga" + i).val(hsl.hargadef);
                                    $("#harga" + i).val(hsl.hargadef);
                                    $("#qty_min" + i).val(hsl.qty_min);
                                    $("#diskon_tetap" + i).val(hsl.discount);
                                    $("#harga" + i).prop("readonly", true);
                                    $("#nominal_discount" + i).prop("readonly", true);
                                    $("#percent_discount" + i).prop("readonly", true);
                            }

                            // $("#prdHarga" + index).val(hsl.hargadef);
                            // $("#harga" + index).val(hsl.harga_disc); 

                            // $("#harga" + index).prop("readonly", true);
                            // $("#percent_discount" + index).prop("readonly", true);
                            // $("#nominal_discount" + index).prop("readonly", true);
                        }
                    });
                });

                $("#harga" + i).keyup(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var discount = 0;
                    var amount = 0;

                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                    }
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                    $("#nominal_discount" + i).val(discount);
                });
                $("#percent_discount" + i).keyup(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var amount = 0;
                    var discount = 0;
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = amount * (prc_disc / 100);
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = amount * (prc_disc / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                    }
                    $("#nominal_discount" + i).val(discount);
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                });
                $("#nominal_discount" + i).change(function() {
                    $("#percent_discount" + i).val(0);
                    $("#qty" + i).trigger("keyup");
                });
                $("#qty" + i).keyup(function() {
                    var jenpro = $("#jenisPromo" + i).val();
                    var qty_brg = $("#qty" + i).val();
                    var min_qty = $("#qty_min" + i).val(); 
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var diskon_tetap = $("#diskon_tetap1").val();
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var discount = 0;
                    var amount = 0;
                    console.log(jenpro);
                    if (jenpro == 0) {
                        if (bool_ppn) {

                            amount = qty_brg * harga_brg;
                            discount = nmn_disc;
                            harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                        } else {
                            harga_ppn = 0;

                            amount = qty_brg * harga_brg;
                            discount = nmn_disc;

                            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                        }
                    } else if (jenpro == 1) {
                        if (bool_ppn) {
                            amount = qty_brg * harga_brg;
                            discount = amount * (prc_disc / 100);
                            harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                        } else {
                            harga_ppn = 0;

                            amount = qty_brg * harga_brg;
                            discount = amount * (prc_disc / 100);

                            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                        }
                    } else if (jenpro == 2) {
                        // alert('No 2');
                        if (bool_ppn) {
                            amount = qty_brg * harga_brg;
                            rumus = Math.floor(qty_brg / min_qty);
                            discount = diskon_tetap * rumus;
                            harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
                            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                            console.log(amount)
                        } else {
                            harga_ppn = 0;
                            rumus = Math.floor(qty_brg / min_qty);
                            amount = qty_brg * harga_brg;
                            discount = diskon_tetap * rumus;
                            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                            console.log(amount)
                        }
                    }
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                    $("#nominal_discount" + i).val(discount);
                });
                $("#qty" + i).change(function() {
                    var qty_brg = $("#qty" + i).val();
                    var min_qty = $("#qty_min" + i).val();

                    if (parseInt(qty_brg) < parseInt(min_qty)) {
                        swal.fire(
                            'Ulangi!',
                            'Qty Terlalu Rendah',
                            'warning');
                        $("#qty1").val(0);
                    }
                });
                $("#ppn" + i).click(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var discount = 0;
                    var amount = 0;
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (0.11);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                        console.log(harga_ppn);
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                        console.log(harga_ppn);

                    }
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                    $("#nominal_discount" + i).val(discount);
                });
            }
            $(".simpan").click(() => {
                //kirim ke detail
                var formHeader = $("#formHeader").serializeArray();
                console.log(formHeader);
                // alert($("input[name=nopo]").val());
                var customer = $('#customer').val();
                var tgl = $('#tanggal').val();
                var top = $('#top').val();
                var payment = $('#payment').val();
                var tgl_kirim = $('#tglKirim').val();
                var alamat_kirim = $('#alamatKirim').val();
                var jenis_perusahaan = $('#jenisPerusahaan').val();

                if (customer == '' || tgl == '' || top == '' || payment == '' || tgl_kirim == '' ||
                    alamat_kirim == '' || jenis_perusahaan == '') {
                    swal.fire(
                        'Gagal',
                        'Tolong input PO dengan lengkap!',
                        'warning'
                    );
                } else {
                    // kirim ke header
                    $.ajax({
                        method: "POST",
                        url: "datapo_edithdr.php",
                        data: formHeader,
                        success: function(data) {
                            // console.log(data);
                            // console.log(formHeader);
                        }
                    });
                    // console.log("header" + ":" + formHeader);
                    for (var i = 1; i <= value; i++) {
                        event.preventDefault();
                        // declare form
                        var tgl = $("#tanggal").val();
                        var form = $('#form' + (i)).serializeArray();
                        form.push({
                            name: "tgl",
                            value: tgl
                        });
                        // console.log(form);
                        $.ajax({
                            method: "POST",
                            url: "datapo_editdtl.php",
                            data: form,
                            success: function(data) {
                                // console.log(data);
                            }
                        });
                    }
                    swal.fire(
                        'Good Job',
                        'Update Berhasil!',
                        'success'
                    );
                    setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "datapo.php");
                        },
                        2000);
                }
            });
        });
    </script>
</body>

</html>