<?php 
include '../config/connection.php';

$id = $_GET['id'];
// $data = array();

$sql = "SELECT a.No_Co, 
    b.customer_nama, 
    b.noso, 
    c.tgl_po, 
    b.tgl_create, 
    a.tgl_delivery,
    COUNT(e.model) AS qty  
FROM customerorder_hdr_delivery a
JOIN customerorder_hdr b ON a.No_Co = b.No_Co 
JOIN salesorder_hdr c ON b.noso = c.noso
JOIN customerorder_dtl_delivery e ON a.No_Co = e.No_Co
WHERE b.sales = '$id' AND  a.komplain = '0'
GROUP BY a.No_Co
ORDER BY a.tgl_delivery DESC";
$pcs = $db1->prepare($sql);
$pcs->execute();
$res = $pcs->get_result();
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);