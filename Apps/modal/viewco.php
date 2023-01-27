<?php
    include '../../config/connection.php';
    $noso = $_POST['id'];
    // var_dump($_POST);
    $output ='';
    $no = 1;
    $query = "SELECT * FROM customerorder_hdr WHERE noso = '$noso'";
    $mwk   = $db1->prepare($query);
    $mwk   -> execute();
    $resl  = $mwk->get_result();

    $qry = "SELECT a.noso, b.customer_nama, b.customer_idregister, a.term, b.customer_alamat, a.aproval_by, a.jenis_transaksi, a.sales
    FROM salesorder_hdr a
    JOIN master_customer b ON a.customer_id = b.customer_id
    WHERE a.noso = '$noso'";
    $mwk = $db1 -> prepare($qry);
    $mwk -> execute();
    $hasil = $mwk->get_result();
    $hdr = $hasil->fetch_assoc();
    
    $output .= '<div style="overflow-x: scroll;">
    <table class="table table-borderless" width="100%">
    <tr>
        <th colspan="6" style="text-align:center;" class="table-info">DATA PESANAN</th>
    <tr>
    <tr>    
        <th>ID Customer</th>
        <td>:</td>
        <th> ' . $hdr['customer_idregister'].'</td>
        <th>No. SO</th>
        <td>:</td>
        <th> ' . $hdr['noso'].'</td>
    </tr>
    <tr>    
        <th>Customer</th>
        <td>:</td>
        <th> ' . $hdr['customer_nama'].'</td>
        <th>TOP</th>
        <td>:</td>
        <th> ' . $hdr['term'].'</td>
    </tr>
    <tr>    
        <th>AR Check By</th>
        <td>:</td>
        <th> ' . $hdr['aproval_by'].'</td>
        <th>Sales</th>
        <td>:</td>
        <th> ' . $hdr['sales'].'</td>
    </tr>
    <tr>    
        <th>Alamat</th>
        <td>:</td>
        <th colspan="4"> ' . $hdr['customer_alamat'].'</td>
    </tr>
    </table></div>';

    $output .= '<div class="table-responsive">
    <table class="table "  style="width:100%">
    <thead class="table-warning">
        <tr>   
            <th>#</td>
            <th>PT. </th>
            <th>No CO</th>
            <th>No Inv</th>
            <th>No Surat Jalan</th>
            <th>STATUS KIRIM</th>
            <th>Act</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $resl->fetch_assoc()) {
        if ($row['status_delivery'] == 1 && $row['status'] == 1){
            $dlvr = "<span class='label label-info'>Dikirim</span>";
        } elseif ($row['status_delivery'] == 0 && $row['status'] == 1) {
            $dlvr = "<span class='label label-secondary'>Belum Dikirim</span>";
        } elseif ($row['status_delivery'] == 2 && $row['status'] == 1) {
            $dlvr = "<span class='label label-warning'>Reschedule</span>";
        } else {
            $dlvr = "<span class='label label-danger'>CANCEL</span>";
        }
    $output .= '<tr>
                <td>' . $no++ . '</td>
                <td><b>' . substr($row["No_Co"],0,3) . '</b></td>
                <td>' . substr($row["No_Co"],4) . '</td>
                <td>' . substr($row["no_fa"],4) . '</td>
                <td>' . substr($row["no_bl"],4) . '</td>
                <td>' . $dlvr . '</td>
                <td><a href="vwco.php?id=' . $row["No_Co"] . '" class="btn btn-warning btn-xs">Lihat</a></td>
            </tr>';
    }   
    $output .= '</tbody></table></div>';

    echo $output;
?>