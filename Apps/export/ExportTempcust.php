<?php
    include '../../config/connection.php';
    // var_dump($_POST);

    error_log(0);
   
    $query  = "SELECT  a.ID,
    a.customer_nama,
    a.jenis_usaha,
    b.wilayah_nama,
    a.pic,
    a.customer_idregister,
    a.status FROM temp_customer a
    LEFT JOIN master_wilayah b ON a.kota = b.wilayah_id
    ORDER BY a.ID ASC";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();

$data_html ='<table border="1" style="border: 1px solid black; border-collapse: collapse; width:100%;">
    <thead>
        <tr>
            <th rowspan="1">No</th>
            <th rowspan="1">ID Register</th>
            <th rowspan="1">Customer Nama</th>
            <th rowspan="1">Jenis Usaha</th>
            <th rowspan="1">Wilayah</th>
            <th rowspan="1">PIC</th>
            <th rowspan="1">Status</th>
        </tr>
    </thead>
    <tbody>';
            $no = 1;
            while ($row = $resl->fetch_assoc()) {
$data_html .='
<tr>
    <td>' .  $no  . '</td>
    <td>' .  $row["customer_idregister"]  . '</td>
    <td>' .  $row["customer_nama"]  . '</td>
    <td>' .  $row["jenis_usaha"]  . '</td>
    <td>' .  $row["wilayah_nama"]  . '</td>
    <td>' .  $row["pic"]  . '</td>
    <td>' .  $row["status"]  . '</td>
</tr>';
            $no++;
            }
$data_html .='</tbody>
</table>';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=TempCustomer.xls");
echo $data_html;
?>