<?php
include "../includes/config.php";
$course=$_POST['course'].'p';
$no=$_POST['no'];
$checked=$_POST['checked'];
$head=$_POST['hd'];
if($checked){
    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d H:i:s'); 
}else{
    $date=date("0000-00-00 00:00:00");
}
mysqli_query($conn,"UPDATE `$course` SET `$no`='$date' WHERE `header`='$head'");
?>