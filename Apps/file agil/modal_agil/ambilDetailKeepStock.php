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
    while ($hdr = $resl3->fetch_assoc()){
        $noso = $hdr['noso'];
        $customer = $hdr['customer'];
        $duedate = $hdr['duedate'];
        $user = $hdr['user'];
        $user_keep = $hdr['user_keep'];
        $selesai = $hdr['waktu_selesai'];
        $user_selesai = $hdr['user_selesai'];
        $sh = $hdr['no_sh'];
    }
?>
<div class="ibox col-lg-12" style="width:100%;overflow-x:auto">
    <table class="table" width="100%" style="background-color:white;">
        <tr>
            <td>
            <th>No Keep Stock </th>
            <td>:</td>
            <td><?php echo "K-".add_leading_zero($id); ?></td>
            </td>
            <td>
            <th>Requested by </th>
            <td>:</td>
            <td><?php echo $user; ?></td>
            </td>


        </tr>
        <tr>
            <td>
            <th>No SO </th>
            <td>:</td>
            <td><?php echo $noso; ?></td>
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
            <td><?php echo $customer; ?></td>
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
            <th></th>
            <td></td>
            <td></td>
            </td>
            <td>
            <th>No SH </th>
            <td>:</td>
            <td><?php echo $sh; ?></td>
            </td>
        </tr>
    </table>
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
        }else{
            $status = "2";
        }
        
        return $status;
        
    }
    
    ?>
    <?php if(ambilStatusperkeepstock($id) == "1" && $leveluser == "admin" && $moduluser =="1" ):?>
    <tr class="row">
        <div class="col-md-5 float-right">
            <div class="input-group">
                <input type="text" class="form-control" id="nosh" placeholder="No SH">
                <span class="input-group-append">
                    <button type="btn btn-primary" id="<?=$id?>" class="btn btn-primary selesai">Kirim
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
                <th style="min-width:120px;">Requested by</th>
                <th style="min-width:120px;">Kept by</th>
                <th>Qty Req </th>
                <th>Qty Keep</th>
                <th>Status</th>
                <th style="min-width:120px;"> Req Date</th>
                <th style="min-width:120px;"> Keep Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody style="background-color:white;">
            <?php

        
       
        // declare
            while ($dtl = $resl2->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $dtl['noso']; ?></td>
                <td class="text-center"><?php echo $dtl['model']; ?></td>
                <td class="text-center"><?php echo $dtl['user']; ?></td>
                <td class="text-center"><?php echo $dtl['user_keep']; ?></td>
                <td class="text-center"><?php echo $dtl['qty_req']; ?></td>
                <td class="text-center"><?php echo $dtl['qty_keep']; ?></td>
                <td class="text-center"><?php echo status($dtl['status_keep']); ?></td>
                <td class="text-center"><?php echo $dtl['waktu_req'] ;?></td>
                <td class="text-center"><?php echo $dtl['waktu_keep']; ?></td>
                <td class="text-center" style="min-width:180px;">
                    <?php if($akses == "4" AND $dtl['status_keep'] =="0"):?>
                    <!-- <div class="input-group"> -->
                    <input type="hidden" placeholder='qty' value="<?php echo $dtl['qty_req']; ?>"
                        id='input_<?=$dtl['id'];?>' class="form-control" disabled>
                    <!-- <span class="input-group-append"> -->
                    <button type="button" class="btn btn-primary keepstock" id="<?=$dtl['id'];?>"
                        sku="<?=$dtl['model'];?>" qty_req="<?=$dtl['qty_req'];?>" qty_keep="<?=$dtl['qty_keep'];?>"
                        noso="<?=$dtl['noso'];?>" no_keepstock="<?=$dtl['no_keepstock'];?>">
                        Siapkan
                    </button>
                    <!-- </span> -->
                    <!-- </div> -->
                    <?php endif;?>
                    <?php if($akses == "1" AND $dtl['status_keep'] =="0"):?>
                    <div class="input-group">
                        <input type="number" placeholder='qty' value="<?php echo $dtl['qty_req']; ?>"
                            id='input_<?=$dtl['id'];?>' class="form-control">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary keepstock" id="<?=$dtl['id'];?>" status='edit'
                                sku="<?=$dtl['model'];?>" qty_req="<?=$dtl['qty_req'];?>"
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
        </tbody>
    </table>
</div>

<tr></tr>