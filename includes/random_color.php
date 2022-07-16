<?php
function randomHex() {
   $chars = 'ABCDEF0123456789';
   $color = '#';
   for ( $i = 0; $i < 6; $i++ ) {
      $color .= $chars[rand(0, strlen($chars) - 1)];
   }
   return $color;
}
?>