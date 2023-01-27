<?php
    include '../../config/connection.php';


    session_start(); 
    $akses = $_SESSION['moduls'];
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data_user = $resl->fetch_assoc(); 
    

    $noco = $_POST['noco'];
    function rupiah($angka){
	
        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
     
    }
    $query = "SELECT a.noso, a.No_Co,a.sales,a.customer_id,d.term, c.customer_nama, a.sales, a.no_bl, a.no_fa, a.no_sh,  a.alamat_krm , a.method
    FROM customerorder_hdr a
    JOIN customerorder_dtl b ON a.No_Co = b.No_Co
    JOIN salesorder_hdr d ON a.noso = d.noso
    JOIN master_customer c ON a.customer_id = c.customer_id
    WHERE a.No_Co = '$noco'";
    $mwk=$db1->prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    $hdr = $resl->fetch_assoc();
?>
<div class="ibox" style="width:100%;overflow-x:auto">
    <table class="table" width="100%" style="background-color:white;">
        <tr>
            <th>No. CO</th>
            <td>:</td>
            <td id="noco_hdr"><?php echo $hdr['No_Co']; ?></td>
            <th> No SO</th>
            <td>:</td>
            <td id="noso_hdr"><?php echo $hdr['noso']; ?></td>
        </tr>
        <tr>
            <th>No. SH</th>
            <td>:</td>
            <td id="nosh_hdr"><?php echo $hdr['no_sh']; ?></td>
            <th> No. BL</th>
            <td>:</td>
            <td id="nobl_hdr"><?php echo $hdr['no_bl']; ?></td>
        </tr>
        <tr>
            <th>No. FA</th>
            <td>:</td>
            <td id="nofa_hdr"><?php echo $hdr['no_fa']; ?></td>
            <th> Customer Name</th>
            <td>:</td>
            <td id="customer_hdr"><?php echo $hdr['customer_nama']; ?></td>
        </tr>
        <tr>
            <th>TOP </th>
            <td>:</td>
            <td id="top_hdr"><?php echo $hdr['term']; ?></td>
            <th>Method </th>
            <td>:</td>
            <td id="method"><?php echo $hdr['method']; ?></td>
        </tr>
        <tr>
            <th colpsan="2">Alamat Kirim </th>
            <td>:</td>
            <td id="alamat_hdr" colspan="4"><?php echo $hdr['alamat_krm']; ?></td>
        </tr>
        <div class="d-none" id="customer_id_hdr"><?php echo $hdr['customer_id']; ?></div>
    </table>
</div>
<hr>
<?php
    $query2 = "SELECT * FROM customerorder_dtl WHERE No_Co = '$noco' ORDER BY no_urut ASC";
    $mwk = $db1->prepare($query2);
    $mwk -> execute();
    $resl2 = $mwk->get_result();
    $no = 0;
?>
<div style="width:100%;overflow-x:auto">
    <table class="table">
        <thead class=" table-info ">
            <tr class=" text-center">
                <th>#</th>
                <th style="min-width:80px">Aksi</th>
                <th style="min-width:110px">SKU</th>
                <th style="min-width:110px">Qty Kirim</th>
                <th style="min-width:110px">Harga</th>
                <th style="min-width:110px">diskon</th>
                <th style="min-width:120px">ppn</th>
                <th style="min-width:140px">Amount</th>
                <th style="min-width:140px">Harga Total</th>
            </tr>
        </thead>
    </table>

    <?php    
            // declare
            while ($dtl = $resl2->fetch_assoc()){
                $no++;
                ?>
    <form id='form_<?=$no?>'>
        <table class="table ">
            <!-- <?php if($no ==1):?>
            <thead class="table-info ">
                <tr class="text-center">
                    <th>#</th>
                    <th style="min-width:110px">SKU</th>
                    <th style="min-width:110px">Qty Kirim</th>
                    <th style="min-width:110px">Harga</th>
                    <th style="min-width:110px">diskon</th>
                    <th style="min-width:110px">ppn</th>
                    <th style="min-width:130px">Amount</th>
                    <th style="min-width:130px">Harga Total</th>
                    <th style="min-width:80px">Aksi</th>
                </tr>
            </thead>
            <?php endif;?> -->
            <tbody style="background-color:white;overflow-x: scroll;">
                <div class="responsive">
                    <tr>
                        <input type="hidden" name="qty_kirim_static" id="qty_kirim_static_<?=$no;?>"
                            value="<?php echo $dtl['qty_kirim']; ?>">
                        <input type="hidden" name="ppn_static" id="ppn_static_<?=$no;?>"
                            value="<?php echo $dtl['ppn']; ?>">
                        <input type="hidden" name="diskon_static" id="diskon_static_<?=$no;?>"
                            value="<?php echo $dtl['diskon']; ?>">
                        <input type="hidden" name="No_Co" id="No_Co_<?=$no;?>" value="<?php echo $dtl['No_Co']; ?>">
                        <input type="hidden" name="model" id="model_<?=$no;?>" value="<?php echo $dtl['model']; ?>">
                        <input type="hidden" name="no_urut" id="no_urut_<?=$no;?>"
                            value="<?php echo $dtl['no_urut']; ?>">
                        <input type="hidden" name="qty_request" id="qty_req_<?=$no;?>"
                            value="<?php echo $dtl['qty_kirim']; ?>">

                        <td class="text-center"><?php echo $no; ?></td>
                        <td style="min-width:80px" class="text-center"><button
                                class="btn btn-default text-center edit_detail"
                                data-detail=".detail_input_<?=$no;?>">edit</button>
                        </td>
                        <td style="min-width:110px" class="text-center align-middle"><?php echo $dtl['model']; ?></td>
                        <td style="min-width:110px" class=" text-center">
                            <input type="number" name="qty_kirim" id="qty_kirim_<?=$no;?>"
                                class="form-control text-center detail_input_<?=$no;?>"
                                value="<?php echo $dtl['qty_kirim']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class="text-center ">
                            <input type="password" style="font-family: Verdana;" class="form-control text-center"
                                id="price_<?=$no;?>" name="price" value="<?php echo $dtl['price']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class="text-center">
                            <input type="password" class="form-control text-center" style="font-family: Verdana;"
                                name="diskon" id="diskon_<?=$no;?>" value="<?php echo $dtl['diskon']; ?>" readonly>
                        </td>
                        <td style="min-width:120px" class="text-center">
                            <input type="password" class="form-control text-center" style="font-family: Verdana;"
                                name="ppn" id="ppn_<?=$no;?>" value="<?php echo $dtl['ppn']; ?>" readonly>
                        </td>
                        <td style="min-width:140px" class="text-center"><input type="password"
                                style="font-family: Verdana;" name="amount" id="amount_<?=$no;?>"
                                class="form-control text-center" value="<?php echo $dtl['amount']; ?>" readonly>
                        </td>
                        <td style="min-width:140px" class="text-center"><input type="password"
                                style="font-family: Verdana;" name="harga_total" id="harga_total_<?=$no;?>"
                                class="form-control text-center" value="<?php echo $dtl['harga_total']; ?>" readonly>
                        </td>

                    </tr>
                </div>
            </tbody>
        </table>
    </form>
    <?php } ?>
    <input type="hidden" name="total" value="<?php echo $no; ?>">
</div>
<!-- <div class="row   m-2">
    <div class="col-sm-11">
        <textarea class="form-control" placeholder="alasan " style=" width:100%" name="alasan" id="alasan"
            rows="1"></textarea>
    </div>
    <div class="col-sm-1">
        <button class="btn btn-primary  kirim">Kirim</button>
    </div>

</div> -->
<div class="input-group mt-3">
    <input type="text" name="sopir" placeholder="pic 1" id="sopir" class="form-control"
        value="<?=$data_user['user_nama']?>" readonly>
    <input type="text" name="kenek" placeholder="pic 2" id="kenek" class="form-control" autocomplete="off">
</div>
<div class="input-group mt-3">
    <!-- <input type="text" name="nopol" placeholder="nopol" id="nopol" class="form-control"> -->
    <select class="form-control " name="nopol" id="nopol" style="height:35px">
        <option value="0">-pilih nopol-</option>
        <option value="D 8809 FP">D 8809 FP </option>
        <option value="D 8106 EO"> D 8106 EO</option>
        <option value="D 8927 EN">D 8927 EN</option>
        <option value="D 8138 FP">D 8138 FP</option>
        <option value="D 8466 EN">D 8466 EN</option>
        <option value="D 8977 FQ">D 8977 FQ</option>
        <option value="D 8320 EO">D 8320 EO</option>
        <option value="D 8583 FD">D 8583 FD</option>
        <option value="D 8711 EY">D 8711 EY</option>
        <option value="D 8713 EY">D 8713 EY</option>
        <option value="D 8146 FR">D 8146 FR</option>
        <option value="other">Lainya</option>
    </select>
    <div id="nopol_div"></div>
    <input type="text" name="jenis" placeholder="jenis" id="jenis" class="form-control">
</div>
<div class="d-none" id="option_alasan">
    <select class="form-control  m-t" name="alasan" id="alasan">
        <option value="0">-pilih alasan-</option>
        <option value="1">Customer merasa tidak pesan</option>
        <option value="2">Minta TOP</option>
        <option value="3">SKU/ Barang salah Bawa</option>
        <option value="4">Toko Tutup Permanen</option>
        <option value="5">Qty Kurang</option>
        <option value="6">Perubahan Pembayaran</option>
        <option value="7">Pengiriman terlalu lama</option>
        <option value="8">Customer tidak ada budget</option>
        <option value="9">Tukar sku berbeda</option>
    </select>
</div>
<div class="hr-line-dashed"></div>
<button type="button" class="btn btn-primary btn-lg float-right kirim">Kirim
</button>
<div class="input-group" style="width:70%;">
    <input type="date" name="jadwalkan" id="jadwalkan" class="form-control" placeholder="tgl Reschedule">
    <button type="button" class="btn btn-secondary float-left reschedule">Reschedule
    </button>
</div>
<tr></tr>