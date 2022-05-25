<?php
session_start();
include ('connect.php');
include ('updateBookList.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$bookID = $_POST['bookID'];


$sql = "
SELECT * FROM 
(SELECT b.ID, b.title, b.ISBN, b.pages, b.year, b.originalCost, b.description, b.cover, b.copies, b.LocationID, 
GROUP_CONCAT(DISTINCT a.knownAs) as Authors, GROUP_CONCAT(DISTINCT a.ID) as author_ID,
GROUP_CONCAT(DISTINCT p.Name) as Publishers, GROUP_CONCAT(DISTINCT p.ID) as Publisher_ID,
GROUP_CONCAT(DISTINCT t.Name) as Tags, GROUP_CONCAT(DISTINCT t.ID) as tag_ID
                    
FROM tblBook b 
LEFT JOIN tblAuthor_Book ab ON  b.ID = ab.bookID
LEFT JOIN tblAuthor a ON ab.authorID = a.ID
LEFT JOIN tblPublisher_Book pb ON b.ID=pb.bookID
LEFT JOIN tblPublisher p ON pb.publisherID = p.ID
LEFT JOIN tblTag_Book tb ON b.ID=tb.bookID
LEFT JOIN tblTag t ON tb.tagID = t.ID

GROUP BY b.ID) AS bookList WHERE bookList.ID = '$bookID'";

$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

echo json_encode($row);




?>

