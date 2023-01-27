<?php
 
include '../../config/connection.php';
if(!empty($_POST))
{
 $output = '';
    $id = $_POST["id"];
    $term = $_POST["term"];
    $method = $_POST['method'];
    $query = "
    UPDATE master_customer SET term = '$term', method = '$method' WHERE customer_id = '$_POST[id]' ";
    
    if(mysqli_query($connect, $query)) 
    {
        $output .= '<script>alert("Update Data Berhasil");</script>';
    } else{
        $output .= mysqli_error($connect);
    }
    echo $output;
}
?>