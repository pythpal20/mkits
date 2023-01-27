<?php
    include '../../config/connection.php';
    include '../../assets/phpqrcode/qrlib.php'; 
    
    $output = '';
    if (isset($_POST['id'])){
        $nama = $_POST['id'];
        $qry = "SELECT * FROM master_user WHERE user_nama= '$nama'";
        $mwk = $db1->prepare($qry);
        $mwk -> execute();
        $results = $mwk->get_result();
        $row=$results->fetch_assoc();

        $tempdir = '../../img/qrcode/';
        if (!file_exists($tempdir))
        mkdir($tempdir);
        $codeContents = 'http://wa.me/62'. substr($row['notelp'],1);
        QRcode::png($codeContents,$tempdir."QR".$row['user_id'].".png"); 

        $output .= '
        <table width="100%">
            <tr>
                <td>ID</td>
                <td>:</td>
                <th>' . $row["user_id"] . '</th>
                <td rowspan="4"><img src="../img/qrcode/QR'.$row["user_id"].'.png"></td>
            </tr>
            <tr>
                <td>Nama Sales</td>
                <td>:</td>
                <th>' . $row["user_nama"] . '</th>
            </tr>
            <tr>
                <td>E-mail</td>
                <td>:</td>
                <th>' . $row["email"] . '</th>
            </tr>
            <tr>
                <td>No. Telp/Hp</td>
                <td>:</td>
                <th><a href="http://wa.me/62'. substr($row["notelp"],1) .'" target="_blank">' . $row["notelp"] . '</th>
            </tr>
        </table>';
    } else {
        $output .= '<b>NO DATA TO SEE :( </b>';
    }
    echo $output;
?>