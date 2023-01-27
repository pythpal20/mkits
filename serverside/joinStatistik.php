<?php
include '../config/connection.php';

$query = "SELECT * FROM (SELECT a.sales, 
SUM(IF(MONTH(a.tgl_po)='01', b.harga_total, 0)) AS Jan,
SUM(IF(MONTH(a.tgl_po)='02', b.harga_total, 0)) AS Feb,
SUM(IF(MONTH(a.tgl_po)='03', b.harga_total, 0)) AS Mar,
SUM(IF(MONTH(a.tgl_po)='04', b.harga_total, 0)) AS Apr,
SUM(IF(MONTH(a.tgl_po)='05', b.harga_total, 0)) AS Mei,
SUM(IF(MONTH(a.tgl_po)='06', b.harga_total, 0)) AS Jun,
SUM(IF(MONTH(a.tgl_po)='07', b.harga_total, 0)) AS Jul,
SUM(IF(MONTH(a.tgl_po)='08', b.harga_total, 0)) AS Ags,
SUM(IF(MONTH(a.tgl_po)='09', b.harga_total, 0)) AS Sep,
SUM(IF(MONTH(a.tgl_po)='10', b.harga_total, 0)) AS Okt,
SUM(IF(MONTH(a.tgl_po)='11', b.harga_total, 0)) AS Nov,
SUM(IF(MONTH(a.tgl_po)='12', b.harga_total, 0)) AS Des
FROM salesorder_dtl b
LEFT JOIN salesorder_hdr a  ON b.noso = a.noso
WHERE YEAR(a.tgl_po) = YEAR(CURRENT_DATE()) AND a.status !='2'
GROUP BY a.sales) AS tablea
JOIN 
(SELECT a.sales, 
SUM(IF(MONTH(a.tgl_create)='01', b.harga_total, 0)) AS Jan1,
SUM(IF(MONTH(a.tgl_create)='02', b.harga_total, 0)) AS Feb1,
SUM(IF(MONTH(a.tgl_create)='03', b.harga_total, 0)) AS Mar1,
SUM(IF(MONTH(a.tgl_create)='04', b.harga_total, 0)) AS Apr1,
SUM(IF(MONTH(a.tgl_create)='05', b.harga_total, 0)) AS Mei1,
SUM(IF(MONTH(a.tgl_create)='06', b.harga_total, 0)) AS Jun1,
SUM(IF(MONTH(a.tgl_create)='07', b.harga_total, 0)) AS Jul1,
SUM(IF(MONTH(a.tgl_create)='08', b.harga_total, 0)) AS Ags1,
SUM(IF(MONTH(a.tgl_create)='09', b.harga_total, 0)) AS Sep1,
SUM(IF(MONTH(a.tgl_create)='10', b.harga_total, 0)) AS Okt1,
SUM(IF(MONTH(a.tgl_create)='11', b.harga_total, 0)) AS Nov1,
SUM(IF(MONTH(a.tgl_create)='12', b.harga_total, 0)) AS Des1
FROM customerorder_dtl b
LEFT JOIN customerorder_hdr a  ON b.No_Co = a.No_Co
WHERE YEAR(a.tgl_create) = YEAR(CURRENT_DATE()) AND a.status !='2'
GROUP BY a.sales) AS tableb ON tablea.sales = tableb.sales
GROUP BY tablea.sales, tableb.sales";
$pcs = $pdo->query($query);
$pcs->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $pcs->fetch()) {
    $data[] = $row;
}
print_r(json_encode($data));
