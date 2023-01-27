<?php
    //AMBIL DATA USER YANG MEMPROSES dari SESSION
    include '../../config/connection.php';
    session_start();
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $reslt = $mwk->get_result();
    $data = $reslt->fetch_assoc();

    date_default_timezone_set('Asia/Jakarta');
    $updatetime = date('Y-m-d H:i:s');
?>
<script>
//MENYIMPAN DATA KE DATABASE DENGAN AJAX
$('#FeedBackForm').on("submit", function(event) {
    var sales = $('#sales').val();
    var nopo = $('#nopo').val();
    var textFeedback = $('#textFeedback').val();

    event.preventDefault();
    $.ajax({
        url: "modal/approval_sco.php",
        method: "POST",
        data: $('#FeedBackForm').serialize(),
        beforeSend: function() {
            $('#update').val("Updating");
        },
        success: function(data) {
            $('#FeedBackForm')[0].reset();
            $('#EditModal').modal('hide');
            //MEMBERIKAN NOTIFIKASI LEWAT BOT TELEGRAM
            var url =
                'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
            var chat_id = "-759758736";
            var text = "CANCEL SCO " + nopo + 
                       "|\nFEEDBACK : " + textFeedback +
                       "\nCancel By : <?php echo $data['user_nama'];?>  " + 
                       "\nSCO By sales : " + sales;
            setTimeout(function() {
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        chat_id: chat_id,
                        text: text
                    }
                });
            }, 3000);

            setTimeout(function() {
                location.reload();
            }, 3600);
            swal.fire(
                'Sukses',
                'SCO berhasil dicancel',
                'success'
            );
        }
    });
});
</script>

<?php //MENAMPILKAN FORM UNTUK FEEDBACK
$output = '';
include '../../config/connection.php';  

if(isset($_POST['id']))
{
    $id = $_POST['id'];

    $query = "SELECT * FROM  salesorder_hdr WHERE noso = '$id'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $hasil = $mwk->get_result();
    $row = $hasil->fetch_assoc();

    $output .= '<form id="FeedBackForm" method="post">
    <input type="hidden" value="'.$row["sales"].'" name="sales" id="sales">
    <input type="hidden" value="'. $_POST['id'] .'" name="id" id="nopo">
    <div class="form-group">
    <label>Alasan !</label>
    <textarea class="form-control" name="feedback"  id="textFeedback"></textarea>
    <br>';
    $output .= '<input type="submit" name="update" id="update" value="Cancel SCO" class="btn btn-danger" />
    </form>';
    echo $output;
    // var_dump($_POST);
}

?>