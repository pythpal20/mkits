<?php
    include '../../config/connection.php';
    // var_dump($_POST);

    error_log(0);
    $start  = date_format(date_create($_POST['start']), 'Y-m-d');
    $end    = date_format(date_create($_POST['end']), 'Y-m-d');

    $query  = "SELECT * FROM master_kunjungan a
    JOIN temp_customer b ON a.customer_id = b.ID
    JOIN master_user c ON a.sales = c.user_id
    JOIN master_wilayah d ON b.kota = d.wilayah_id
    WHERE a.tgl_followup BETWEEN '$start' AND '$end'
    ORDER BY a.tgl_followup ASC";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();

$data_html ='<table border="1" style="border: 1px solid black; border-collapse: collapse; width:100%;">
    <thead>
        <tr>
            <th colspan="10">Data Followup Sales' . date_format(date_create($start),'d/m/Y') ." - ". date_format(date_create($end), 'd/m/Y')  . '
            </th>
        </tr>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tgl. Followup</th>
            <th colspan="3">Customer</th>
            <th rowspan="2">Jenis</th>
            <th rowspan="2">Hasil Followup</th>
            <th rowspan="2">Deskripsi</th>
            <th rowspan="2">Sales</th>
            <th rowspan="2">Input By</th>
        </tr>
        <tr>
            <th>Nama</th>
            <th>kota</th>
            <th>PIC</th>
        </tr>
    </thead>
    <tbody>';
            $no = 1;
            while ($row = $resl->fetch_assoc()) {
$data_html .='<tr>
    <td>' .  $no  . '</td>
    <td>' .  date_format(date_create($row["tgl_followup"]), 'd/m/Y')  . '</td>
    <td>' .  $row["customer_nama"]  . '</td>
    <td>' .  $row["wilayah_nama"]  . '</td>
    <td>' .  $row["pic"]  . '</td>
    <td>' .  $row["followup_by"] . '</td>
    <td>' .  $row["ket"] . '</td>
    <td>' .  $row["deskripsi_followup"] . '</td>
    <td>' .  $row["user_nama"]  . '</td>
    <td>' .  $row["inputby"] . '</td>
</tr>';
            $no++;
            }
$data_html .='</tbody>
</table>';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Followup ".$start." sampai ".$end.".xls");
echo $data_html;
?>