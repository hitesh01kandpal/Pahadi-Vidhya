<?php
include "../includes/config.php";
$uid=$_SESSION['user_id'];
$time=time();
 $row1=mysqli_query($conn,"select student.name ,login.reg_id from student inner JOIN login on login.reg_id=student.id  where login.islogin > $time");
 $row2=mysqli_query($conn,"select teacher.name ,login.reg_id from teacher inner JOIN login on login.reg_id=teacher.id  where login.islogin > $time");
 $row3=mysqli_query($conn,"select admin.name ,login.reg_id from admin inner JOIN login on login.reg_id=admin.id  where login.islogin > $time");
$html ="";
$color="blue";
while($res = mysqli_fetch_array($row1)){
    if($res['reg_id'] == $uid){
      $color="green";
    }
    else{
      $color="blue";
    }
    $html.= '<div><b><svg height="30" width="100%">
    <circle cx="10" cy="10" r="5"  fill="green" />
    <text x="30" y="15" fill="'.$color.'">'.$res['name'].'</text>
    </svg>
    </b></div>';
  }
   while($res = mysqli_fetch_array($row2)){
    if($res['reg_id'] == $uid){
      $color="green";
    }
    else{
      $color="blue";
    }
     $html.= '<div><b><svg height="30" width="100%">
     <circle cx="10" cy="10" r="5"  fill="green" />
     <text x="30" y="15" fill="'.$color.'">'.$res['name'].'</text>
    </svg>
    </b></div>';
 }
 while($res = mysqli_fetch_array($row3)){
  if($res['reg_id'] == $uid){
    $color="green";
  }
  else{
    $color="blue";
  }
   $html.= '<div><b><svg height="30" width="100%">
   <circle cx="10" cy="10" r="5"  fill="green" />
   <text x="30" y="15" fill="'.$color.'">'.$res['name'].'</text>
 </svg></b></div>';
}
echo $html;

?>
