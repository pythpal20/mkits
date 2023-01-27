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
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <div class="row border-bottom white-bg page-heading">
                <!-- || -->
                <div class="col-lg-10">
                    <h2>Data Request Pick Ticket Sample</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="datasample.php">Request Sample</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Ask sample</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form permintaan Sample</h5>
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
                                                    <label class="font-normal">Nama Customer</label>
                                                    <input type="text" class="form-control customer" name="customer"
                                                        id="customer">
                                                </div>
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
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tanggal Diambil</label>
                                                    <input type="date" id="tglambil" name="tglambil"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="font-normal">Status Sample</label>
                                                    <select id="stsample" name="stsample" class="form-control" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="1">Kembali</option>
                                                        <option value="2">Tidak Kembali</option>
                                                        <option value="3">Dibeli </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" id="kembali">
                                                <div class="form-group">
                                                    <label>Tanggal Kembali</label>
                                                    <input type="date" name="tglkembali" id="tglkembali"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-5" id="dibeli">
                                                <div class="form-group">
                                                    <label>Ket. Pembelian</label>
                                                    <textarea name="ketbeli" id="ketbeli"
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" id="dibeli">
                                                <div class="form-group">
                                                    <label>Kota</label>
                                                    <input type="text" id="kota" name="kota" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="font-normal">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat"
                                                        style="height: 75px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="font-normal">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" id="keterang"
                                                        style="height: 75px;"></textarea>
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
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>SKU</label>
                                                    <select name="sku" id="sku1"
                                                        class="form-control chosen-select1 pilih">
                                                        <option value="">--Pilih SKU--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="text" class="form-control" placeholder="Qty" name="qty"
                                                        id="qty1" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" name="ket" class="form-control"
                                                        placeholder="keterangan" id="ket1">
                                                </div>
                                            </div>
                                        </div>
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
            <!-- END OF CONTENT -->
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <!-- LOAD ASSETS -->
    <?php include 'template/load_js.php'; ?>
    <script src="../assets/js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#kembali').hide();
        $('#dibeli').hide();
        //ketika status berubah maka hide/show form tambahan
        $('#stsample').change(function() {
            var status = $('#stsample').val();
            // console.log(status);
            if (status === '1') {
                $('#kembali').show();
                $('#dibeli').hide();
                $('#ketbeli').val("");
            } else if (status === '2') {
                $('#dibeli').hide();
                $('#ketbeli').val("");
                $('#kembali').hide();
                $('#tglkembali').val("");
            } else if (status === '3') {
                $('#kembali').hide();
                $('#dibeli').show();
                $('#tglkembali').val("");
            }
        });
        //ambil data SKU
        $('.chosen-select1').select2({
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
        //jika customer yang di masukkan ada maka akan muncul list rekomendasi 
        $.get('modal/listcustomer.php', function(data) {
            $("#customer").typeahead({
                source: data
            });
        }, 'json');
        $('#customer').change(function() {
            var nama = $("#customer").val();
            $.ajax({
                url: 'modal/getKotaCust.php',
                method: 'post',
                dataType: 'json',
                data: {
                    nama: nama
                },
                success: function(data) {
                    // console.log(data);
                    var reslt = data;
                    $('#kota').val(reslt.wilayah_nama);
                    $('#alamat').val(reslt.alamat);
                }
            });
        });
        var index = 1;
        $(".tambah").click(function() {
            index++;
            var form = "form" + index;
            var sku = "sku" + index;
            var qty = "qty" + index;
            var ket = "ket" + index;
            $(".main_form").append('<form id="' + (form) + '">' +
                '<div class="text-center label label label-danger">Item ' + index +
                '</div><div class="row"> ' +
                '<div class="col-sm-4"><div class="form-group"><label>SKU</label>' +
                '<select  name = "sku' +
                '" id = "' + (sku) + '" class="form-control chosen-select' + index + ' pilih" >' +
                '<option value = "" >--Pilih SKU--</option><div class="dropdown"></div> ' +
                '</select >' +
                '</div></div>' +

                '<div class="col-sm-4"><div class="form-group"><label>Qty</label>' +
                '<input type = "text"  placeholder="qty" class="form-control" name = "qty" id = "' +
                (qty) +
                '" / ></div></div>' +
                '<div class="col-sm-4"><div class="form-group"><label>Keterangan</label>' +
                '<input type = "text" placeholder="keterangan" class="form-control" name="ket" id = "' +
                (ket) + '">' +
                '</div></div>' +
                '<hr></div > </form></div></div>');
            $('.chosen-select' + index).select2({
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
        });
        $(".simpan").click(() => {
            var formHeader = $("#formHeader").serializeArray();
            // console.log(formHeader);
            var customer = $('#customer').val();
            var tglambil = $('#tglambil').val();
            var sales = $('#sales').val();
            var stsample = $('#stsample').val();
            var kota = $('#kota').val();
            var alamat = $('#alamat').val();
            if (customer == '' || tglambil == '' || sales == '' || stsample == '' || kota == '' ||
                alamat == '') {
                swal.fire(
                    'Gagal!',
                    'Lengkapi Form Header',
                    'warning'
                );
            } else {
                $.ajax({
                    method: "POST",
                    url: "modal/pts_header.php",
                    data: formHeader,
                    success: function(data) {
                        // console.log(data);
                        var idPts = data;
                        for (var i = 1; i <= index; i++) {
                            var form = $('#form' + (i)).serializeArray();
                            // console.log(form);
                            form.push({
                                name: "idPts",
                                value: idPts
                            });
                            form.push({
                                name: "no_urut",
                                value: i
                            });
                            $.ajax({
                                method: "POST",
                                url: "modal/pts_detail.php",
                                data: form,
                                success: function(data) {
                                    // console.log(data);
                                }
                            });
                        }
                        swal.fire(
                            'Sukses',
                            'Data berhasil ditambahkan',
                            'success'
                        );
                        var url =
                            'https://api.telegram.org/bot5042604357:AAGe8tnjQG0Zb9c8dsSwivXuviNNXd9MvvE/sendMessage';
                        var chat_id = ["486876423", "-1001704848872"];
                        var text = "Request Sample dari :  <i>" + customer +
                            "</i>\n" +
                            "No. PTS : <i><b>" + idPts + "</b></i>\n" +
                            "Diajukan oleh : <i>" + sales + "</i>\n" +
                            "Tanggal diambil : <b>" + tglambil + "</b>";
                        for (let index = 0; index < chat_id.length; index++) {
                            const element = chat_id[index];
                            // console.log(element);
                            $.ajax({
                                url: url,
                                method: "get",
                                data: {
                                    chat_id: element,
                                    parse_mode: 'html',
                                    text: text
                                }
                            });
                        }
                        setTimeout(function() {
                                // your code to be executed after 2 second
                                location.assign("datasample.php");
                            },
                            2000);
                    }
                });
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        document.getElementById('samplerequest').setAttribute('class', 'active');
    });
    </script>
</body>

</html>