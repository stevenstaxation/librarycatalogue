<?php
session_start();
include('connect.php');

$userName = '';
$password='';
$remember = 0; // Do not remember

// check username entered
if (!empty($_POST['uname'])) {
    $userName = filter_var($_POST['uname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// check password entered
if (!empty($_POST['password']) || $_POST['password']=='') {
    $password = filter_var($_POST['password'],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} 

if (!empty($_POST['remember'])) {
    $remember = 1; // Remember me
}

$userName = mysqli_real_escape_string($link, $userName);
$password = mysqli_real_escape_string($link, $password);

$sql = "SELECT * FROM tblUser WHERE (userName='$userName')";

$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if ($count !== 1) {
    echo "<div class='alert alert-danger'>Incorrect username or password</div>";
    exit();
}

$row=mysqli_fetch_array($result, MYSQLI_ASSOC);

if (!password_verify($password, $row['password'])) {
    echo "<div class='alert alert-danger'>Incorrect username or password</div>";
    exit();
}


if ($row['activation']!=='activated') {
    echo "<div class='alert alert-danger'>You have not yet activated your account.<br>Check your inbov for a link to activate before trying to sign in.</div>";
    exit();
}

// all good so set some session variables
$_SESSION['ID'] = $row['ID'];
$_SESSION['userName'] = $row['userName'];
$_SESSION['email'] = $row['email'];
$_SESSION['darkMode'] = $row['darkmode'];
$_SESSION['timeout'] = time()+(15*60);

$timestamp = date('Y-m-d H:i:s');


//add an entry in the event log
$sql = "INSERT INTO tblEventLog (timestamp, description, userID) VALUES(NOW(), 'User signed in successfully','" . $row['userName'] ."')";

$result = mysqli_query($link, $sql);

echo "success/" . $_SESSION['darkMode'];
?>
