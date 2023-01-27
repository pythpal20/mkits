<?php
include '../../config/connection.php';
session_start();

$mode = $_POST['id'];

$sql = "SELECT a.*, b.deskripsi FROM customerorder_dtl_delivery a 
JOIN master_produk b ON a.model = b.model
WHERE No_Co ='$mode'";
$pcs = $db1->prepare($sql);
$pcs -> execute();
$result = $pcs->get_result();

$html = '';

if(isset($_POST['id'])) {

$html .='<table class="tb_sku table table-bordered" data-page-size="5" width="100">
<thead>
    <tr>
        <th>Model</th>
        <th>Deskripsi</th>
        <th>QTY Kirim</th>
    </tr>
</thead>
<tbody>';
while($row = $result->fetch_assoc()) {
    $html .='
    <tr>    
        <td>' . $row["model"] . '</td>
        <td>' . $row["deskripsi"] . '</td>
        <td>' . number_format($row["qty_kirim"], 0, ".", ".") . '</td>
    </tr>';
}
$html .='</tbody></table>';
}
echo $html;