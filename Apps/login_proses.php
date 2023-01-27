<?php 
    // include 'route/config.php'
    session_start();
    $conn = mysqli_connect('localhost', 'horek940_salsys', 'Garuda752021', 'horek940_salsys');
    
    $username 	= mysqli_real_escape_string($conn,$_POST['username']);
    $password 	= mysqli_real_escape_string($conn,md5($_POST['password']));

    $result = mysqli_query($conn, "SELECT * FROM master_user WHERE username='$username' AND password='$password' AND status='1'");

    $check = mysqli_num_rows($result);
    if($check > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['idu'] = $data['user_id'];
        $_SESSION['usernameu'] = $data['username'];
        $_SESSION['moduls'] = $data['modul'];
        if($_SESSION['moduls'] == '6' ){
            header('Location: viewguestsetoran.php'); 
        }elseif($_SESSION['moduls'] != '6'){
            header('Location: dashboard.php');
        }
       
    } else {
    header('Location: ../index.php?error=' .base64_encode('Username atau Password anda salah !'));
    }
?>