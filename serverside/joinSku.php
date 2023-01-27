<?php

error_reporting(0);
include '../config/connection.php';
$id = $_GET['id'];

$data = array();

$query = "SELECT * FROM (SELECT b.model,
SUM(IF(MONTH(a.tgl_po)='01', b.qty, 0)) AS Jan,
SUM(IF(MONTH(a.tgl_po)='02', b.qty, 0)) AS Feb,
SUM(IF(MONTH(a.tgl_po)='03', b.qty, 0)) AS Mar,
SUM(IF(MONTH(a.tgl_po)='04', b.qty, 0)) AS Apr,
SUM(IF(MONTH(a.tgl_po)='05', b.qty, 0)) AS Mei,
SUM(IF(MONTH(a.tgl_po)='06', b.qty, 0)) AS Jun,
SUM(IF(MONTH(a.tgl_po)='07', b.qty, 0)) AS Jul,
SUM(IF(MONTH(a.tgl_po)='08', b.qty, 0)) AS Ags,
SUM(IF(MONTH(a.tgl_po)='09', b.qty, 0)) AS Sep,
SUM(IF(MONTH(a.tgl_po)='10', b.qty, 0)) AS Okt,
SUM(IF(MONTH(a.tgl_po)='11', b.qty, 0)) AS Nov,
SUM(IF(MONTH(a.tgl_po)='12', b.qty, 0)) AS Des
FROM salesorder_hdr a
JOIN salesorder_dtl b ON a.noso = b.noso
JOIN master_customer c ON a.customer_id = c.customer_id
WHERE YEAR(a.tgl_po) = YEAR(CURRENT_DATE()) AND a.customer_id = '$id'
GROUP BY b.model) AS table_a
JOIN (
SELECT b.model,
SUM(IF(MONTH(a.tgl_order)='01', b.qty_kirim, 0)) AS Jan2,
SUM(IF(MONTH(a.tgl_order)='02', b.qty_kirim, 0)) AS Feb2,
SUM(IF(MONTH(a.tgl_order)='03', b.qty_kirim, 0)) AS Mar2,
SUM(IF(MONTH(a.tgl_order)='04', b.qty_kirim, 0)) AS Apr2,
SUM(IF(MONTH(a.tgl_order)='05', b.qty_kirim, 0)) AS Mei2,
SUM(IF(MONTH(a.tgl_order)='06', b.qty_kirim, 0)) AS Jun2,
SUM(IF(MONTH(a.tgl_order)='07', b.qty_kirim, 0)) AS Jul2,
SUM(IF(MONTH(a.tgl_order)='08', b.qty_kirim, 0)) AS Ags2,
SUM(IF(MONTH(a.tgl_order)='09', b.qty_kirim, 0)) AS Sep2,
SUM(IF(MONTH(a.tgl_order)='10', b.qty_kirim, 0)) AS Okt2,
SUM(IF(MONTH(a.tgl_order)='11', b.qty_kirim, 0)) AS Nov2,
SUM(IF(MONTH(a.tgl_order)='12', b.qty_kirim, 0)) AS Des2
FROM customerorder_hdr a
JOIN customerorder_dtl b ON a.No_Co = b.No_Co
JOIN master_customer c ON a.customer_id = c.customer_id
WHERE YEAR(a.tgl_order) = YEAR(CURRENT_DATE()) AND a.customer_id = '$id'
GROUP BY b.model) AS table_b ON table_a.model = table_b.model
JOIN (
SELECT b.model,
SUM(IF(MONTH(a.tgl_order)='01', b.qty_kirim, 0)) AS Jan3,
SUM(IF(MONTH(a.tgl_order)='02', b.qty_kirim, 0)) AS Feb3,
SUM(IF(MONTH(a.tgl_order)='03', b.qty_kirim, 0)) AS Mar3,
SUM(IF(MONTH(a.tgl_order)='04', b.qty_kirim, 0)) AS Apr3,
SUM(IF(MONTH(a.tgl_order)='05', b.qty_kirim, 0)) AS Mei3,
SUM(IF(MONTH(a.tgl_order)='06', b.qty_kirim, 0)) AS Jun3,
SUM(IF(MONTH(a.tgl_order)='07', b.qty_kirim, 0)) AS Jul3,
SUM(IF(MONTH(a.tgl_order)='08', b.qty_kirim, 0)) AS Ags3,
SUM(IF(MONTH(a.tgl_order)='09', b.qty_kirim, 0)) AS Sep3,
SUM(IF(MONTH(a.tgl_order)='10', b.qty_kirim, 0)) AS Okt3,
SUM(IF(MONTH(a.tgl_order)='11', b.qty_kirim, 0)) AS Nov3,
SUM(IF(MONTH(a.tgl_order)='12', b.qty_kirim, 0)) AS Des3
FROM customerorder_hdr a
JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
JOIN master_customer c ON a.customer_id = c.customer_id
WHERE YEAR(a.tgl_order) = YEAR(CURRENT_DATE()) AND a.customer_id = '$id'
GROUP BY b.model) AS table_c ON table_a.model = table_c.model
GROUP BY table_a.model, table_b.model, table_c.model";
$pcs = $pdo->query($query);
$pcs->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $pcs->fetch()) {
    $data[] = $row;
}
print_r(json_encode($data));