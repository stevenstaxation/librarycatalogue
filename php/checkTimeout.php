<?php
session_start();

if (isset($_SESSION['timeout']) ) {
    $session_life = (time()) - $_SESSION['timeout'];
    if($session_life > 0) {
        echo 0;
    } else {
        echo $session_life;
    }
}

?>