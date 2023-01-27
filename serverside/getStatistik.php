<?php
    session_start();
    if(!isset($_SESSION['usernameu'])) {
        echo 'Anda belum <b>Login</b>, Silahkan Login terlebih dahulu <a href="https://horekadepot.com/mkits">Click Here</a>';
    } else {
        include '../config/connection.php';
        $id = $_GET['id'];
        
        if($_GET['id'] == 'sco') {
            $data = array();
            $query  = "SELECT a.sales, 
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
            GROUP BY a.sales";
            $pcs = $pdo->query($query);
            $pcs -> setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $pcs->fetch()) {
                $data[] = $row;
            }
            print_r(json_encode($data));
        } elseif($_GET['id'] == 'co') {
            $array = array();
            $queryco  = "SELECT a.sales, 
                SUM(IF(MONTH(a.tgl_create)='01', b.harga_total, 0)) AS Jan,
                SUM(IF(MONTH(a.tgl_create)='02', b.harga_total, 0)) AS Feb,
                SUM(IF(MONTH(a.tgl_create)='03', b.harga_total, 0)) AS Mar,
                SUM(IF(MONTH(a.tgl_create)='04', b.harga_total, 0)) AS Apr,
                SUM(IF(MONTH(a.tgl_create)='05', b.harga_total, 0)) AS Mei,
                SUM(IF(MONTH(a.tgl_create)='06', b.harga_total, 0)) AS Jun,
                SUM(IF(MONTH(a.tgl_create)='07', b.harga_total, 0)) AS Jul,
                SUM(IF(MONTH(a.tgl_create)='08', b.harga_total, 0)) AS Ags,
                SUM(IF(MONTH(a.tgl_create)='09', b.harga_total, 0)) AS Sep,
                SUM(IF(MONTH(a.tgl_create)='10', b.harga_total, 0)) AS Okt,
                SUM(IF(MONTH(a.tgl_create)='11', b.harga_total, 0)) AS Nov,
                SUM(IF(MONTH(a.tgl_create)='12', b.harga_total, 0)) AS Des
            FROM customerorder_dtl b
            LEFT JOIN customerorder_hdr a  ON b.No_Co = a.No_Co
            WHERE YEAR(a.tgl_create) = YEAR(CURRENT_DATE()) AND a.status !='2'
            GROUP BY a.sales";
            $mwk = $pdo->query($queryco);
            $mwk -> setFetchMode(PDO::FETCH_ASSOC);
            while ($rows = $mwk->fetch()) {
                $array[] = $rows;
            }
            print_r(json_encode($array));
        }
    }

    
