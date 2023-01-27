<?php
    session_start();
    unset($_SESSION['idu']);
    unset($_SESSION['usernameu']);
    session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="../../img/system/apple-icon.png">
    <link rel="icon" type="image/png" href="../../img/system/favicon.png">
    <title>MKITS | 403 FORBIDDEN</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="">
        <div class="middle-box text-center animated fadeInDown">
            <h1>403</h1>
            <h3 class="font-bold">Halaman Tidak ditemukan!</h3>

            <div class="error-desc">
                <p>Maaf, anda tidak punya akses atau halaman yang anda cari tidak ada. Mohon login terlebih dahulu
                    dengan klik Tombol Login dibawah ini.</p>
                <a href="../../index.php" class="btn btn-danger btn-lg"><i class="fa fa-sign-in"></i> Login</a>
            </div>
        </div>
        <?php include '../template/footer.php'; ?>
    </div>
    <!-- Mainly scripts -->
    <script src="../../assets/js/jquery-3.1.1.min.js"></script>
    <script src="../../assets/js/popper.min.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
</body>

</html>