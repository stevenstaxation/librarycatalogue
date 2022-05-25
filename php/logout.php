<?php
session_start();
include('connect.php');

$sql = "INSERT INTO tblEventLog (timestamp, Description, userID) VALUES (NOW(), 'User Logged out' ,'" . $_SESSION['userName'] ."')";
$result=mysqli_query($link, $sql);

unset($_SESSION['userName']);
unset($_SESSION['email']);
unset($_SESSION['ID']);
unset($_SESSION['timeout']);
unset($_SESSION['darkMode']);

header("Location: ../index.php");

?>

