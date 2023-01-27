<?php
  include '../config/connection.php';
  session_start(); 
  if (!isset($_SESSION['usernameu'])){
    header("Location: ../index.php");
  }
  $id = $_SESSION['idu'];
  $sql = "SELECT * FROM master_user
  WHERE user_id='$id'"; 
  $mwk = $db1->prepare($sql); 
  $mwk->execute();
  $res1 = $mwk->get_result();
  $data = $res1->fetch_assoc(); 
?>
<!DOCTYPE html>
<html>

<head>
    <title>FPP-Mr.Kitchen</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    td {
        height: 35px;
    }
    </style>
</head>

<body>
    <?php 
  $id = $_GET['id']; 
  $query = "SELECT * FROM master_fpp mf
  JOIN master_customer mc ON mf.customer_id = mc.customer_id
  JOIN master_wilayah mw ON mc.customer_kota = mw.wilayah_id
  WHERE mf.fpp_id = '$id'";
  $mwk = $db1->prepare($query);
  $mwk->execute();
  $resl=$mwk->get_result();
  $row = $resl->fetch_assoc();

  $query2 = "SELECT * FROM fpp_detail WHERE fpp_id = '$id' ORDER BY no_urut ASC";
  $mwk = $db1->prepare($query2);
  $mwk->execute();
  $reslt=$mwk->get_result();
  ?>
    <div class="container-fluid">
        <div class="row">
            <table border="1" width="100%">
                <tr>
                    <th rowspan="2"><img src="../img/system/mkc3.png" width="175px"></th>
                    <th class="text-center">FPP</th>
                    <td rowspan="2">
                        No. Doc : FSM-04/01/11 112020 <br>
                        Revisi : 01 <br>
                        Tgl. Terbit : 11/11/2020 <br>
                        Halaman : 1 dari 1
                    </td>
                </tr>
                <tr>
                    <th class="text-center">FORM PERUBAHAN PO</th>
                </tr>
            </table>
            <table width="100%" border="1">
                <tr>
                    <td width="50%">
                        Nama Konsumen : <b><?php echo $row['customer_nama']; ?></b><br />
                        Posisi Konsumen di Kota : <?php echo $row['wilayah_nama']; ?><br />
                        Tgl. PO : <?php echo $row['tgl_po']; ?> Tgl. Kiriman : <?php echo $row['tgl_krm']; ?><br />
                        No. Surat jalan/ No. Resi : . . . .
                    </td>
                    <td width="50%">
                        Tgl. Request perubahan PO : <?php echo $row['fpp_tanggal']; ?><br />
                        No. SCO : <?php echo $row['noso'] . ' / ' . $_GET['id']; ?><br />
                        No. Pick Tiket : SH - . . . . <br />
                        No. Invoice : FA - . . . . <br />
                    </td>
                </tr>
            </table>
            <table width="100%" border="1">
                <td style="vertical-align: top;">
                    <table border="1" width="100%">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Rincian Barang yang Mengalami Perubahan</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while ($rw=$reslt->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $rw['model']; ?></td>
                                <td><?php echo $rw['qty']; ?></td>
                                <td><?php echo $rw['keterangan']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <th colspan="2" class="text-center">Alasan Perubahan PO</th>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan1'] != NULL): echo "checked"; endif;?>></td>
                            <td> Spesifikasi barang tidak sesuai (salah SKU)</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan2'] != NULL): echo "checked"; endif;?>></td>
                            <td> Kualitas Barang tidak sesuai (rusak)</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan3'] != NULL): echo "checked"; endif;?>></td>
                            <td> Informasi order dari Sales/ Marketing tidak sesuai</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan4'] != NULL): echo "checked"; endif;?>></td>
                            <td> Waktu pengadaan barang terlalu lama</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan5'] != NULL): echo "checked"; endif;?>></td>
                            <td> Pengiriman barang terlalu lama</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan6'] != NULL): echo "checked"; endif;?>></td>
                            <td> Jumlah pesanan tidak sesuai (Kurang/ Lebih)</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan7'] != NULL): echo "checked"; endif;?>></td>
                            <td> Kesalahan Input ke Dolibar</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['alasan_lain'] != NULL): echo "checked"; endif;?>>
                            </td>
                            <td> Lainnya : <em><?php echo $row['alasan_lain']; ?></em></td>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="2">Tindak Lanjutan Perubahan PO</th>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['proses1'] != NULL): echo "checked"; endif;?>></td>
                            <td> Cancel</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['proses2'] != NULL): echo "checked"; endif;?>></td>
                            <td> Revisi Invoice</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['proses3'] != NULL): echo "checked"; endif;?>></td>
                            <td> Lengkapi kekurangan Jumlah</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['proses4'] != NULL): echo "checked"; endif;?>></td>
                            <td> Tukar SKU yang sama</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['proses5'] != NULL): echo "checked"; endif;?>></td>
                            <td> Tukar SKU yang berbeda</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" <?php if($row['proses_lain'] != NULL): echo "checked"; endif;?>>
                            </td>
                            <td> Lainnya : <em><?php echo $row['proses_lain']; ?></em></td>
                        </tr>
                    </table>
                </td>
            </table>
        </div>
        <div class="row">
            <table width="100%" border="1">
                <tr>
                    <th>Catatan :</th>
                </tr>
                <tr>
                    <td><textarea style="width: 100%; height: 250px" readonly><?php echo $row['catatan'];?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table width="100%" t border="1">
                <thead class="text-center">
                    <th width="14%">Dibuat</th>
                    <th width="14%">Disetujui</th>
                    <th width="14%">Disetujui</th>
                    <th width="14%">Diketahui</th>
                    <th width="14%">Diketahui</th>
                    <th width="14%">Diketahui</th>
                    <th width="14%">Diketahui</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" style="height: 75px; vertical-align: bottom;"><img
                                src="../img/<?php echo $row['inputby']; ?>.png"
                                width="75px"><br>(<?php echo $row['inputby']; ?>)</td>
                        <td style="height: 75px;"></td>
                        <td style="height: 75px;"></td>
                        <td style="height: 75px;"></td>
                        <td style="height: 75px;"></td>
                        <td style="height: 75px;"></td>
                        <td style="height: 75px;"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th>Sales/Marketing</th>
                        <th>Sales Planner</th>
                        <th>Manager</th>
                        <th>Kepala Admin</th>
                        <th>Admin</th>
                        <th>Kepala Gudang</th>
                        <th>Akunting</th>
                    </tr>
                    <tr>
                        <td>Tgl. <?php echo $row['fpp_tanggal']; ?></td>
                        <td>Tgl.</td>
                        <td>Tgl.</td>
                        <td>Tgl.</td>
                        <td>Tgl.</td>
                        <td>Tgl.</td>
                        <td>Tgl.</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script type="text/javascript">
    window.print();
    </script>

    <!-- <table border="1" width="100%" style="overflow-x:auto; border-collapse: collapse;">
    <tr>
      <td>Nama Konsumen : <?php echo $row['customer_nama']; ?></td>
      <td>Tgl Request PO : <?php echo $row['fpp_tanggal']; ?></td>
    </tr>
    <tr>
      <td>Posisi Konsumen di Kota : <?php echo $row['wilayah_nama']; ?></td>
      <td>No. SCO : <?php echo $row['noso']; ?></td>
    </tr>
    <tr>
      <td>Tgl. PO : <?php echo $row['tgl_po']; ?> &nbsp; Tgl. Kiriman : <?php echo $row['tgl_krm']; ?></td>
      <td>No. Pick Tiket : SH - </td>
    </tr>
    <tr>
      <td>No. Surat jalan/ No. Resi : </td>
      <td>No. Invoice : FA - </td>
    </tr>
  </table> -->

</body>

</html>