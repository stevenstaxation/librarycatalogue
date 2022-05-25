<?php
session_start();
include ('connect.php');
include ('updateBookList.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$bookID = $_POST['editableBookID'];
$ISBN =  mysqli_real_escape_string($link, $_POST['ISBN']);
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

$errors = '';
// ISBN must be 10 or 13 digits 
// Do NOT do an ISBN lookup for validity
// Check if ISBN is already in library elsewhere, if it is suggest increasing number of copies
$sql = "SELECT * FROM tblBook WHERE ISBN='$ISBN' AND ID<>'$bookID'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=0) {
    $errors .= "<li>That ISBN is already in the library.  You should increase the number of copies of that book instead of adding a new book.</li>";
}

if (strlen($ISBN)!=10 && strlen($ISBN)!=13) {
    $errors .= "<li>ISBN should be 10 or 13 characters in length.</li";
}

if ($title==NULL || $title=='') {
    $errors .= "<li>Book title is missing.</li>";
}

if ($errors) {
    echo "<div class='alert alert-danger'><ul>" . $errors . "</ul></div>";
    exit();
}


// split authors and check if they already exist in database
if (isset($authors) && $authors!='') {
    $allAuthors = explode(",", $authors);
    $authorID = [];
  
    foreach($allAuthors as $thisAuthor) {
        $sql = "SELECT * FROM tblAuthor WHERE knownAs = '$thisAuthor' LIMIT 1";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result)==0) {
            // author doesn't exist so add it to database tblAuthor
            $authorAtoms = explode(" ", $thisAuthor);
            $firstName = reset($authorAtoms);
            $lastName = end($authorAtoms);
            $middleNames = str_replace($firstName." ","", $thisAuthor);
            $middleNames = str_replace(" ".$lastName,"", $middleNames);
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

var_dump($authorID);


// split tags and check if they already exist in database
if (isset($tags) && $tags!='') {
    $allTags = explode(", ", $tags);
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

// ready to update the book to the database now
$sql = "UPDATE tblBook SET title ='$title', ISBN='$ISBN', locationID='$location', pages=NULLIF('$pages',''), year=NULLIF('$year',''), originalCost=NULLIF('$cost',''), copies=NULLIF('$copies',''), description=NULLIF('$description',''), cover=NULLIF('$cover','') WHERE ID='$bookID'"; 
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "<div class='alert alert-danger'>Error adding book to database</alert>";
    exit();
}

// add Author Link(s)
foreach ($authorID as $thisAuthorID) {
    $sql = "INSERT INTO tblAuthor_Book (bookID, authorID) VALUES ('$bookID', NULLIF('$thisAuthorID',''))";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-danger'>Error adding author link</alert>";
        exit();
    }
}

// add Tag Link
foreach ($tagID as $thisTagID) {
    $sql = "INSERT INTO tblTag_Book (tagID, bookID) VALUES (NULLIF('$thisTagID',''), '$bookID')";
    $result2 = mysqli_query($link, $sql);
    if (!$result2) {
        echo "<div class='alert alert-danger'>Error adding tag link</alert>";
        exit();
    }
}

// add Publisher Link
$sql = "INSERT INTO tblPublisher_Book (publisherID, bookID) VALUES (NULLIF('$newPublisherID',''), '$bookID')";
$result3 = mysqli_query($link, $sql);
if (!$result3) {
    echo "<div class='alert alert-danger'>Error adding publisher link</alert>";
    exit();
}

include ("updateBookList_nonfunc.php");

echo 'success';

?>