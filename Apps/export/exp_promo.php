<?php
if (isset($_POST['start']) && isset($_POST['end'])) {
    include '../../config/connection.php';
    $tgl_awal = date_format(date_create($_POST['start']), 'Y-m-d');
    $tgl_akhir = date_format(date_create($_POST['end']), 'Y-m-d');

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Data Promo-Bundling ' . $tgl_awal . ' s/d ' . $tgl_akhir . '.csv');
    //create query here ...

    $output = fopen('php://output', 'w');

    $query = "SELECT promo_id, promo_name, promo_description, promo_date, REPLACE(REPLACE(promo_status, '0', 'tidak aktif'), '1', 'Aktif') AS statuss
    FROM bundle_promo
    WHERE promo_date BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    $pcs = $db1->prepare($query);
    $pcs->execute();
    $hasil = $pcs->get_result();

    fputcsv($output, array('Kode Promo', 'Nama Promo', 'Deskripsi', 'SKU', 'Harga Dasar', 'Diskon (%)', 'Diskon (Rp. )', 'Harga Diskon', 'Min qty', 'Tgl Create', 'Status Promo'));

    while ($row = $hasil->fetch_assoc()) {
        $kueri = "SELECT model, harga_default, diskon, disc_percent, harga_promo, promo_qty FROM bundle_promo_dtl WHERE promo_id = '" . $row['promo_id'] . "'";
        $pcs = $db1->prepare($kueri);
        $pcs->execute();
        $reslt = $pcs->get_result();

        $itm = array();
        $count = 0;

        while ($itms = $reslt->fetch_assoc()) {
            $itm[$count] = array($itms['model'], $itms['harga_default'], $itms['disc_percent'], $itms['diskon'], $itms['harga_promo'] , $itms['promo_qty']);
            $count++;
        }

        for ($i = 0; $i < count($itm); $i++) {
            if ($i == 0) {
                fputcsv($output, array($row['promo_id'], $row['promo_name'], $row['promo_description'], $itm[$i][0], $itm[$i][1], $itm[$i][2], $itm[$i][3], $itm[$i][4], $itm[$i][5], $row['promo_date'], $row['statuss']));
            } else {
                fputcsv($output, array('', '', '', $itm[$i][0], $itm[$i][1], $itm[$i][2], $itm[$i][3], $itm[$i][4], $itm[$i][5], '', ''));
            }
        }
        fputcsv($output, array(' '));
    }
}
