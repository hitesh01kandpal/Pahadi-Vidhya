<?php
include "../includes/config.php";
$uid=$_SESSION['user_id'];
$time=time()+10;
mysqli_query($conn,"UPDATE `login` SET `islogin`='$time' WHERE `reg_id`='$uid'");
?>