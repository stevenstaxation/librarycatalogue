<?php 
include ("connect.php");
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$errors = 'success';
$ISBN = $_POST['ISBN'];
$LocationID = $_POST['LocationID'];

    $ISBN = trim($ISBN);
    $checkISBN = isValidISBN($ISBN);
    if ($checkISBN===0) {

        // if ISBN already exists in database then skip it
        $sql = "SELECT * FROM tblBook WHERE ISBN='$ISBN'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result)>0) {
            $errors = $ISBN . " already in database";
        } else {

            $page = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:" . $ISBN);
            $data = json_decode($page, true);

            if (isset($data['items'])) {

                $coverSource = $data['items'][0]['volumeInfo']['imageLinks']['smallThumbnail'] ?? '';
                if ($coverSource=='') {
                    $coverSource = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'] ?? '';
                }

                $title = $data['items'][0]['volumeInfo']['title'] ?? '';
                $title = mysqli_real_escape_string($link, $title);

                $publisher =  $data['items'][0]['volumeInfo']['publisher'] ?? '';
                $publisher = mysqli_real_escape_string($link, $publisher);

                if (strlen($data['items'][0]['volumeInfo']['publishedDate'])>=4) {
                    $firstPublished = substr($data['items'][0]['volumeInfo']['publishedDate'],0,4);
                }

                $pages = $data['items'][0]['volumeInfo']['pageCount'] ?? '';
 
                if (array_key_exists('authors', $data['items'][0]['volumeInfo'])) {
                    $authors='';
                    for ($ix=0; $ix < count($data['items'][0]['volumeInfo']['authors']); $ix++) {
                        $authors .= $data['items'][0]['volumeInfo']['authors'][$ix] . ", ";
                    }
                    $authors = substr($authors,0, strlen($authors)-2);
                } else {
                    $authors='';
                }

                $authors = mysqli_real_escape_string($link, $authors);

                if (array_key_exists('categories', $data['items'][0]['volumeInfo'])) {
                    $categories = '';
                    for ($ix=0; $ix < count($data['items'][0]['volumeInfo']['categories']); $ix++) {
                        $categories .= $data['items'][0]['volumeInfo']['categories'][$ix] . ", ";
                    }
                    $categories = substr($categories,0, strlen($categories)-2);
                } else {
                    $categories = '';
                }

                $tags = mysqli_real_escape_string($link, $categories);


                $notes = $data['items'][0]['volumeInfo']['description'] ?? '';
                $notes = mysqli_real_escape_string($link, $notes);
        
                // add to database
                if (isset($authors) && $authors!='') {
                    $allAuthors = explode(", ", $authors);
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

                // ready to add the book to the database now
                $sql = "INSERT INTO tblBook (title, ISBN, locationID, pages, year, originalCost, copies, description,cover) 
                VALUES ('$title', '$ISBN', NULLIF('$LocationID',''), NULLIF('$pages',''), NULLIF('$firstPublished',''), 0, 1,NULLIF('$notes',''), NULLIF('$coverSource',''))";
                $result = mysqli_query($link, $sql);
                $newBookID = mysqli_insert_id($link);
                if (!$result) {
                    echo "<div class='alert alert-danger'>Error adding book to database</alert>";
                    exit();
                }

                // add Author Link(s)
                if (isset($authorID)) {
                    foreach ($authorID as $thisAuthorID) {
                        $sql = "INSERT INTO tblAuthor_Book (bookID, authorID) VALUES ('$newBookID', NULLIF('$thisAuthorID',''))";
                        $result = mysqli_query($link, $sql);
                        if (!$result) {
                            echo "<div class='alert alert-danger'>Error adding author link</alert>";
                            exit();
                        }
                    }
                }

                // add Tag Link
                if (isset($tagID)) {
                    foreach ($tagID as $thisTagID) {
                        $sql = "INSERT INTO tblTag_Book (tagID, bookID) VALUES (NULLIF('$thisTagID',''), '$newBookID')";
                        $result2 = mysqli_query($link, $sql);
                        if (!$result2) {
                            echo "<div class='alert alert-danger'>Error adding tag link</alert>";
                            exit();
                        }
                    }
                }

                // add Publisher Link
                $sql = "INSERT INTO tblPublisher_Book (publisherID, bookID) VALUES (NULLIF('$newPublisherID',''), '$newBookID')";
                $result3 = mysqli_query($link, $sql);
                if (!$result3) {
                    echo "<div class='alert alert-danger'>Error adding publisher link</alert>";
                    exit();
                }
            } else {
                $errors = $ISBN . " - Cannot find information";
            }
        }
    } else {
            $errors = $ISBN . " - Invalid ISBN";
        }



echo $errors;


function isValidISBN($ISBNToParse) {
    // function to check length and checksum of an ISBN
    // will return 0 if the ISBN is valid and return -1 if the ISBN is an incorrect length.  
    // Any other non zero positive return signifies an incorrect checksum

    // ISBN must be 10 or 13 digits long
    // all digits should be numeric (this is taken care of with keyDown event)
    // except on occasions there will be a check digit of X in 10 digit ISBN's
    $ISBNLength = strlen($ISBNToParse);
    $digits = str_split($ISBNToParse);

    if ($ISBNLength===10) {
        // checksum is calculated as the sum of 10 x digit 1 + 9 x digit 2 ... + 2 x digit 9
        // which is then made modulo 11 = 0 by adding a number (add a number to make it divisible by 11)
        // the number added must be the checksum and is in the range 0 - 10 (X is used for 10)       
        if ($digits[9]=='X' || $digits[9]=='x') {$digits[9] = 10;};
        
        $checksum = 0;
        for ($ix = 0; $ix <10; ++$ix) {
           
            $checksum += $digits[$ix] *(10-$ix);
        }        
        return ($checksum %11);
        exit();
    }

    if ($ISBNLength===13) {
        $checksum = 0;
        for ($ix = 0; $ix <12; $ix+=2) {
            $checksum += $digits[$ix];
            $checksum += $digits[$ix+1]*3;
        }
        $checksum += $digits[12];
        return $checksum % 10;
    }
  
    if ($ISBNLength!==10 && $ISBNLength!==13) {
        return -1;
        exit();
    }

}

?>