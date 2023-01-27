<?php

// var_dump($term);die();
if(!empty($_POST))
{
    // var_dump($_POST); die();
 $output = '';
 include '../../config/connection.php';
    $id = $_POST["id"];
    $term = $_POST["term"];
    $method = $_POST["method"];

    $query = "UPDATE customerorder_hdr SET term='$term', method='$method' WHERE No_Co = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
}
?>