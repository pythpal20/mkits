<?php
include '../../config/connection.php';
if (!isset($_POST['searchNama'])) {
    $fetchData = mysqli_query($connect, "SELECT user_nama, company FROM master_user WHERE LEVEL = 'admin' AND modul = '1' AND `status` = '1' 
    AND user_nama ='Vega' OR user_nama='Antonius' OR user_nama='CHRISTINE'");
} else {
    $search = $_POST['searchNama'];
    $fetchData = mysqli_query($connect, "SELECT user_nama, company FROM master_user WHERE LEVEL = 'admin' AND modul = '1' AND `status` = '1' 
    AND user_nama ='Vega' OR user_nama='Antonius' OR user_nama='CHRISTINE' AND user_nama LIKE '%" . $search . "%'");
}

$data = array();
while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['user_nama'], "text" => $row['user_nama'] . ' | ' . $row['company']);
}
//tampil data
print_r(json_encode($data));
?>