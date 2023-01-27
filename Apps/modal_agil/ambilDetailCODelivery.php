<?php
    include '../../config/connection.php';
    $noco = $_POST['noco'];
    function rupiah($angka){
	
        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
     
    }
    $query = "SELECT a.noso,a.alasan, a.No_Co,a.sales,a.nopol, a.kenek,d.term, a.jenis, c.customer_nama, a.sales, a.no_bl, a.no_fa, a.no_sh,  a.alamat_krm, e.method
    FROM customerorder_hdr_delivery a
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
    JOIN salesorder_hdr d ON a.noso = d.noso
    JOIN customerorder_hdr e ON a.No_Co = e.No_Co
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
            <th>Nopol</th>
            <td>:</td>
            <td id="nopol_hdr"><?php echo $hdr['nopol']; ?></td>
            <th>Jenis Mobil</th>
            <td>:</td>
            <td id="jenis_mobil_hdr"><?php echo $hdr['jenis']; ?></td>
        </tr>
        <tr>
            <th>TOP </th>
            <td>:</td>
            <td id="top_hdr"><?php echo $hdr['term']; ?></td>
            <th>Method</th>
            <td>:</td>
            <td id="method"><?php echo $hdr['method']; ?></td>
        </tr>
        <tr>
            <th colpsan="2">Alamat Kirim </th>
            <td>:</td>
            <td id="alamat_hdr" colspan="4"><?php echo $hdr['alamat_krm']; ?></td>
        </tr>
        <tr>
            <th colpsan="2">Alasan </th>
            <td>:</td>
            <td id="alasan_hdr" colspan="4"><?php echo $hdr['alasan']; ?></td>
        </tr>
    </table>
</div>
<hr>
<?php
    $query2 = "SELECT * FROM customerorder_dtl_delivery WHERE No_Co = '$noco' ORDER BY no_urut ASC";
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
                <th style="min-width:110px">SKU</th>
                <th style="min-width:110px">Qty Kirim</th>
                <th style="min-width:110px">Qty Terima</th>
                <th style="min-width:110px">Qty Sisa</th>
                <th style="min-width:110px"> Diterima Gudang</th>
                <th style="min-width:110px">Harga</th>
                <th style="min-width:110px">diskon</th>
                <th style="min-width:120px">ppn</th>
                <th style="min-width:140px">Amount</th>
                <th style="min-width:140px">Harga Total</th>
                <th style="min-width:180px">Status Gudang</th>
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
                        <input type="hidden" name="ppn" id="ppn_<?=$no;?>" value="<?php echo $dtl['ppn']; ?>">
                        <input type="hidden" name="No_Co" id="No_Co_<?=$no;?>" value="<?php echo $dtl['No_Co']; ?>">
                        <input type="hidden" name="diskon" id="diskon_<?=$no;?>" value="<?php echo $dtl['diskon']; ?>">
                        <input type="hidden" name="qty_kirim_static" id="qty_kirim_static_<?=$no;?>"
                            value="<?php echo $dtl['qty_kirim']; ?>">
                        <input type="hidden" name="model" id="model_<?=$no;?>" value="<?php echo $dtl['model']; ?>">
                        <input type="hidden" name="no_urut" id="no_urut_<?=$no;?>"
                            value="<?php echo $dtl['no_urut']; ?>">
                        <input type="hidden" name="qty_request" id="qty_req_<?=$no;?>"
                            value="<?php echo $dtl['qty_request']; ?>">

                        <td
                            class="text-center <?php echo $retVal = ($dtl['qty_request']-$dtl['qty_kirim']== 0) ? "" : "bg-primary" ; ?>">
                            <?php echo $no; ?></td>
                        <td style="min-width:110px" class="text-center align-middle">
                            <?php echo $dtl['model']; ?></td>
                        <td style="min-width:110px" class=" text-center">
                            <input type="number" name="qty_request" id="qty_request_<?=$no;?>"
                                class="form-control text-center detail_input_<?=$no;?>"
                                value="<?php echo $dtl['qty_request']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class=" text-center">
                            <input type="number" name="qty_kirim" id="qty_kirim_<?=$no;?>"
                                class="form-control text-center detail_input_<?=$no;?>"
                                value="<?php echo $dtl['qty_kirim']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class=" text-center">
                            <input type="number" name="qty_sisa" id="qty_sisa_<?=$no;?>"
                                class="form-control text-center detail_input_<?=$no;?>"
                                value="<?php echo $dtl['qty_request']-$dtl['qty_kirim']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class=" text-center ">
                            <input type="number" name="qty_sisa_diterima" id="qty_sisa_diterima_<?=$no;?>"
                                class="form-control text-center detail_input_<?=$no;?> <?php echo $aas = ($dtl['qty_sisa_diterima'] != ($dtl['qty_request']-$dtl['qty_kirim'])) ? "bg-danger" : "" ; ?>"
                                value="<?php echo $dtl['qty_sisa_diterima']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class="text-center">
                            <input type="password" class="form-control text-center"
                                style="font-family: Verdana;letter-spacing: 0.125em;" id="price_<?=$no;?>" name="price"
                                value="<?php echo $dtl['price']; ?>" readonly>
                        </td>
                        <td style="min-width:110px" class="text-center">
                            <input type="password" class="form-control text-center"
                                style="font-family: Verdana;letter-spacing: 0.125em;" name="diskon"
                                value="<?php echo $dtl['diskon']; ?>" readonly>
                        </td>
                        <td style="min-width:120px" class="text-center">
                            <input type="password" class="form-control text-center"
                                style="font-family: Verdana;letter-spacing: 0.125em;" name="ppn"
                                value="<?php echo $dtl['ppn']; ?>" readonly>
                        </td>
                        <td style="min-width:140px" class="text-center"><input type="password"
                                style="font-family: Verdana;letter-spacing: 0.125em;" name="amount"
                                id="amount_<?=$no;?>" class="form-control text-center"
                                value="<?php echo $dtl['amount']; ?>" readonly>
                        </td>
                        <td style="min-width:140px" class="text-center"><input type="password"
                                style="font-family: Verdana;letter-spacing: 0.125em;" name="harga_total"
                                id="harga_total_<?=$no;?>" class="form-control text-center"
                                value="<?php echo $dtl['harga_total']; ?>" readonly>
                        </td>
                        <td style="min-width:180px" class="text-center align-middle">
                            <!-- <?php if($dtl['status_gudang'] == "1"){ ?>
                            <label for="" class="label label-success">Diterima</label>
                            <?php } ?> -->
                            <?php if($dtl['qty_request']-$dtl['qty_kirim']== 0){ ?>
                            <!-- <label for="" class="label label-success ">Sudah diterima</label> -->
                            <?php }else if($dtl['status_gudang'] == "2"){ ?>
                            <div class="input-group">
                                <input type="text" name="alasan_qty_sisa" placeholder="alasan " id="alasan_qty_sisa"
                                    class="form-control">
                                <span class="input-group-append">
                                    <button class="btn btn-primary btn-sm konfirmasi_qty" data-id="<?=$dtl['id']?>"
                                        data-no="qty_sisa_diterima_<?=$no;?>"><i class="fa fa-check"></i></button>
                                </span>
                            </div>
                            <?php }else if($dtl['status_gudang'] == "1"){ ?>
                            <label for="" class="label label-success ">Diterima</label>
                            <?php }else if($dtl['status_gudang'] == "2"){?>
                            <label for="" class="label label-default ">Pending</label>
                            <?php }else if($dtl['status_gudang'] == "3"){?>
                            <label for="" class="label label-info ">Pending Terkonfirmasi</label></br>
                            <?=$dtl['alasan_qty_sisa']?>
                            <?php }else if($dtl['status_gudang'] == "4"){?>
                            <label for="" class="label label-secondary ">Close</label>

                            <?php };?>
                        </td>

                    </tr>
                </div>
            </tbody>
        </table>
    </form>
    <?php } ?>
    <input type="hidden" name="total" value="<?php echo $no; ?>">
</div>

<tr></tr>