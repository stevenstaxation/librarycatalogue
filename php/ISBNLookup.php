<?php 
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$ISBN = $_POST['ISBNTextField'];
$checkISBN = isValidISBN($ISBN);
if ($checkISBN===0) {

    // if ISBN already exists in database then stop with an error
    $sql = "SELECT * FROM tblBook WHERE ISBN='$ISBN'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result)>0) {
        echo "<div class='alert alert-warning d-flex align-items-center'>
        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16'>
            <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
        </svg>
        That ISBN already exists in the library</div>";
        exit();
    }

    $page = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:" . $ISBN);
    $data = json_decode($page, true);


    $coverSource = $data['items'][0]['volumeInfo']['imageLinks']['smallThumbnail'] ?? '';
    if ($coverSource=='') {
        $coverSource = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'] ?? '';
    }

    $title = $data['items'][0]['volumeInfo']['title'] ?? '';
    $title = mysqli_real_escape_string($link, $title);

    $publisher =  $data['items'][0]['volumeInfo']['publisher'] ?? '';

    if (strlen($data['items'][0]['volumeInfo']['publishedDate'])>=4) {
        $firstPublished = substr($data['items'][0]['volumeInfo']['publishedDate'],0,4);
    }

    $pages = $data['items'][0]['volumeInfo']['pageCount'] ?? '';

    $authors='';
    for ($ix=0; $ix < count($data['items'][0]['volumeInfo']['authors']); $ix++) {
        $authors .= $data['items'][0]['volumeInfo']['authors'][$ix] . ", ";
    }
    $authors = substr($authors,0, strlen($authors)-2);

    if (array_key_exists('categories', $data['items'][0]['volumeInfo'])) {
        $categories = '';
        for ($ix=0; $ix < count($data['items'][0]['volumeInfo']['categories']); $ix++) {
            $categories .= $data['items'][0]['volumeInfo']['categories'][$ix] . ", ";
        }
        $categories = substr($categories,0, strlen($categories)-2);
    } else {
        $categories = '';
    }

    $notes = $data['items'][0]['volumeInfo']['description'] ?? '';
    $notes = stripcslashes(mysqli_real_escape_string($link, $notes));
    
    $bookData = ['coverSource'=>$coverSource, 'title'=>$title, 'publisher'=>$publisher, 'firstDate'=>$firstPublished, 'pages'=>$pages, 'authors'=>$authors, 'categories'=>$categories, 'ISBN'=>$ISBN, 'notes'=>$notes];

    echo json_encode($bookData);
   

} elseif ($checkISBN<0) {
    echo "<div class='alert alert-danger d-flex align-items-center'>
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
    </svg>
    ISBN must be 10 or 13 characters long</div>";
    exit();
} else {
    echo "<div class='alert alert-danger d-flex align-items-center'>
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
    </svg>
    Invalid ISBN due to failed checksum</div>";
    exit();
}

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


function bulkISBNImport() {
 
    $file_to_read = fopen("importList.csv", 'r');
 
    while (!feof($file_to_read) ) {
        $lines[] = fgetcsv($file_to_read, 1000, ',');
 
    }
 
    fclose($file_to_read);
    return $lines;
}


?>