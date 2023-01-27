<?php
    include '../../config/connection.php';
    $id = $_POST['id'];

    $query = "SELECT a.noso, a.tgl_po,u.telegramID,a.sales, c.customer_nama, c.pic_nama, c.customer_telp, c.pic_kontak, a.sales, a.term, a.alamat_krm, d.nama_pt
    FROM salesorder_hdr a
    JOIN master_customer c ON a.customer_id = c.customer_id
    JOIN list_perusahaan d ON a.id_perusahaan = d.id_perusahaan
    JOIN master_user u ON a.sales =  u.user_nama 
    WHERE a.noso = '$id'";
    $mwk=$db1->prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    $hdr = $resl->fetch_assoc();
?>
<div class="ibox" style="width:100%;overflow-x:auto">
    <table class="table" width="100%" style="background-color:white;">
        <tr>
            <th>No. SCO</th>
            <td>:</td>
            <td><?php echo $hdr['noso']; ?></td>
            <th> SCO Date</th>
            <td>:</td>
            <td><?php echo $hdr['tgl_po']; ?></td>
        </tr>
        <tr>
            <th> Customer Name</th>
            <td>:</td>
            <td><?php echo $hdr['customer_nama']; ?></td>
            <th></th>
            <td class="d-none" id="telegramSales"><?php echo $hdr['telegramID']; ?></td>
            <td class="d-none" id="namaSales"><?php echo $hdr['sales']; ?></td>
        </tr>
        <!-- <tr>
            <th>Sales</th>
            <td>:</td>
            <td><?php echo $hdr['sales']; ?></td>
            <th>PT</th>
            <td>:</td>
            <td><?php echo $hdr['nama_pt']; ?></td>
        </tr>
        <tr>
            <th>Term</th>
            <td>:</td>
            <td><?php echo $hdr['term']; ?></td>
            <th>kontak</th>
            <td>:</td>
            <td><?php echo $hdr['pic_kontak']; ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>:</td>
            <td colspan="4"><?php echo $hdr['alamat_krm']; ?></td>
        </tr> -->
    </table>
</div>
<hr>
<?php
    $query2 = "SELECT * FROM salesorder_dtl WHERE noso = '$id' ORDER BY no_urut ASC";
    $mwk = $db1->prepare($query2);
    $mwk -> execute();
    $resl2 = $mwk->get_result();
    $no = 1;
?>
<div style="width:100%;overflow-x:auto">

    <table class="mb-2" style="width:100%;">
        <thead>
            <tr>
                <th class="text-left">Due Date</th>
                <th class="text-left">Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:50%;">
                    <input type="date" class="form-control" name="duedate" id="duedate">
                </td>
                <td style="width:50%;">
                    <select name="priority" style="height:38px;" id="priority" class="form-control">
                        <option value="not important">not important</option>
                        <option value="scheduled">scheduled</option>
                        <option value="urgent">
                            urgent
                        </option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>


    <table class="table ">
        <thead class="table-info">
            <tr class="text-center">
                <th>#</th>
                <th>SKU</th>
                <th>Qty </th>
                <th style="max-width:150px;">Detail</th>
                <th>Qty Keep</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody style="background-color:white;">
            <?php

        function ambilKeep($noso, $sku){
            include '../../config/connection.php';

            $sql="SELECT no_keepstock,qty_req,qty_keep,status_keep,waktu_req,user,user_selesai, jenis_so FROM keepstock WHERE noso ='$noso' AND model ='$sku' AND jenis_so ='biasa'";
            $result = $db1->query($sql);
            $qty_keep = "";
            $no_keepstock = "";
            
            $qty_req = [];
            $total_qty_req = 0;
            $total_qty_keeped = 0;
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    // declare
                    $qty_keep = $row['qty_keep'];
                    // push sku req lebih daripada satu kali
                    if (status($row['status_keep']) == "requesting") {
                        $warna = "warning";
                    } else if (status($row['status_keep']) == "completed") {
                        $warna = "success";
                    }else if (status($row['status_keep']) == "kept"){
                        $warna = "primary";
                    }else if (status($row['status_keep']) == "request cancel"){
                        $warna = "danger";
                    }else{
                        $warna = "default";
                    }
                    
                    array_push($qty_req,"<label class='label label-$warna'>  K-".add_leading_zero($row['no_keepstock']). " : [ ".date('y-m-d',strtotime($row['waktu_req']))." ] [".$row['user']."] req => ".$row['qty_req']. " pcs , keep =>" .$row['qty_keep']." pcs , status => ".status($row['status_keep']).", jenis_so => ".$row['jenis_so']."   </label><br/>");
                    // penjumlahan qty req
                    $total_qty_req += $row['qty_req'];
                    $total_qty_keeped += $row['qty_keep'];
                    $no_keepstock = $row['no_keepstock'];
                   
                    
                }
            } else {
                $total_qty_req = 0;
                $total_qty_keeped = 0;
                $qty_keep = "0";
                $qty_req = [];
                $no_keepstock = "";
            }

            
            
            return ["qty_keep" => $qty_keep, "no_keep" => $no_keepstock,"qty_req" => implode("",$qty_req),"total_qty_req" =>$total_qty_req ,"total_qty_keeped" =>$total_qty_keeped];
        }
        // function id
        function add_leading_zero($value, $threshold = 4) {
            return sprintf('%0' . $threshold . 's', $value);
        }
        // function status
        function status($value) {
            if ($value == "1") {
                return "kept";
            } else if ($value == "0"){
                return "requesting";
            }else if ($value == "2") {
                return "completed";
                # code...
            }else if ($value == "3") {
                return "request cancel";
                # code...
            }else{
                return "canceled";

            }
            
        }
       
        // declare
            while ($dtl = $resl2->fetch_assoc()){
        ?>
            <tr>

                <td><?php echo $no++; ?></td>
                <td><?php echo $dtl['model']; ?></td>
                <td class="text-center"><?php echo $dtl['qty']; ?></td>
                <td class="text-center">
                    <pre><?php echo ambilKeep($dtl['noso'],$dtl['model'])['qty_req']; ?>
                    </pre>
                </td>
                <td class="text-center">
                    <?php echo ambilKeep($dtl['noso'],$dtl['model'])['total_qty_keeped']; ?>
                </td>
                <td class="text-center" style="min-width:230px;">
                    <div class="input-group">
                        <input type="number" placeholder='qty' id='input_<?=$dtl['id'];?>' style="max-width:90px;"
                            class="form-control">
                        <input type="text" placeholder='ket' style="min-width:90px;" id='ket_<?=$dtl['id'];?>'
                            class="form-control">
                        <span class="input-group-append">
                            <button type="button"
                                class=" btn btn-primary test <?= $retVal = ($no == 2) ? 'telegram' : '' ;?>"
                                qty="<?=$dtl['qty'];?>" id="<?=$dtl['id'];?>" customer="<?=$hdr['customer_nama'];?>"
                                total_qty_req="<?=ambilKeep($dtl['noso'],$dtl['model'])['total_qty_req'];?>"
                                sku="<?=$dtl['model'];?>" sales="<?=$hdr['sales'];?>" noso="<?=$dtl['noso'];?>">
                                Keep
                            </button>
                        </span>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<tr></tr>