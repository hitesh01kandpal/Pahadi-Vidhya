<?php
$hostname='localhost';
$username='root';
$password='';
$database_name='moodle';
$conn=mysqli_connect($hostname,$username,$password,$database_name)
or die(mysqli_error($con));
if(!isset($_SESSION)){
    session_start();
}
?>