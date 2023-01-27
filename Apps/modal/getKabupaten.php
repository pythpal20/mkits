<?php
	include '../../config/connection.php';
 
	$data = $_POST['data'];
	$id = $_POST['id'];
 	var_dump($id);
	$n=strlen($id);
	$m=($n==2?5:($n==5?8:13));
	// $wil=($n==2?'Kota/Kab':($n==5?'Kecamatan':'Desa/Kelurahan'));
?>
<?php 
	if($data == "kabupaten"){
?>
<select id="kab" class="form-control" name="kab" required>
    <option value="">Pilih Kabupaten/Kota</option>
    <?php 
		$kabupaten = "SELECT wilayah_id,wilayah_nama FROM master_wilayah WHERE LEFT(wilayah_id,'$n')='$id' AND CHAR_LENGTH(wilayah_id)=$m ORDER BY wilayah_nama";
		$mwk=$db1->prepare($kabupaten);
		$mwk->execute();
		$resl=$mwk->get_result();
		while ($kb=$resl->fetch_assoc()){
			echo '<option value="'.$kb['wilayah_id'].'">'.$kb['wilayah_nama'].'</option>';
		}
	?>
</select>
<?php
} else if($data == 'kecamatan') { ?>
<select name="kec" id="kec" class="form-control" required>
    <option value="">Pilih Kecamatan</option>
    <?php
			$kecamatan = "SELECT wilayah_id,wilayah_nama FROM master_wilayah WHERE LEFT(wilayah_id,'$n')='$id' AND CHAR_LENGTH(wilayah_id)=$m ORDER BY wilayah_nama";
			$mwk = $db1->prepare($kecamatan);
			$mwk -> execute();
			$reslc = $mwk->get_result();
			while($kc=$reslc->fetch_assoc()){
				echo '<option value="'.$kc['wilayah_id'].'">'.$kc['wilayah_nama'].'</option>';
			}
		?>
</select>
<?php }?>
<!-- 
MKITS By Paulus Christofel S
PT. Multi Wahana Kencana
IT Programmer Tim
paulus.mwk@gmail.com | christofelpaulus@gmail.com
Agustus 2021 

update database wilayah from rajaongkir(dot)com
-->