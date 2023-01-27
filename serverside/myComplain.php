<?php

include '../config/connection.php';

$name = $_GET['id'];
$data = array();

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM tb_komplain_hdr WHERE sales = '$name'";
    $pcs = $db1->prepare($sql);
    $pcs->execute();
    $res = $pcs->get_result();

    while ($row = $res->fetch_assoc()) {
        $data[] = array(
            'komplain_id' => $row['komplain_id'],
            'customer'  => $row['nama_customer'],
            'noco'  => $row['No_Co'],
            'tglKomplain'   => date('d/m/Y', $row['date_created']),
            'status'    => $row['status']
        );
    }
} else {
    $sql = "SELECT * FROM `tb_komplain_hdr` ORDER BY `tb_komplain_hdr`.`komplain_id` DESC ";
    $pcs = $db1->prepare($sql);
    $pcs->execute();
    $res = $pcs->get_result();

    while ($row = $res->fetch_assoc()) {
        $data[] = array(
            'komplain_id' => $row['komplain_id'],
            'customer'  => $row['nama_customer'],
            'noco'  => $row['No_Co'],
            'tglKomplain'   => date('d/m/Y', $row['date_created']),
            'status'    => $row['status'],
            'sales' => $row['sales']
        );
    }
}

echo json_encode($data);
