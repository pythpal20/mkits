<?php 
include '../../config/connection.php';
function add_leading_zero($value, $threshold = 4) {
    return sprintf('K-'.'%0'. $threshold . 's', $value);
}

$ambil_nokeep ="SELECT no_keepstock FROM keepstock WHERE status_keep != '2'" ;
$hasil_nokeep = mysqli_query($connect, $ambil_nokeep);
$html=[];
while ($row = mysqli_fetch_array($hasil_nokeep)) {
    array_push($html, add_leading_zero($row['no_keepstock']));
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($html) ;
?>