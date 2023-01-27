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
//MENYIMPAN DATA KE DATABASE DENGAN AJAX
    $('#FeedBackForm').on("submit", function(event) {
        var sales = $('#sales').val();
        var noco = $('#noco').val();
        var textFeedback = $('#textFeedback').val();
        console.log(textFeedback);
        event.preventDefault();
        $.ajax({
            url: "modal/approval_po.php",
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
                var chat_id = ["-1001704848872", "-1001762497140"];
                var text = "CANCEL CO " + noco + 
                           "|\nFEEDBACK : " + textFeedback +
                           "\nCancel By : <?php echo $data['user_nama'];?>  " + 
                           "\nCO By sales : " + sales;
                for (let index = 0; index < chat_id.length; index++) {
                    const element = chat_id[index];
                    $.ajax({
                        url: url,
                        method: "get",
                        data: {
                            chat_id: element,
                            text: text
                        }
                    });
                }
                setTimeout(function() {
                    location.reload();
                }, 3000);
                swal.fire(
                    'Sukses',
                    'CO berhasil dicancel',
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
        
            $query = "SELECT * FROM  customerorder_hdr WHERE No_Co = '$id'";
            $mwk = $db1->prepare($query);
            $mwk -> execute();
            $hasil = $mwk->get_result();
            $row = $hasil->fetch_assoc();
        
            $output .= '<form id="FeedBackForm" method="post">
            <input type="hidden" value="'.$row["sales"].'" name="sales" id="sales">
            <input type="hidden" value="'. $_POST['id'] .'" name="id" id="noco">
            <div class="form-group">
            <label>Alasan !</label>
            <textarea class="form-control" name="feedback"  id="textFeedback"></textarea>
            <br>';
            $output .= '<input type="submit" name="update" id="update" value="Cancel CO" class="btn btn-danger" />
            </form>';
            echo $output;
            // var_dump($_POST);
        }
    ?>