<?php
session_start();
include ('connect.php');
include ('updateBookList.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$ISBN = $_POST['ISBN'];
$title = mysqli_real_escape_string($link, $_POST['title']);
$description = mysqli_real_escape_string($link, $_POST['description']);
$authors = mysqli_real_escape_string($link, $_POST['authors']);
$publisher = mysqli_real_escape_string($link,  $_POST['publisher']);
$year = $_POST['year'];
$pages = $_POST['pages'];
$location = $_POST['location'];
$tags = mysqli_real_escape_string($link, $_POST['tags']);
$copies = $_POST['copies'];
$cost = $_POST['cost'];
$cover = $_POST['cover'];

// whether the ISBN already exists was checked before we got here

// split authors and check if they already exist in database
if (isset($authors) && $authors!='') {
    $allAuthors = explode(",", $authors);
    $authorID = [];

    foreach($allAuthors as $thisAuthor) {
        $sql = "SELECT * FROM tblAuthor WHERE knownAs = '$thisAuthor' LIMIT 1";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result)==0) {
            // author doesn't exist so add it to database tblAuthor
            $authorAtoms = explode(" ", trim($thisAuthor));
            $thisAuthor = trim($thisAuthor);
            $firstName = reset($authorAtoms);
            $lastName = end($authorAtoms);
            $middleNames = str_replace($firstName,"", $thisAuthor);
            $middleNames = str_replace($lastName,"", $middleNames);
            $middleNames = trim($middleNames);
              
            $sql = "INSERT INTO tblAuthor (firstName, middleName, lastName, knownAs) VALUES ('$firstName','$middleNames','$lastName','$thisAuthor')";
            $result = mysqli_query($link, $sql);
            array_push($authorID, mysqli_insert_id($link));
        } else {
            // author exists so add their ID to $authorID array
            $row = mysqli_fetch_array($result);
            array_push($authorID, $row['ID']);
        }
    }
} else {
    $authorID = NULL;
}

// split tags and check if they already exist in database
if (isset($tags) && $tags!='') {
    $allTags = explode(",", $tags);
    $tagID = [];

    foreach($allTags as $thisTag) {
        $sql = "SELECT * FROM tblTag WHERE Name = '$thisTag' LIMIT 1";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result)==0) {
            // tag doesn't exist so add it to database tblAuthor
            $sql = "INSERT INTO tblTag (Name) VALUES ('$thisTag')";
            $result = mysqli_query($link, $sql);
            array_push($tagID, mysqli_insert_id($link));
        } else {
            // tag exists so add its ID to $tagID array
            $row = mysqli_fetch_array($result);
            array_push($tagID, $row['ID']);
        }
    }
} else {
    $tagID = [];
}

// check if publisher already exists in database
if (isset($publisher) && $publisher!='') {
    $sql = "SELECT * FROM tblPublisher WHERE Name ='$publisher'"; 
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)==0) {
        // publisher doesn't already exist, so add publisher to tblPublisher
        // then make a note of newPublisherID
        $sql = "INSERT INTO tblPublisher (Name) VALUES ('$publisher')";
        $result = mysqli_query($link, $sql);
        $newPublisherID = mysqli_insert_id($link);
    } else {
        // exact publisher already exists, so store its ID
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $newPublisherID = $row['ID'];
    }
} else {
    $newPublisherID = NULL;
}

// ready to add the book to the database now
$sql = "INSERT INTO tblBook (title, ISBN, locationID, pages, year, originalCost, copies, description, cover) 
VALUES ('$title', '$ISBN', '$location', NULLIF('$pages',''), NULLIF('$year',''), NULLIF('$cost',''),NULLIF('$copies',''),NULLIF('$description',''),NULLIF('$cover',''))";
$result = mysqli_query($link, $sql);
$newBookID = mysqli_insert_id($link);
if (!$result) {
    echo "<div class='alert alert-danger'>Error adding book to database</alert>";
    exit();
}

// add Author Link(s)
foreach ($authorID as $thisAuthorID) {
    $sql = "INSERT INTO tblAuthor_Book (bookID, authorID) VALUES ('$newBookID', NULLIF('$thisAuthorID',''))";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-danger'>Error adding author link</alert>";
        exit();
    }
}

// add Tag Link
foreach ($tagID as $thisTagID) {
    $sql = "INSERT INTO tblTag_Book (tagID, bookID) VALUES (NULLIF('$thisTagID',''), '$newBookID')";
    $result2 = mysqli_query($link, $sql);
    if (!$result2) {
        echo "<div class='alert alert-danger'>Error adding tag link</alert>";
        exit();
    }
}

// add Publisher Link
$sql = "INSERT INTO tblPublisher_Book (publisherID, bookID) VALUES (NULLIF('$newPublisherID',''), '$newBookID')";
$result3 = mysqli_query($link, $sql);
if (!$result3) {
    echo "<div class='alert alert-danger'>Error adding publisher link</alert>";
    exit();
}

include ("updateBookList_nonfunc.php");

// echo 'success';

?>