<?php
    include '../../config/connection.php';
    session_start();
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'";
    $mwk = $db1->prepare($query);
    $mwk->execute();
    $reslt = $mwk->get_result();
    $data = $reslt->fetch_assoc();
?>
<script>
$('#FeedBackForm').on("submit", function(event) {
    var sales = $('#sales').val();
    var nopo = $('#nopo').val();
    var textFeedback = $('#textFeedback').val();

    event.preventDefault();
    $.ajax({
        url: "modal/approval_ar.php",
        method: "POST",
        data: $('#FeedBackForm').serialize(),
        beforeSend: function() {
            $('#update').val("Updating");
        },
        success: function(data) {
            $('#FeedBackForm')[0].reset();
            $('#EditModal').modal('hide');

            var url =
                'https://api.telegram.org/bot2128412393:AAE0RnWM0uKbjf4FjEdr6xW4NBXAp2MlqoI/sendMessage';
            var chat_id = "-759758736";
            var text = "PENDING PO <i>" + nopo + "</i>\n" + "Karena : <i><b>" + textFeedback + "</b></i>\n" +
                "Pending By : <?= $data['user_nama'] ?> | PO By sales : " + sales;
            $.ajax({
                url: url,
                method: "get",
                data: {
                    chat_id: chat_id,
                    parse_mode: 'html',
                    text: text
                }
            });

            setTimeout(function() {
                location.assign("cek_ar.php");
            }, 3600);
            swal.fire(
                'Sukses',
                'PO berhasil dipending',
                'success'
            );
        }
    });
});
</script>
<?php
$output = '';
include '../../config/connection.php';

if(isset($_POST['id']))
{
    $id = $_POST['id'];
    $sts = $_POST['sts'];

    $query = "SELECT * FROM  salesorder_hdr WHERE noso = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $hasil = $mwk->get_result();
    $row = $hasil->fetch_assoc();

    $output .= '<form id="FeedBackForm" method="post">
    <input type="hidden" value="'.$row["sales"].'" name="sales" id="sales">
    <input type="hidden" value="'. $_POST['sts'] .'" name="sts" id="status">
    <input type="hidden" value="'. $_POST['id'] .'" name="id" id="nopo">
    <div class="form-group">
    <label>Give Feedback for sales & marketing tim</label>
    <textarea class="form-control" name="feedback"  id="textFeedback"></textarea>
    <br>';
    $output .= '<input type="submit" name="update" id="update" value="Pending PO" class="btn btn-warning" />
    </form>';
    echo $output;
}

?>