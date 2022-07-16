<?php
include "../includes/config.php";
$theme=$_SESSION['theme'];
setcookie('theme',$theme,time()+86400*365,'/');
if(isset($_SESSION)){
    $id=$_SESSION['user_id'];
    mysqli_query($conn, "UPDATE `login` SET `islogin`=0 WHERE `reg_id`='$id'");
    session_destroy();
}
header("location:../login.php");
?>