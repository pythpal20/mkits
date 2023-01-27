<?php 
	error_reporting();
#1.
	//query untuk menampilkan data total penjualan perbulan dalam 1 tahun
	$lnFlot = "SELECT MONTH(tgl_po) AS bulan, COUNT(noso) AS totalPo FROM salesorder_hdr
	WHERE YEAR(tgl_po) = YEAR(CURRENT_DATE())
	GROUP BY MONTH(tgl_po)";
	$mwk = $db1->prepare($lnFlot);
	$mwk->execute();
	$flotLn = $mwk->get_result();
#2.
	//query untuk menampilkan 5 kota dengan po terbanyak dalam satu Tahun
// 	$city = "SELECT mw.wilayah_nama, COUNT(sh.noso) AS jumlahPo FROM salesorder_hdr sh
// 	LEFT JOIN master_customer mc ON sh.customer_id = mc.customer_id
// 	LEFT JOIN master_wilayah mw ON mc.customer_provinsi = mw.wilayah_id
// 	WHERE (sh.jenis_transaksi !='MARKETPLACE' AND sh.jenis_transaksi !='SHOWROOM' AND sh.jenis_transaksi != 'INTERNAL' AND sh.jenis_transaksi != 'ONLINESTORE') AND sh.status !='2' AND YEAR(sh.tgl_po) = YEAR(CURRENT_DATE())
// 	GROUP BY mw.wilayah_nama ORDER BY jumlahPo DESC
// 	LIMIT 10";
// 	$city = "SELECT mw.wilayah_nama, SUM(ac.harga_total) AS jumlahPo FROM salesorder_hdr sh
// 	LEFT JOIN master_customer mc ON sh.customer_id = mc.customer_id
// 	LEFT JOIN master_wilayah mw ON mc.customer_provinsi = mw.wilayah_id
//     JOIN salesorder_dtl ac ON sh.noso = ac.noso
// 	WHERE (sh.jenis_transaksi !='MARKETPLACE' AND sh.jenis_transaksi !='SHOWROOM' AND sh.jenis_transaksi != 'INTERNAL' AND sh.jenis_transaksi != 'ONLINESTORE') AND sh.status !='2' AND YEAR(sh.tgl_po) = YEAR(CURRENT_DATE())
// 	GROUP BY mw.wilayah_nama ORDER BY jumlahPo DESC
// 	LIMIT 10";
	
	$city = "SELECT SUM(b.harga_total) AS jumlahPo, d.wilayah_nama
FROM customerorder_hdr_delivery a 
JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
JOIN master_customer c ON a.customer_id = c.customer_id
JOIN master_wilayah d ON c.customer_kota = d.wilayah_id
WHERE YEAR(a.tgl_delivery) = YEAR(CURRENT_DATE())
GROUP BY c.customer_kota  
ORDER BY `jumlahPo`  DESC
LIMIT 10";
	$mwk = $db1->prepare($city);
	$mwk->execute();
	$hcity = $mwk->get_result();
	
#3. 
	// query menampilkan grafik 
// 	$Qkategori = "SELECT b.customer_kategori, COUNT(a.customer_id) as Jumlah FROM customerorder_hdr_delivery a 
// 	JOIN master_customer b ON a.customer_id = b.customer_id
// 	WHERE MONTH(a.tgl_delivery) between '01' AND '12'
// 	AND YEAR(a.tgl_delivery) = YEAR(CURRENT_DATE())
// 	GROUP BY b.customer_kategori  
// 	ORDER BY `Jumlah`  DESC
// 	LIMIT 10";
    $Qkategori = "SELECT b.customer_kategori, SUM(c.harga_total) as Jumlah FROM customerorder_hdr_delivery a 
	JOIN master_customer b ON a.customer_id = b.customer_id
    JOIN customerorder_dtl_delivery c ON a.No_Co = c.No_Co
	WHERE MONTH(a.tgl_delivery) between '01' AND '12'
	AND YEAR(a.tgl_delivery) = YEAR(CURRENT_DATE())
	GROUP BY b.customer_kategori  
	ORDER BY `Jumlah`  DESC
	LIMIT 10";
	$pcs = $db1->prepare($Qkategori);
	$pcs->execute();
	$rkategory = $pcs->get_result();
?>