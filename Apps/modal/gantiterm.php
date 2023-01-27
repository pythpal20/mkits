<script>
$('#changetop').on("submit", function(event) {
    event.preventDefault();
    $.ajax({
        url: "modal/simpantermak.php",
        method: "POST",
        data: $('#changetop').serialize(),
        beforeSend: function() {
            $('#update').val("Updating");
        },
        success: function(data) {
            console.log(data);
            $('#changetop')[0].reset();
            $('#TopEdit').modal('hide');
            window.location.reload();
        }
    });
});
</script>

<?php 
if(isset($_POST["id"]))
// var_dump($_POST["id"]);
{
  $output = '';
  //$connect = mysqli_connect("localhost", "root", "", "input_karyawan");
  include '../../config/connection.php';

  $query = "SELECT * FROM customerorder_hdr WHERE No_Co = '".$_POST["id"]."'";
  $mwk = $db1->prepare($query);
  $mwk -> execute();
  $res1 = $mwk->get_result();
  $row = $res1->fetch_assoc();
  $output .= '
    <form method="post" id="changetop">
      <label>No_Co</label>
      <input type="hidden" name="id" id="id" value="'.$_POST["id"].'" class="form-control" />
      <input type="text" name="No_Co" id="No_Co" value="'.$row["No_Co"].'" class="form-control" disabled>
      <br />
      <label>Nama Customer</label>
      <input type="text" name="nama" id="nama" class="form-control" value="'.$row["customer_nama"].'" disabled>
      <br>
        <label>Term Of Payment</label>
        <select name="term" id="term" class="form-control" >
            <option value="' .$row["term"]. '">'. $row["term"] .'</option>
            <option value="Cash On Delivery">Cash On Delivery</option>
            <option value="Cash Before Delivery">Cash Before Delivery</option>
            <option value="TOP 7 Hari">TOP 7 Hari</option>
            <option value="TOP 14 Hari">TOP 14 Hari</option>
            <option value="TOP 30 Hari">TOP 30 Hari</option>';
        $output .= '</select>
        <br />
         <label>Method Payment</label>
        <select name="method" id="method" class="form-control" >
            <option value="' .$row["method"]. '">'. $row["method"] .'</option>
            <option value="Cash/Tunai">Cash/Tunai</option>
            <option value="Transfer">Transfer</option>
            <option value="Check">Check/Giro</option>';
        $output .= '</select>
        <br />
        <br />
        <input type="submit" name="update" id="update" value="Update" class="btn btn-success" />

    </form>
     ';
    echo $output;
}
?>