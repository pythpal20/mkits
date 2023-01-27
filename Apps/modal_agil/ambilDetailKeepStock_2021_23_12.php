<?php
    include '../../config/connection.php';
    $id = $_POST['id'];
    $leveluser = $_POST['level'];
    $moduluser = $_POST['modul'];
    session_start(); 
    $akses = $_SESSION['moduls'];
?>

<?php
    $query2 = "SELECT * FROM keepstock WHERE no_keepstock = '$id' ORDER BY id ASC";
    $mwk = $db1->prepare($query2);
    $mwk -> execute();
    $resl2 = $mwk->get_result();
    $query3 = "SELECT * FROM keepstock WHERE no_keepstock = '$id' ORDER BY id ASC";
    $mwk3 = $db1->prepare($query3);
    $mwk3 -> execute();
    $resl3 = $mwk3->get_result();
    $no = 1;

     // function id
    function add_leading_zero($value, $threshold = 4) {
        return sprintf('%0' . $threshold . 's', $value);
    }
     // function status
    function status($value) {
        if ($value == "1") {
            return "<label class='label label-primary'> kept </label>";
        } else if ($value == "0"){
            return " <label class='label label-warning'> requesting </label>";
        }elseif ($value == "2") {
            return "<label class='label label-success'> completed </label>";
            # code...
        }elseif ($value == "3") {
            return "<label class='label label-danger'> req cancel </label>";
            # code...
        }elseif ($value == "4") {
            return "<label class='label label-default'> canceled </label>";
            # code...
        }
        
    }
    // declare
    $noso ="";
    $customer ="";
    $duedate ="";
    $user ="";
    $user_keep ="";
    $user_selesai ="";
    $selesai ="";
    $sh ="";
    $alasan_cancel ="";
    $user_cancel ="";
    $telegramSales ="";
    while ($hdr = $resl3->fetch_assoc()){
        $noso = $hdr['noso'];
        $customer = $hdr['customer'];
        $duedate = $hdr['duedate'];
        $user = $hdr['user'];
        $user_keep = $hdr['user_keep'];
        $selesai = $hdr['waktu_selesai'];
        $user_selesai = $hdr['user_selesai'];
        $sh = $hdr['no_sh'];
        $alasan_cancel = $hdr['alasan_cancel'];
        $user_cancel = $hdr['user_cancel'];
        $telegramSales = $hdr['telegramsales'];
    }
?>
<div class="ibox col-lg-12" style="width:100%;overflow-x:auto">
    <table class="table" width="100%" style="background-color:white;">
        <tr>
            <td>
            <th>No Keep Stock </th>
            <td>:</td>
            <td id="noKeep"><?php echo "K-".add_leading_zero($id); ?></td>
            </td>
            <td>
            <th>Requested by </th>
            <td>:</td>
            <td id="userReq"><?php echo $user; ?></td>
            </td>


        </tr>
        <tr>
            <td>
            <th>No SO </th>
            <td>:</td>
            <td id="noso"><?php echo $noso; ?></td>
            </td>
            <td>
            <th>Kept by </th>
            <td>:</td>
            <td><?php echo $user_keep; ?></td>
            </td>


        </tr>
        <tr>
            <td>
            <th>Customer </th>
            <td>:</td>
            <td id="customerNama"><?php echo $customer; ?></td>
            </td>
            <td>
            <th>Completed Time</th>
            <td>:</td>
            <td><?php echo $selesai; ?></td>

            </td>
        </tr>
        <tr>
            <td>
            <th>Due date </th>
            <td>:</td>
            <td><?php echo $duedate; ?></td>
            </td>
            <td>
            <th>Completed by </th>
            <td>:</td>
            <td><?php echo $user_selesai; ?></td>
            </td>
        </tr>
        <tr>
            <td>
            <th>No SH </th>
            <td>:</td>
            <td><?php echo $sh; ?></td>
            </td>
            <td>
            <th>Cancel by </th>
            <td>:</td>
            <td><?php echo $user_cancel; ?></td>
            </td>
        </tr>
    </table>
    <div class="d-none" id="telegramSales"><?=$telegramSales?></div>
    <?php
    // function ambil status keepstock header
    function ambilStatusperkeepstock($no_keepstock){
        include '../../config/connection.php';

        $sql="SELECT status_keep FROM keepstock WHERE no_keepstock ='$no_keepstock' ";
        $result = $db1->query($sql);
        $status_array = [];
        $status = "";

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // cek apakah ada status 0
                array_push($status_array, $row['status_keep']);
            }
        } else {

        }

        if (in_array("0", $status_array)) {
            $status = "0";
        } else if(in_array("1", $status_array)) {
            $status = "1";
        }else if(in_array("2", $status_array)){
            $status = "2";
        }else if(in_array("3", $status_array)){
            $status = "3";
        }else{
            $status = "4";
        }
        
        return $status;
        
    }
    
    ?>
    <?php if(ambilStatusperkeepstock($id) == "1" && $leveluser == "admin" && $moduluser =="4" ):?>
    <tr class="row">
        <div class="col-md-5 float-right">
            <div class="input-group">
                <input type="text" class="form-control" id="nosh" placeholder="No SH">
                <span class="input-group-append">
                    <button type="btn btn-primary" id="<?=$id?>" noso="<?=$noso?>" customer="<?=$customer?>"
                        class="btn btn-primary selesai">Kirim
                    </button>
                </span>
            </div>
        </div>
    </tr>
    <?php endif;?>

</div>
<div style="width:100%;overflow-x:auto">
    <table class="table ">
        <thead class="table-info">
            <tr class="text-center">
                <th>#</th>
                <th style="min-width:120px;">No SO</th>
                <th style="min-width:120px;">SKU</th>
                <th style="min-width:120px;">Kept by</th>
                <th>Qty PO </th>
                <th>Qty Req </th>
                <th>Qty Keep</th>
                <th>Status</th>
                <th style="min-width:120px;"> Req Date</th>
                <th style="min-width:120px;"> Keep Date</th>
                <th style="min-width:120px;">Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody style="background-color:white;">
            <?php

    // function status button
    function button($status, $status_notif){
        $classButton = "";
        $textButton = "";
        
        if ($status == "1") {
            if ($status_notif == '1') {
                # code...
                $classButton = "btn-success disabled sudahnotif";
                $textButton = "disiapkan";
            } else {
                # code...
                $classButton = "btn-success disabled";
                $textButton = "disiapkan";
            }
            
            # code...
        }  else if($status == "3" || $status == "4" || $status == "2" ){
            # code...
            $classButton = "btn-success d-none sudahnotif";
            $textButton = "";
        }else{
            $classButton = "btn-primary ";
            $textButton = "siapkan";
        }
        return ['classButton'=>$classButton, 'textButton'=>$textButton];
        
    }
        
       
        // declare
            while ($dtl = $resl2->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $dtl['noso']; ?></td>
                <td class="text-center"><?php echo $dtl['model']; ?></td>
                <td class="text-center"><?php echo $dtl['user_keep']; ?></td>
                <td class="text-center"><?php echo $dtl['qty_po']; ?></td>
                <td class="text-center"><?php echo $dtl['qty_req']; ?></td>
                <td class="text-center"><?php echo $dtl['qty_keep']; ?></td>
                <td class="text-center"><?php echo status($dtl['status_keep']); ?></td>
                <td class="text-center"><?php echo $dtl['waktu_req'] ;?></td>
                <td class="text-center"><?php echo $dtl['waktu_keep']; ?></td>
                <td class="text-center"><?php echo $dtl['keterangan_qty']; ?></td>
                <td class="text-center" style="min-width:180px;">
                    <?php if($akses == "4" ):?>
                    <!-- <div class="input-group"> -->
                    <input type="hidden" placeholder='qty' value="<?php echo $dtl['qty_req']; ?>"
                        id='input_<?=$dtl['id'];?>' class="form-control" disabled>
                    <!-- <span class="input-group-append"> -->
                    <button type="button"
                        class="btn <?php echo button($dtl['status_keep'],$dtl['notif'])['classButton'];?> keepstock "
                        id="<?=$dtl['id'];?>" sku="<?=$dtl['model'];?>" user_req="<?=$dtl['user'];?>"
                        qty_req="<?=$dtl['qty_req'];?>" qty_keep="<?=$dtl['qty_keep'];?>" noso="<?=$dtl['noso'];?>"
                        no_keepstock="<?=$dtl['no_keepstock'];?>">
                        <?php echo button($dtl['status_keep'],$dtl['notif'])['textButton'];?>
                    </button>
                    <!-- </span> -->
                    <!-- </div> -->
                    <?php endif;?>




                    <?php if($akses == "4" AND $dtl['status_keep'] =="3"):?>
                    <input type="hidden" placeholder='qty' value="<?php echo $dtl['qty_req']; ?>"
                        id='input_<?=$dtl['id'];?>' class="form-control" disabled>
                    <?php endif;?>


                    <?php if($akses == "1" AND $dtl['status_keep'] =="0"):?>
                    <div class="input-group">
                        <input type="number" placeholder='qty' value="<?php echo $dtl['qty_req']; ?>"
                            id='input_<?=$dtl['id'];?>' class="form-control">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary keepstock" id="<?=$dtl['id'];?>" status='edit'
                                sku="<?=$dtl['model'];?>" user_req="<?=$dtl['user'];?>" qty_req="<?=$dtl['qty_req'];?>"
                                qty_keep="<?=$dtl['qty_keep'];?>" noso="<?=$dtl['noso'];?>"
                                no_keepstock="<?=$dtl['no_keepstock'];?>">
                                Edit
                            </button>
                            <button class="btn btn-danger hapus" id="<?=$dtl['id'];?>" sku="<?=$dtl['model'];?>"
                                noso="<?=$dtl['noso'];?>" qty_req="<?=$dtl['qty_req'];?>"><i
                                    class="fa fa-trash"></i></button>
                        </span>
                    </div>
                    <?php endif;?>
                </td>
            </tr>
            <?php } ?>
            <input type="hidden" id="jumlah_sku" name="jumlah_sku" value="<?=$no-1;?>">
        </tbody>
    </table>
    <table class="table table-bordered" style="background-color:white; width:70%;">
        <thead class="table-danger">
            <tr>
                <th class="text-center bg-danger">
                    Alasan Cancel:
                </th>
                <th class="text-center">
                    Cancel by:
                </th>
                <th class="text-center">
                    Action:
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">
                    <?=$alasan_cancel?>
                </td>
                <td class="text-center">
                    <?=$user_cancel?>
                </td>
                <td class="text-center">
                    <?php if(ambilStatusperkeepstock($id) == "3" && $leveluser == "admin" && $moduluser =="4" ):?>
                    <button type="btn btn-danger " id="<?=$id?>" noso="<?=$noso?>" customer="<?=$customer?>"
                        class="btn btn-xs btn-danger hapusKeepstock">Cancel
                        Keepstock
                    </button>
                    <?php endif;?>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<tr></tr>