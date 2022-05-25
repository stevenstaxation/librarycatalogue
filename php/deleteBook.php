<?php
session_start();
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$bookID = $_POST['deletableBookID'];

$sql = "DELETE FROM tblBook WHERE ID = '$bookID'";
$result = mysqli_query($link, $sql);

if ($result) {
    echo "<div class='alert alert-success'>Book deleted successfully</alert>";
    exit();
} else {
    echo "<div class='alert alert-danger'>Cannot delete book</alert>";
    exit();
}

 

?>