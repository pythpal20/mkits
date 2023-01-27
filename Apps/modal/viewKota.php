<?php 
	include '../../config/connection.php';
	//--------------------------------//
	$no=1;
	$id = $_POST['idprov'];
	// var_dump($id); die();
	$query ="SELECT wilayah_id,wilayah_nama,wilayah_code FROM master_wilayah WHERE LEFT(wilayah_id,2)='$id' AND CHAR_LENGTH(wilayah_id)=5";
	$mwk = $db1->prepare($query);
	$mwk -> execute();
	$reslt = $mwk->get_result();
?>
<table class="table table-striped tblData" data-page-size="10" id="tblData">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Kab./ Kota</th>
            <th>Kode</th>
        </tr>
    </thead>
    <tbody>
        <?php
		
		while ($row=$reslt->fetch_assoc()) {
		$id = $row['wilayah_id'];
		$nama = $row['wilayah_nama'];
		$code = $row['wilayah_code'];
		?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $id; ?></td>
            <td><?php echo $nama; ?></td>
            <td><?php echo $code; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <ul class="pagination float-right"></ul>
            </td>
        </tr>
    </tfoot>
</table>