<?php
session_start();
include ('connect.php');

$_SESSION['timeout'] = time()+(15*60); // reset timeout



$sql = "SELECT * FROM tblLocation";


$result = mysqli_query($link, $sql);

?>

<h3 style='margin: 25px 15px'><strong>Upload Bulk List</strong></h3>
<button id='uploadButton' class='btn btn-success btn-sm' style='margin:15px;'>Select File to Upload</button>
<h6 style ='margin-left: 15px'>Upload a CSV file with two columns.  First column contains ISBN number and the second column should contain the location ID where location ID is:

<div style='margin-left:20px'><br>
<strong>ID&nbsp;&nbsp;&nbsp;&nbsp;Location</strong><br>

<?php
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo str_repeat('&nbsp', 2 - strlen($row['ID']));
    echo $row['ID'];
    echo str_repeat('&nbsp', 5 - strlen($row['ID']));
    echo $row['Description'] . "<br>";
};

?>


<br><hr><br>
<i>Example content</i><br>
9781786090065, 3<br>
9781473659254, 5<br>
9781847925237, 6
</h6>
</div>
