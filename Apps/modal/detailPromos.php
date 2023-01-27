<?php
    if(isset($_POST['id'])) {
        include '../../config/connection.php';
        $output = '';

        $kuery = "SELECT * FROM bundle_promo WHERE promo_id = '" . $_POST['id'] . "'";
        $pcs = $db1->prepare($kuery);
        $pcs -> execute();
        $resl = $pcs -> get_result();
        $row = $resl->fetch_assoc();

        $kueri = "SELECT * FROM bundle_promo_dtl WHERE promo_id = '" . $_POST['id'] . "' ORDER BY norut ASC";
        $pcs = $db1->prepare($kueri);
        $pcs -> execute();
        $reslt = $pcs -> get_result();
       
        $output .= '<table class="table table-borderless" width="100%">
        <tr>
            <th>Kode Promo</th>
            <td>:</td>
            <th>'. $row["promo_id"].'</th>
            <th>Created By</th>
            <td>:</td>
            <th>'. $row["promo_addby"].'</th>
        </tr>
        <tr>
            <th>Nama Promo</th>
            <td>:</td>
            <th>'. $row["promo_name"].'</th>
            <th>Created Date</th>
            <td>:</td>
            <th>'. $row["promo_date"].'</th>
        </tr>
        <tr>
            <th>Desc</th>
            <td>:</td>
            <th colspan="4">'. $row["promo_description"].'</th>
        </tr>
    </table><hr style="background-color:red;">';
    $output .= '<table class="table table-bordered detailPrm" id="detailPrm" width="100%">
    <thead class="table-warning">
        <tr>
            <th>SKU/ Model</th>
            <th>Basic Price</th>
            <th>Disc %</th>
            <th>Discount</th>
            <th>Promo Price</th>
            <th>Min Qty</th>
        </tr>
    </thead>
    <tbody>';
    while ($rw = $reslt->fetch_assoc()){
        $output .= '<tr>
        <td class="table-info">' . $rw["model"] . '</td>
        <td>' . $rw["harga_default"] . '</td>
        <td>' . $rw["disc_percent"] . ' %</td>
        <td>' . $rw["diskon"] . '</td>
        <td>' . $rw["harga_promo"] . '</td>
         <td>' . $rw["promo_qty"] . '</td>
        </tr>';
    }
    $output .='</table>';

    echo $output;
    }
    ?>