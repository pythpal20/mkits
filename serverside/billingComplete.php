<?php
session_start();

if(!isset($_SESSION['usernameu'])) {
    echo 'Anda belum <b>Login!</b>, Silahkan login terlebih dahulu <a href="https://horekadepot.com/mkits">Click Here!</a>';
} else {
    include '../config/connection.php';

    $query = "SELECT 
        d.tgl_inv,
        d.no_fa AS nofa_awal,
        a.noso,
        a.No_Co,
        d.customer_nama,
        d.sales,      
        (SELECT SUM(e.harga_total) FROM customerorder_dtl e WHERE e.No_co = a.No_Co)  AS nominal_awal,
        (SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)  AS nominal_akhir,
        a.tgl_delivery,    
        f.tgl_kontrabon,    
        f.tgl_duedate, 
        IFNULL(((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(ROUND(b.harga_total)) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)), 'belum bayar') AS selisih,
        (SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco) AS total_bayar,  
        DATEDIFF( NOW(), f.tgl_duedate ) AS overdue,  
        a.no_fa AS nofa_akhir
    FROM customerorder_hdr_delivery a
    JOIN customerorder_hdr d ON a.No_Co = d.No_Co
    LEFT JOIN kontrabon f ON a.No_Co = f.noco
    WHERE ((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(ROUND(b.harga_total)) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)) >= 0
    GROUP BY a.No_Co";
    $pcs = $pdo->query($query);
    $pcs->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $pcs->fetch()) {
        $data[] = $row;
    }
    print_r(json_encode($data));
}

//MKITS - Mr. Kitchen Integration System 
//Make with <3 by Paulus Christofel S - christofelpaulus@gmail.com
//2021