<?php
include "../includes/config.php";
$course=$_POST['course'];
$row = mysqli_query($conn, "SELECT `header`, `assigment`,`upload` FROM `$course` WHERE `isMeeting`='0'");
$html="";
while ($res = mysqli_fetch_array($row)) :
    if ($res['assigment'] != NULL) :           
        $html.= '<ul><li><b>'.$res['header'].'</b></li>'.
         '<a href="'.$res['assigment'].'" target="_blank">Assignment</a></br>'.
                '<a href="'.$res['upload'].'" target="_blank">Submission</a></br></ul>'; 
     endif;
endwhile;
echo $html;
?>