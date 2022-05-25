<?php
session_start();
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$locationID = $_POST['deletableLocationID'];

$sql = "DELETE FROM tblLocation WHERE ID = '$locationID'";
$result = mysqli_query($link, $sql);

if ($result) {
    echo "<div class='alert alert-success'>Location deleted successfully</alert>";
    exit();
} else {
    echo "<div class='alert alert-danger'>Cannot delete location</alert>";
    exit();
}

 

?>