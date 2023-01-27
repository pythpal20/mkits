<?php
include '../../config/connection.php';
$id = $_POST['idcust'];
// var_dump($_POST);
?>
<select id="statcust" name="statcust" class="form-control">
    <?php
		$query ="SELECT status FROM master_customer WHERE customer_id = '$id'";
		$mwk = $db1->prepare($query);
		$mwk -> execute();
		$resl = $mwk->get_result();
		while ($row = $resl->fetch_assoc()){
			if ($row['status'] !== NULL AND $row['status'] !== '') {
				echo '<option value="'.$row['status'].'" selected>'.strtoupper($row['status']).'</option>';
			} else {
				echo '<option value="">=Pilih=</option>';
			}
		} 
	?>
    <option value="old">OLD</option>
    <option value="new">NEW</option>
</select>