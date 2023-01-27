<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="../system/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../img/system/favicon.png">
    <title>Mr. Kitchen</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/animate.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <style>
    .nyala:hover {
        background: #ff0000;
        box-shadow: 0 0 5px #ff0000, 0 0 25px #ff0000, 0 0 50px #ff0000, 0 0 200px #ff0000;
    }

    button {
        position: relative;
        border: none;
        transition: .4s ease-in;
        z-index: 1;
    }

    button::before,
    button::after {
        position: absolute;
        content: "";
        z-index: -1;
    }
    </style>
    <div class="container-fluid">
        <div class="middle-box  animated fadeInDown">
            <!-- <div class="row"> -->
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <center>
                            <img style="width:100%; display: block; margin-left: auto; margin-right: auto;"
                                src="../img/system/mkc.png">
                        </center>
                    </div>
                    <div class="ibox-content">
                        <form class="m-t" role="form" action="login_proses.php" method="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Password" required="">
                                    <div class="input-group-append">
                                        <span id="mybutton" onclick="change()" class="input-group-text">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" style="background-color:#ff0000;color:white"
                                class="btn block full-width m-b nyala">Login</button>
                        </form>
                    </div>
                    <div class="ibox-footer">
                        <h5 class="text-center">MKITS - Mr Kitchen Integrated System</h5>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright fill-right">
                &copy;
                2021, PT. Multi Wahana Kencana. <i class="fa fa-copyright"> copyright</i> by
                <a href="https://bit.ly/Akudansemua" target="_blank">IT</a> Team.
            </div>
        </div>
    </footer>
    <script src="../assets/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script>
    function change() {
        var x = document.getElementById('password').type;
        if (x == 'password') {
            document.getElementById('password').type = 'text';
            document.getElementById('mybutton').innerHTML = `<i class="fa fa-eye-slash"></i>`;
        } else {
            document.getElementById('password').type = 'password';
            document.getElementById('mybutton').innerHTML = `<i class="fa fa-eye"></i>`;
        }
    }
    </script>
</body>

</html>