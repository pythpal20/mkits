<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu'])){
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
                            <a href="infosco.php">Status SCO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Detail Order</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php //load everything about this CO from database
                $id = $_GET['id'];
                $sql = "SELECT * FROM customerorder_hdr a
                JOIN master_customer b ON a.customer_id = b.customer_id
                JOIN list_perusahaan c ON a.id_perusahaan = c.id_perusahaan
                WHERE a.No_Co = '$id'";
                $mwk = $db1->prepare($sql);
                $mwk -> execute();
                $res = $mwk->get_result();
                $row = $res->fetch_assoc();

                $sql2 = "SELECT a.model, a.qty_kirim, b.qty_kirim AS diterima FROM customerorder_dtl a
                LEFT JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co AND a.model = b.model
                WHERE a.No_Co = '$id' ";
                $mwk = $db1->prepare($sql2);
                $mwk->execute();
                $res2 = $mwk->get_result();
                
                $sql3 = "SELECT a.tgl_krm, a.tgl_order, a.sales,b.status_delivery, b.alasan, b.	tgl_delivery, a.customer_nama, c.aproval_by, c.aproval_date, b.sopir, b.kenek
                FROM customerorder_hdr a
                LEFT JOIN customerorder_hdr_delivery b ON a.No_Co = b.No_Co
                JOIN salesorder_hdr c ON a.noso = c.noso
                WHERE a.No_Co = '$id'";
                $mwk = $db1->prepare($sql3);
                $mwk->execute();
                $res3 = $mwk->get_result();
                $tm = $res3->fetch_assoc();

                $sql4 = "SELECT g.noco, g.tgl_pembayaran,
                IFNULL(((select sum(g.nominal) from detail_penagihan g where a.No_co = g.noco)-(select sum(b.harga_total) from customerorder_dtl_delivery b where b.No_co = a.No_Co)), 'belum bayar') as selisih
                FROM detail_penagihan g
                JOIN customerorder_hdr_delivery a ON g.noco = a.No_Co
                JOIN customerorder_dtl_delivery b ON g.noco = b.No_Co
                WHERE g.noco = '$id'
                GROUP BY b.No_Co";
                $mwk = $db1->prepare($sql4);
                $mwk->execute();
                $res4 = $mwk->get_result();
                $rw = $res4->fetch_assoc();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-5">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="table-striped" width="100%">
                                    <tr>
                                        <th width="30%">Perusahaan</th>
                                        <td>:</td>
                                        <td> <?php echo $row['atasnama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. CO / No. SCO</th>
                                        <td>:</td>
                                        <td> <?php echo substr($row['No_Co'],4) . ' / ' . $row['noso']; ?></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. Inv</th>
                                        <td>:</td>
                                        <td> <?php echo substr($row['no_fa'],4); ?></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. Pict Ticket</th>
                                        <td>:</td>
                                        <td> <?php echo substr($row['no_sh'],4); ?></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Status</th>
                                        <td>:</td>
                                        <td> <?php
                                                if($row['status_delivery'] == '0') {
                                                    echo "<span class='label label-warning'>Belum Dikirim</span>";
                                                } else {
                                                    echo "<span class='label label-info'>Dalam pengiriman/ terkirim</span>";
                                                }
                                             ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Pembayaran</th>
                                        <td>:</td>
                                        <td> <?php
                                                if($rw['selisih'] == '0') {
                                                    echo "<span class='label label-info'>Lunas</span>";
                                                } else {
                                                    echo "<span class='label label-warning'>Belum Lunas</span>";
                                                }
                                             ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="table-striped" width="100%">
                                    <tr>
                                        <th>Sales</th>
                                        <td>:</td>
                                        <td><?= $row['sales']?></td>
                                    </tr>
                                    <tr>
                                        <th>Customer</th>
                                        <td>:</td>
                                        <td><?= $row['customer_nama']?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Kirim</th>
                                        <td>:</td>
                                        <td><?= $row['alamat_krm']?></td>
                                    </tr>
                                    <tr>
                                        <th>Tgl. Order / Tgl. Kirim</th>
                                        <td>:</td>
                                        <td><?= $row['tgl_order'] . ' / ' . $row['tgl_krm']?></td>
                                    </tr>
                                    <tr>
                                        <th>Issued By</th>
                                        <td>:</td>
                                        <td><?= $row['issuedby']?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Detail Item</h5>
                            </div>
                            <div class="ibox-content">
                                <table class="table-bordered" width="100%">
                                    <thead>
                                        <th>Model</th>
                                        <th>Qty Kirim</th>
                                        <th>Qty Diterima</th>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; while ($dti = $res2->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $dti['model'] ?></td>
                                            <td><?= $dti['qty_kirim'] ?></td>
                                            <td><?= $dti['diterima'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ibox-footer">
                                <em style="font-size: 0.820em">Qty Diterima adalah Jumlah Barang yang diterima oleh
                                    cutomer saat barang dikirim</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="jumbotron bg-light">
                            <div id="vertical-timeline" class="vertical-container light-timeline center-orientation">
                                <?php if($rw['selisih'] == '0'): ?>
                                <div class="vertical-timeline-icon navy-bg">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="vertical-timeline-content">
                                    <h3>Status Pembayaran</h3>
                                    <p><?php
                                        if($rw['selisih'] == '0') {
                                            echo "<b>LUNAS !</b>";
                                        } else {
                                            echo "<b>BELUM LUNAS !</b>";
                                        }
                                             ?>
                                    </p>
                                    <span class="vertical-date">
                                        <?php echo date_format(date_create($rw['tgl_pembayaran']), "l, d"); ?>
                                        <br />
                                        <small><?php echo date_format(date_create($rw['tgl_pembayaran']), "M y"); ?></small>
                                    </span>
                                </div>
                                <?php else: ?>
                                <?php endif; ?>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon navy-bg">
                                        <i class="fa fa-send"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <h3>Status Kirim</h3>
                                        <!-- <?php
                                        var_dump($tm['sopir']);
                                        ?> -->
                                        <p><?php
                                        if($tm['status_delivery'] == '1') { //cek status pengiriman terlebih dahulu
                                            echo "<b>Sudah dikirim</b> oleh <b>" . $tm['sopir'] . "</b> dan <b>" . $tm['kenek'] . "</b> dari Tim Delivery";
                                        } elseif($tm['status_delivery'] == '2') {
                                            echo "<b>Dikirim dengan alasan</b> <br>" . $tm['alasan'] . " oleh <b>" . $tm['sopir'] . "</b> dan <b>" . $tm['kenek'] . "</b> dari Tim Delivery";
                                        } elseif($tm['status_delivery'] == '0') {
                                            echo "<b>Belum dikirim</b>";
                                        } elseif($tm['status_delivery'] == '3') {
                                            echo "<b>Sudah dikirim</b> oleh <b>" . $tm['sopir'] . "</b> dan <b>" . $tm['kenek'] . "</b> dari Tim Delivery";
                                        } else {
                                            echo "<b>Belum dikirim</b>";
                                        }
                                    ?>
                                        </p>
                                        <span class="vertical-date">
                                            <?php 
                                            if ($tm['tgl_delivery'] != NULL) {
                                                echo date_format(date_create($tm['tgl_delivery']), "l, d");
                                            } else {
                                                echo date_format(date_create($tm['tgl_krm']), "l, d"); 
                                            }
                                            ?><br>
                                            <small>
                                                <?php 
                                                if ($tm['tgl_delivery'] != NULL) {
                                                    echo date_format(date_create($tm['tgl_delivery']), "M y"); 
                                                } else {
                                                    echo date_format(date_create($tm['tgl_krm']), "M y"); 
                                                }
                                                ?>
                                            </small>
                                        </span>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-check"></i>
                                        </div>

                                        <div class="vertical-timeline-content">
                                            <h3>AR Check</h3>
                                            <p>Has been check by <b><?= $tm['aproval_by'] ?></b> <br>From <b>Account &
                                                    Finance Dept.</b>
                                            </p>
                                            <span class="vertical-date">
                                                <?php echo date_format(date_create($tm['aproval_date']), "l, d"); ?>
                                                <br />
                                                <small><?php echo date_format(date_create($tm['aproval_date']), "M y"); ?></small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-file-text"></i>
                                        </div>

                                        <div class="vertical-timeline-content">
                                            <h3>Order</h3>
                                            <p>Order Created by <b><?= $tm['sales'] ?></b><br>For
                                                <b><?= $tm['customer_nama'] ?></b>
                                            </p>
                                            <a href="#" class="btn btn-xs btn-primary see_data"> More info</a>
                                            <span class="vertical-date">
                                                <?php echo date_format(date_create($tm['tgl_order']), "l, d"); ?>
                                                <br />
                                                <small><?php echo date_format(date_create($tm['tgl_krm']), "M y"); ?></small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
            <input type="hidden" id="noso" value="<?= $row['noso'] ?>">
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script>
        $(document).ready(function(){
            $('.see_data').click(function(){
                var id = $('#noso').val();
                // console.log(id);
                $.ajax({
                url: "modal/detailpo.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    //console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
            });
        });
    </script>
</body>
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
</html>