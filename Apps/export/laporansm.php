<?php
	error_reporting(0);
	include '../../config/connection.php';
	$awal = $_POST['tglawal'];
	$akhir = $_POST['tglakhir'];
	$perusahaan = $_POST['perusahaan'];

	$idPT = '%' . $perusahaan . '%';
	$query = "SELECT DISTINCT(a.noso) AS nosoo, a.noso_ref, c.No_Co, c.no_fa, c.no_bl, c.no_sh, e.customer_nama, a.tgl_po, a.tgl_krm AS tglkrmSco, 
	c.tgl_krm AS tglkrmCo, c.tgl_inv, c.term, a.jenis_transaksi, b.model, b.qty, b.price AS hrg_sco, b.diskon As disk_sco, 
	b.ppn AS ppn_sco, b.amount AS amt_sco, b.harga_total AS hrgtot_sco, b.keterangan as ket_sco, d.qty_kirim, d.price AS hrg_co, 
	d.diskon AS disk_co, d.ppn AS ppn_co, d.amount AS amt_co, d.harga_total AS hrgtot_co, d.keterangan ket_co, d.locator, a.sales, a.ongkir, a.keterangan AS ktr_sco, 
	a.aproval_by, a.aproval_date , REPLACE(REPLACE(REPLACE(a.status, '0', 'UNPROCESS'),'1','PROCESS'),'2','CANCEL') AS status_SCO, 
	a.ar_feedback, c.issuedby, REPLACE(REPLACE(REPLACE(c.status, '0', 'UNPROCESS'),'1','PROCESS'),'2','CANCEL') AS status_CO, 
	c.fpp_id, c.keterangan AS revisi, c.updateby
		FROM salesorder_hdr a
		JOIN salesorder_dtl b ON a.noso = b.noso
		LEFT JOIN customerorder_hdr c ON a.noso = c.noso 
		JOIN customerorder_dtl d ON c.No_Co = d.No_Co
		JOIN master_customer e ON a.customer_id = e.customer_id
		WHERE a.tgl_po BETWEEN '$awal' AND '$akhir' AND a.id_perusahaan LIKE '$idPT'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$reslt = $mwk->get_result();

    $html = '<table style="width:100px;border:1px solid black;" border="1">
        <thead>
			<tr>
				<th colspan ="41"><h3>Data Full SCO - CO ' . date_format(date_create($awal), "d F Y") . ' - ' . date_format(date_create($akhir), "d F Y") . '</h3></th>
			</tr>
            <tr>
                <th>No. SO</th>
                <th>No. PO (Referensi)</th>
                <th>No.CO</th>
                <th>No. Faktur</th>
                <th>No. Surat Jalan</th>
                <th>No. Pick Ticket</th>
                <th>Customer</th>
                <th>Tgl. Order</th>
                <th>Tgl. Kirim (SCO)</th>
                <th>Tgl. Kirim (CO)</th>
                <th>Tgl. Inv</th>
                <th>TOP</th>
                <th>Jenis Transaksi</th>
                <th>Model</th>
                <th>Qty (SCO)</th>
                <th>Harga/PCS (SCO)</th>
                <th>Diskon (SCO)</th>
                <th>PPN (SCO)</th>
                <th>Amount (SCO)</th>
                <th>Harga Total (SCO)</th>
                <th>Keterangan Item SCO</th>
                <th>Qty CO</th>
                <th>Harga (CO)</th>
                <th>Diskon (CO)</th>
                <th>PPN (CO)</th>
                <th>Amount (CO)</th>
                <th>Harga Total (CO)</th>
                <th>Keterangan</th>
                <th>Keep Stock (lokator)</th>
                <th>Sales</th>
                <th>Ongkos Kirim</th>
                <th>Keterangan SCO</th>
                <th>Adm. Finance</th>
                <th>Tgl. Finance Check</th>
                <th>Status SCO</th>
                <th>Finance Feedback</th>
                <th>CO Create by</th>
                <th>Status CO</th>
                <th>Kode Perubaha (FPP)</th>
                <th>Revisi</th>
                <th>Update By</th>
            </tr>
        </thead>
        <tbody>';
		if ($reslt->num_rows>0) {
        	while($row = $reslt->fetch_assoc()) {
            $html .= "<tr>
                <td>" . $row['nosoo'] . "</td>
                <td>" . $row['noso_ref'] . "</td>
                <td>" . $row['No_Co'] . "</td>
                <td>" . $row['no_fa'] . "</td>
                <td>" . $row['no_bl'] . "</td>
                <td>" . $row['no_sh'] . "</td>
                <td>" . $row['customer_nama'] . "</td>
                <td>" . $row['tgl_po'] . "</td>
                <td>" . $row['tglkrmSco'] . "</td>
                <td>" . $row['tglkrmCo'] . "</td>
                <td>" . $row['tgl_inv'] . "</td>
                <td>" . $row['term'] . "</td>
                <td>" . $row['jenis_transaksi'] . "</td>
                <td>" . $row['model'] . "</td>
                <td>" . $row['qty'] . "</td>
                <td>" . $row['hrg_sco'] . "</td>
                <td>" . $row['disk_sco'] . "</td>
                <td>" . $row['ppn_sco'] . "</td>
                <td>" . $row['amt_sco'] . "</td>
                <td>" . $row['hrgtot_sco'] . "</td>
                <td>" . $row['ket_sco'] . "</td>
                <td>" . $row['qty_kirim'] . "</td>
                <td>" . $row['hrg_co'] . "</td>
                <td>" . $row['disk_co'] . "</td>
                <td>" . $row['ppn_co'] . "</td>
                <td>" . $row['amt_co'] . "</td>
                <td>" . $row['hrgtot_co'] . "</td>
                <td>" . $row['ket_co'] . "</td>
                <td>" . $row['locator'] . "</td>
                <td>" . $row['sales'] . "</td>
                <td>" . $row['ongkir'] . "</td>
                <td>" . $row['ktr_sco'] . "</td>
                <td>" . $row['aproval_by'] . "</td>
                <td>" . $row['aproval_date'] . "</td>
                <td>" . $row['status_SCO'] . "</td>
				<td>" . $row['ar_feedback'] . "</td>
				<td>" . $row['issuedby'] . "</td>
                <td>" . $row['status_CO'] . "</td>
                <td>" . $row['fpp_id'] . "</td>
                <td>" . $row['revisi'] . "</td>
                <td>" . $row['updateby'] . "</td>
            </tr>";
		}
	} else {
		$html .='<tr>
		<td colspan="41">Data tidak ditemukan</td>
		</tr>';
	}
	$html .="</tbody></table>";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data FULL ".$awal." sampai ".$akhir.".xls");
echo $html;
?>