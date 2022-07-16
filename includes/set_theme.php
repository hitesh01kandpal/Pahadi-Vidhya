<?php
    include "../includes/config.php";
    $_SESSION['theme']= $_POST['checked'];
    echo $_SESSION['theme'];
?>