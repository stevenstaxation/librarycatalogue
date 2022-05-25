<?php
session_start();
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$locationID = $_POST['editableLocationID'];
$location = $_POST['editedLocation'];


if ($location==NULL || empty($location)) {
    echo "<div class='alert alert-danger'>Location cannot be empty or blank</alert>";
    exit();
}

$sql = "SELECT * FROM tblLocation WHERE Description='$location' AND ID<>'$locationID'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {
    echo "<div class='alert alert-danger'>That location already exists</alert>";
    exit();
}


$location = mysqli_real_escape_string($link, $location);

$sql = "UPDATE tblLocation SET Description='$location' WHERE ID = '$locationID'";
$result = mysqli_query($link, $sql);

if ($result) {
    echo "<div class='alert alert-success'>Location updated successfully</alert>";
    exit();
} else {
    echo "<div class='alert alert-danger'>Cannot update location</alert>";
    exit();
}

 

?>