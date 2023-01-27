<?php
include '../../config/connection.php';
// var_dump($_POST);

if(!isset($_POST['searchTerm'])){ 
  $fetchData = mysqli_query($connect,"SELECT * FROM temp_customer ORDER BY ID DESC LIMIT 15");
}else{ 
  $search = $_POST['searchTerm'];   
  $fetchData = mysqli_query($connect,"SELECT * FROM temp_customer WHERE customer_nama LIKE '%".$search."%' LIMIT 15");
} 

$data = array();
while ($row = mysqli_fetch_array($fetchData)) {    
  $data[] = array("id"=>$row['ID'], "text"=>$row['customer_nama']);
}
//tampil data
echo json_encode($data);
?>