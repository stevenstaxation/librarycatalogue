<?php
session_start();
include ('connect.php');

$_SESSION['timeout'] = time()+(15*60); // reset timeout

$locationID = $_POST['locationID'];

$sql = "SELECT COUNT(*) FROM tblBook WHERE locationID='" . $locationID ."'";
$countResult = mysqli_query($link, $sql);
$count = mysqli_fetch_array($countResult);


$sql = "SELECT * FROM tblLocation WHERE ID='$locationID'";


$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

echo $count[0] . "~" . $row['Description'];
?>

