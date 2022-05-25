<?php
session_start();
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$newLocation = mysqli_real_escape_string($link, $_POST['newLocation']);

// check Location doesn't already exist
$sql = "SELECT * FROM tblLocation WHERE Description = '$newLocation'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {
    echo "<div class='alert alert-danger'>That location already exists</alert>";
    exit();
}

$sql = "INSERT INTO tblLocation (Description) VALUES ('$newLocation')";
$result = mysqli_query($link, $sql);

if ($result) {
    echo "<div class='alert alert-success'>Location added successfully</div>";
} else {
    echo "<div class='alert alert-danger'>Could not add location</div>";
}    

?>