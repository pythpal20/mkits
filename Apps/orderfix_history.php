<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '3'){
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
                    <h2>Data Order (CO)</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="orderfix.php">Data Order</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>History</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                $id = $_GET['id'];
                $qry = "SELECT * FROM customerorder_hdr a 
                JOIN list_perusahaan b ON a.id_perusahaan = b.id_perusahaan
                JOIN master_customer c ON a.customer_id = c.customer_id
                WHERE No_Co = '$id'";
                $mwk = $db1->prepare($qry);
                $mwk->execute();
                $rests = $mwk->get_result();
                $row = $rests->fetch_assoc();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="table-striped" width="100%">
                                    <tr>
                                        <th>Rev. FPP</th>
                                        <td>:</td>
                                        <th>
                                            <?php if ($row['fpp_id'] == '') {
                                                echo 'No Data';
                                            } else { ?>
                                            <button class="btn btn-warning btn-xs seeFPP" fpp="<?=$row['fpp_id']?>">
                                                <?= $row['fpp_id'] ?>
                                            </button>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>PERUSAHAAN</th>
                                        <td>:</td>
                                        <td><?= $row['atasnama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No CO</th>
                                        <td>:</td>
                                        <td><?= substr($row['No_Co'],4) ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. SCO</th>
                                        <td>:</td>
                                        <td><?= $row['noso'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tgl. Order / Tgl. Inv</th>
                                        <td>:</td>
                                        <td><?= date_format(date_create($row['tgl_order']),'d F Y') . ' / ' . date_format(date_create($row['tgl_inv']), 'd F Y') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sales</th>
                                        <td>:</td>
                                        <td><?= $row['sales'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                        $sql = "SELECT * FROM log_customerorder_hdr 
                        WHERE No_Co = '$id'";
                        $mwk=$db1->prepare($sql);
                        $mwk->execute();
                        $hsl = $mwk->get_result();
                    ?>
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="table-striped" width="100%">
                                    <tr>
                                        <th>Customer</th>
                                        <td>:</td>
                                        <td><?= $row['customer_nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>:</td>
                                        <td><?= $row['customer_telp'] ?>/<?= $row['pic_kontak'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td><?= $row['alamat_krm'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Data History CO</h5>
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
                                <table class="table table-striped display">
                                    <thead>
                                        <tr>
                                            <th>Tgl. Update</th>
                                            <th>Tgl. Invoice</th>
                                            <th>Update By</th>
                                            <th>Keterangan</th>
                                            <th>Rev. FPP</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($rw = $hsl->fetch_assoc()){ ?>
                                        <tr>
                                            <td><?=$rw['tgl_update']?></td>
                                            <td><?=$rw['tgl_inv']?></td>
                                            <td><?=$rw['updateby']?></td>
                                            <td><?=$rw['keterangan']?></td>
                                            <td>
                                                <?php if ($rw['fpp_id'] == '') { 
                                                echo 'NO DATA'; ?>
                                                <?php } else { ?>
                                                <button class="seeFPP" fpp="<?=$rw['fpp_id']?>"><?=$rw['fpp_id']?>
                                                </button>
                                                <?php }?>
                                            </td>

                                            <td>
                                                <button type="button" name="view"
                                                    id-po="<?php echo $rw['keterangan']; ?>"
                                                    class="btn btn-xs btn-primary sees" value="Lihat Detail"><span
                                                        class="fa fa-eye"></span></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ibox">
                            <button class="btn btn-md btn-warning back">Kembali</button>
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
    $('.sees').click(function() {
        var co = '<?=$id?>';
        var revisi = $(this).attr("id-po");
        $.ajax({
            url: "modal/revisiDetail.php",
            method: "POST",
            data: {
                co: co,
                revisi: revisi
            },
            success: function(data) {
                console.log(data);
                $('#detaiOrder').html(data);
                $('#viewDetail').modal('show');

            }
        });
    });

    $('.seeFPP').click(function() {
        var fpp = $(this).attr("fpp");
        $.ajax({
            url: "modal/DetailFpp.php",
            method: "POST",
            data: {
                id: fpp
            },
            success: function(data) {
                console.log(data);
                $('#datafpp').html(data);
                $('#modalfpp').modal('show');

            }
        });
    });
    </script>
    <script>
    $(".back").click(function() {
        window.history.back();
    });
    $(document).ready(function() {
        document.getElementById('datafix').setAttribute('class', 'active');
    });
    $(document).ready(function() {
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
    });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body" id="detaiOrder">

                </div>
            </div>
        </div>
    </div>
    <div id="modalfpp" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data FPP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body" id="datafpp">

                </div>
            </div>
        </div>
    </div>
</body>

</html>