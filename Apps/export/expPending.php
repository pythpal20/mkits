<?php
    include '../../config/connection.php';
    $kategori = $_POST['kategori'];

    if($kategori == 'all') {
        $start      = $_POST['tglawal'];
        $end        = $_POST['tglakhir'];
        $kategori   = $_POST['kategori'];

        $no         = 1;
        // var_dump($_POST);die();
        $query = "SELECT a.noso, b.tgl_po, c.customer_nama, b.sales, b.term,  a.alamat_krm,  d.nama_pt, e.model, e.price, e.diskon, e.ppn, e.qty_sisa
        FROM customerorder_hdr_pending a
        JOIN salesorder_hdr b ON a.noso = b.noso
        JOIN master_customer c ON a.customer_id = c.customer_id
        JOIN list_perusahaan d ON b.id_perusahaan = d.id_perusahaan
        JOIN customerorder_dtl_pending e ON a.noso = e.noso
        WHERE b.tgl_po BETWEEN '$start' AND '$end' ORDER BY b.tgl_po ASC";
        $mwk = $db1->prepare($query);
        $mwk -> execute();
        $resl = $mwk->get_result();

        $data_html = '<table width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>No. SO</th>
                <th>Tanggal PO</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>Term</th>
                <th>Alamat Kirim</th>
                <th>Perusahaan</th>
                <th>Model</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Amount</th>
                <th>Diskon</th>
                <th>PPN</th>
                <th>Total</th>
            </tr>
        </thead> 
        <tbody>';
        while ($row = $resl->fetch_assoc()){
            $noso = $row['noso'];
            $tgl = $row['tgl_po'];
            $customer = $row['customer_nama'];
            $sales = $row['sales'];
            $term = $row['term'];
            $alamat = $row['alamat_krm'];
            $pt     = $row['nama_pt'];
            $sku    = $row['model'];
            $harga = $row['price'];
            $disk = $row['diskon'];
            $bool_ppn = $row['ppn'];
            $qty = $row['qty_sisa'];
    
            if($bool_ppn == '1'){
                $amount = $qty * $harga;
                $diskon = $disk;
                $ppn = (($qty * $harga)-$diskon) * (10/100);
    
                $total = (($qty * $harga)-$diskon) + $ppn;
            } elseif($bool_ppn == '0') {
                $ppn = 0;
    
                $amount = $qty * $harga;
                $diskon = $disk;
    
                $total = (($qty*$harga)-$diskon) + $ppn;
            }
            // var_dump($sales); die();
            $data_html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $noso . '</td>
                <td>' . $tgl . '</td>
                <td>' . $customer . '</td>
                <td>' . $sales . '</td>
                <td>' . $term . '</td>
                <td>' . $alamat . '</td>
                <td>' . $pt . '</td>
                <td>' . $sku . '</td>
                <td>' . $qty . '</td>
                <td>' . $harga . '</td>
                <td>' . $amount . '</td>
                <td>' . $diskon . '</td>
                <td>' . $ppn . '</td>
                <td>' . $total . '</td>
            </tr>';
        }
        $data_html .='</tbody> 
        </table>';
        
    } elseif($kategori == 'salesmarketing') { //ketika kategori "SALES & Marketing"
        $start      = $_POST['tglawal'];
        $end        = $_POST['tglakhir'];
        $kategori   = $_POST['kategori'];

        $no         = 1;
        // var_dump($_POST);die();
        $query1 = "SELECT a.noso, b.tgl_po, c.customer_nama, b.sales, b.term,  a.alamat_krm,  d.nama_pt, e.model, e.price, e.diskon, e.ppn, e.qty_sisa
        FROM customerorder_hdr_pending a
        JOIN salesorder_hdr b ON a.noso = b.noso
        JOIN master_customer c ON a.customer_id = c.customer_id
        JOIN list_perusahaan d ON b.id_perusahaan = d.id_perusahaan
        JOIN customerorder_dtl_pending e ON a.noso = e.noso
        WHERE b.tgl_po BETWEEN '$start' AND '$end' AND b.jenis_transaksi = 'TELEPON' OR b.jenis_transaksi = 'KUNJUNGAN' ORDER BY b.tgl_po ASC";
        $mwk = $db1->prepare($query1);
        $mwk -> execute();
        $resl1 = $mwk->get_result();

        $data_html = '<table width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>No. SO</th>
                <th>Tanggal PO</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>Term</th>
                <th>Alamat Kirim</th>
                <th>Perusahaan</th>
                <th>Model</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Amount</th>
                <th>Diskon</th>
                <th>PPN</th>
                <th>Total</th>
            </tr>
        </thead> 
        <tbody>';
        while ($row = $resl1->fetch_assoc()){
            $noso = $row['noso'];
            $tgl = $row['tgl_po'];
            $customer = $row['customer_nama'];
            $sales = $row['sales'];
            $term = $row['term'];
            $alamat = $row['alamat_krm'];
            $pt     = $row['nama_pt'];
            $sku    = $row['model'];
            $harga = $row['price'];
            $disk = $row['diskon'];
            $bool_ppn = $row['ppn'];
            $qty = $row['qty_sisa'];
    
            if($bool_ppn == '1'){
                $amount = $qty * $harga;
                $diskon = $disk;
                $ppn = (($qty * $harga)-$diskon) * (10/100);
    
                $total = (($qty * $harga)-$diskon) + $ppn;
            } elseif($bool_ppn == '0') {
                $ppn = 0;
    
                $amount = $qty * $harga;
                $diskon = $disk;
    
                $total = (($qty*$harga)-$diskon) + $ppn;
            }
            // var_dump($sales); die();
            $data_html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $noso . '</td>
                <td>' . $tgl . '</td>
                <td>' . $customer . '</td>
                <td>' . $sales . '</td>
                <td>' . $term . '</td>
                <td>' . $alamat . '</td>
                <td>' . $pt . '</td>
                <td>' . $sku . '</td>
                <td>' . $qty . '</td>
                <td>' . $harga . '</td>
                <td>' . $amount . '</td>
                <td>' . $diskon . '</td>
                <td>' . $ppn . '</td>
                <td>' . $total . '</td>
            </tr>';
        }
        $data_html .='</tbody> 
        </table>';
    } elseif($kategori == 'marketplace') { //marketplace data
        $start      = $_POST['tglawal'];
        $end        = $_POST['tglakhir'];
        $kategori   = $_POST['kategori'];

        $no         = 1;
        // var_dump($_POST);die();
        $query2 = "SELECT a.noso, b.tgl_po, c.customer_nama, b.sales, b.term,  a.alamat_krm,  d.nama_pt, e.model, e.price, e.diskon, e.ppn, e.qty_sisa
        FROM customerorder_hdr_pending a
        JOIN salesorder_hdr b ON a.noso = b.noso
        JOIN master_customer c ON a.customer_id = c.customer_id
        JOIN list_perusahaan d ON b.id_perusahaan = d.id_perusahaan
        JOIN customerorder_dtl_pending e ON a.noso = e.noso
        WHERE b.tgl_po BETWEEN '$start' AND '$end' AND b.jenis_transaksi = 'MARKETPLACE'  ORDER BY b.tgl_po ASC";
        $mwk = $db1->prepare($query2);
        $mwk -> execute();
        $resl2 = $mwk->get_result();

        $data_html = '<table width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>No. SO</th>
                <th>Tanggal PO</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>Term</th>
                <th>Alamat Kirim</th>
                <th>Perusahaan</th>
                <th>Model</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Amount</th>
                <th>Diskon</th>
                <th>PPN</th>
                <th>Total</th>
            </tr>
        </thead> 
        <tbody>';
        while ($row = $resl2->fetch_assoc()){
            $noso = $row['noso'];
            $tgl = $row['tgl_po'];
            $customer = $row['customer_nama'];
            $sales = $row['sales'];
            $term = $row['term'];
            $alamat = $row['alamat_krm'];
            $pt     = $row['nama_pt'];
            $sku    = $row['model'];
            $harga = $row['price'];
            $disk = $row['diskon'];
            $bool_ppn = $row['ppn'];
            $qty = $row['qty_sisa'];
    
            if($bool_ppn == '1'){
                $amount = $qty * $harga;
                $diskon = $disk;
                $ppn = (($qty * $harga)-$diskon) * (10/100);
    
                $total = (($qty * $harga)-$diskon) + $ppn;
            } elseif($bool_ppn == '0') {
                $ppn = 0;
    
                $amount = $qty * $harga;
                $diskon = $disk;
    
                $total = (($qty*$harga)-$diskon) + $ppn;
            }
            // var_dump($sales); die();
            $data_html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $noso . '</td>
                <td>' . $tgl . '</td>
                <td>' . $customer . '</td>
                <td>' . $sales . '</td>
                <td>' . $term . '</td>
                <td>' . $alamat . '</td>
                <td>' . $pt . '</td>
                <td>' . $sku . '</td>
                <td>' . $qty . '</td>
                <td>' . $harga . '</td>
                <td>' . $amount . '</td>
                <td>' . $diskon . '</td>
                <td>' . $ppn . '</td>
                <td>' . $total . '</td>
            </tr>';
        }
        $data_html .='</tbody> 
        </table>';
    } elseif($kategori == 'showroom') {
        $start      = $_POST['tglawal'];
        $end        = $_POST['tglakhir'];
        $kategori   = $_POST['kategori'];

        $no         = 1;
        // var_dump($_POST);die();
        $query3 = "SELECT a.noso, b.tgl_po, c.customer_nama, b.sales, b.term,  a.alamat_krm,  d.nama_pt, e.model, e.price, e.diskon, e.ppn, e.qty_sisa
        FROM customerorder_hdr_pending a
        JOIN salesorder_hdr b ON a.noso = b.noso
        JOIN master_customer c ON a.customer_id = c.customer_id
        JOIN list_perusahaan d ON b.id_perusahaan = d.id_perusahaan
        JOIN customerorder_dtl_pending e ON a.noso = e.noso
        WHERE b.tgl_po BETWEEN '$start' AND '$end' AND b.jenis_transaksi = 'SHOWROOM' ORDER BY b.tgl_po ASC";
        $mwk = $db1->prepare($query3);
        $mwk -> execute();
        $resl3 = $mwk->get_result();

        $data_html = '<table width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>No. SO</th>
                <th>Tanggal PO</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>Term</th>
                <th>Alamat Kirim</th>
                <th>Perusahaan</th>
                <th>Model</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Amount</th>
                <th>Diskon</th>
                <th>PPN</th>
                <th>Total</th>
            </tr>
        </thead> 
        <tbody>';
        while ($row = $resl3->fetch_assoc()){
            $noso = $row['noso'];
            $tgl = $row['tgl_po'];
            $customer = $row['customer_nama'];
            $sales = $row['sales'];
            $term = $row['term'];
            $alamat = $row['alamat_krm'];
            $pt     = $row['nama_pt'];
            $sku    = $row['model'];
            $harga = $row['price'];
            $disk = $row['diskon'];
            $bool_ppn = $row['ppn'];
            $qty = $row['qty_sisa'];
    
            if($bool_ppn == '1'){
                $amount = $qty * $harga;
                $diskon = $disk;
                $ppn = (($qty * $harga)-$diskon) * (10/100);
    
                $total = (($qty * $harga)-$diskon) + $ppn;
            } elseif($bool_ppn == '0') {
                $ppn = 0;
    
                $amount = $qty * $harga;
                $diskon = $disk;
    
                $total = (($qty*$harga)-$diskon) + $ppn;
            }
            // var_dump($sales); die();
            $data_html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $noso . '</td>
                <td>' . $tgl . '</td>
                <td>' . $customer . '</td>
                <td>' . $sales . '</td>
                <td>' . $term . '</td>
                <td>' . $alamat . '</td>
                <td>' . $pt . '</td>
                <td>' . $sku . '</td>
                <td>' . $qty . '</td>
                <td>' . $harga . '</td>
                <td>' . $amount . '</td>
                <td>' . $diskon . '</td>
                <td>' . $ppn . '</td>
                <td>' . $total . '</td>
            </tr>';
        }
        $data_html .='</tbody> 
        </table>';
    }
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data SCO Pending ". $kategori . "_".$start." - " . $end . ".xls");
    echo $data_html;
?>