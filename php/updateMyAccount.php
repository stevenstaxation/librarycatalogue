<?php
session_start();
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$userName = '';
$userEmail = '';
$userDarkMode = $_POST['userDarkMode'];

if ($userDarkMode=='true') {
    $userDarkMode = 1;
} else {
    $userDarkMode = 0;
};


$userDateFormat = $_POST['userDateFormat'];
$userID = $_SESSION['ID'];

// RULES
// username must be unique
// email address must be in valid format and not registered already
// dark mode is true or false
// date format is id from combo box list

if (!empty($_POST['userName'])) {
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

$userName = mysqli_real_escape_string($link, $userName);

$sql = "SELECT * FROM tblUser WHERE userName='$userName' AND ID<>'$userID'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if ($count !== 0) {
    echo "<div class='alert alert-danger'>That user name has already been taken</div>";
    exit();
}

if (empty($_POST['userEmail'])) {
    echo "<div class='alert alert-danger'>Email address cannot be empty</div>";
    exit();
} 
else 
{
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Email address is not valid</div>";
        exit();
    }
}

$sql = "SELECT * FROM tblUser WHERE email = '$userEmail' AND ID<>'$userID'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if ($count !== 0) {
    echo "<div class='alert alert-danger'>That email address has already been registered</div>";
    exit();
}

// all good so update database

$sql = "UPDATE tblUser SET userName = '$userName', email='$userEmail', darkmode=$userDarkMode, dateFormat='$userDateFormat' WHERE ID = '$userID'";

$result = mysqli_query($link, $sql);

echo "<div class='alert alert-success'>Account details updated successfully</div>";


?>