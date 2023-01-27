<?php
session_start();
unset($_SESSION['idu']);
unset($_SESSION['usernameu']);
session_destroy();
echo "<script>window.location.replace('../index.php');</script>"
?>