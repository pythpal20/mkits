<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '4'){
        header("Location: ../index.php");
    }
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc(); 

    // var_dump($_GET);
    $id = $_GET['id'];
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
                            <a href="datasampleaktual.php">Pick Ticket Sample</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Konfirmasi Barang Kembali</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- || -->
            <?php
                $query_hdr = "SELECT * FROM pts_header WHERE idPts='$id'";
                $mwk = $db1->prepare($query_hdr);
                $mwk -> execute();
                $hdr_resl = $mwk->get_result();
                $hdr = $hdr_resl->fetch_assoc();

                $query_dtl = "SELECT * FROM pts_detail_aktual WHERE idPts='$id'";
                $resl_dtl = mysqli_query($connect,$query_dtl);
                $total_row = mysqli_num_rows($resl_dtl);
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="panel panel-danger">
                                    <div class="panel-body">
                                        <table width="100%">
                                            <tr>
                                                <th>ID PTS</th>
                                                <td>:</td>
                                                <th><?= $hdr['idPts'] ?></th>
                                            </tr>
                                            <tr>
                                                <th>Tgl. Diajukan</th>
                                                <td>:</td>
                                                <th><?= $hdr['tgl_create'] ?></th>
                                            </tr>
                                            <tr>
                                                <th>Tgl. Diambil</th>
                                                <td>:</td>
                                                <th><?= $hdr['idPts'] ?></th>
                                            </tr>
                                            <tr>
                                                <th>Due Date</th>
                                                <td>:</td>
                                                <th><?= date_format(date_create($hdr['tgl_kembali']), 'd/m/Y') ?></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="panel panel-danger">
                                    <div class="panel-body">
                                        <table width="100%">
                                            <tr>
                                                <th>Customer</th>
                                                <td>:</td>
                                                <th><?= $hdr['customer_nama'] ?></th>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>:</td>
                                                <th><?= $hdr['alamat'] ?></th>
                                            </tr>
                                            <tr>
                                                <th>Sales</th>
                                                <td>:</td>
                                                <th><?= $hdr['sales'] ?></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <?php $no = 0; while($dtl = $resl_dtl->fetch_assoc()) : $no++ ?>
                                <div class="FormDetail">
                                    <form id="form<?= $no ?>">
                                        <table width="100%">
                                            <thead>
                                                <th>MODEL</th>
                                                <th>Qty. Dikirim</th>
                                                <th>Qty. Kembali</th>
                                                <th>Tgl. Kembali</th>
                                                <th>Keterangan</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" id="idpts<?=$no?>" name="idpts"
                                                            value="<?= $_GET['id'] ?>">
                                                        <input type="hidden" id="item<?$no?>" name="item"
                                                            value="<?=$dtl['id']?>">
                                                        <input type="text" name="sku" id="sku<?= $no ?>"
                                                            value="<?= $dtl['model']?>" class="form-control" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="qtyact<?= $no ?>"
                                                            name="qtyact" value="<?=$dtl['qty_aktual']?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="qtyback<?=$no?>"
                                                            name="qtyback" value="<?=$dtl['qty_kembali']?>">
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" id="tglback<?=$no?>"
                                                            name="tglback" value="<?=$dtl['tgl_kembali']?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="keterangan<?=$no?>"
                                                            name="keterangan" value="<?=$dtl['ket']?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <?php endwhile; ?>
                                <br>
                                <?php if($data['level'] == 'admin' || $data['level'] == 'superadmin'): ?>
                                <button class="btn btn-success float-right simpan" id="simpan"><span
                                        class="fa fa-save (alias)"></span>
                                    Simpan
                                </button>
                                <?php endif; ?>
                                <button class="btn btn-warning back"><span class="fa fa-arrow-circle-left"></span>
                                    Kembali
                                </button>
                            </div>
                            <div class="ibox-footer">
                                <em>Pastikan isi qty item kembali</em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <input type=" hidden" name="total_row" id="total_row" value="<?=$total_row?>">
    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        document.getElementById('ptsampleakt').setAttribute('class', 'active');
        $(".back").click(function() {
            window.history.back();
        });
    });

    $(document).ready(function() {
        var value = $('#total_row').val();
        for (let i = 1; i <= value; i++) {
            $("#qtyback" + i).keyup(function() {
                var qty_act = $('#qtyact' + i).val();
                var qty_back = $('#qtyback' + i).val();

                if (qty_back > qty_act) {
                    $('#simpan').addClass('disabled');
                    swal.fire(
                        'ERROR!',
                        'Qty. Kembali tidak boleh lebih besar dari Qty. kirim',
                        'warning'
                    );
                } else {
                    $('#simpan').removeClass('disabled');
                }
            });
        }
        $(".simpan").click(() => {
            for (var i = 1; i <= value; i++) {
                event.preventDefault();
                var form = $('#form' + (i)).serializeArray();
                // console.log(form);
                $.ajax({
                    method: "POST",
                    url: "modal/ptsback.php",
                    data: form,
                    success: function(data) {
                        // console.log(data);
                    }
                });
            }
            swal.fire(
                'Berhasil',
                'Update sudah berhasil',
                'success'
            );
            setTimeout(function() {
                    // your code to be executed after 1 second
                    location.assign(
                        "datasampleaktual.php");
                },
                2000);
        });
    });
    </script>
</body>

</html>