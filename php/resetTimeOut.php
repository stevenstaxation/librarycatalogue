<?php
   session_start(); 
   $_SESSION['timeout'] = time()+(15*60); // timeout after 15 minutes of inactivity
?>
