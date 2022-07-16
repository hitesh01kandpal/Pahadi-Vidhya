<?php
$key=mysqli_query($conn,"SELECT `email`,`api_key`, `api_secret` FROM `teacher` WHERE `id`='$user_id'");
$key=mysqli_fetch_array($key);
define('API_KEY',$key['api_key']);
define('API_SECRET',$key['api_secret']);
define('EMAIL_ID',$key['email']);
?>