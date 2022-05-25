<?php

function updateBookList($link) {
    $_SESSION['timeout'] = time()+(15*60); // reset timeout
    $sql= "SELECT b.ID, b.title, b.ISBN, b.pages, b.year, b.originalCost, b.description, b.cover, b.copies, loc.Description AS LocationName, 
    GROUP_CONCAT(DISTINCT a.knownAs) as AuthorNames, GROUP_CONCAT(DISTINCT a.ID) as author_ID,
    GROUP_CONCAT(DISTINCT p.Name) as PublisherNames, GROUP_CONCAT(DISTINCT p.ID) as Publisher_ID,
    GROUP_CONCAT(DISTINCT t.Name) as TagNames, GROUP_CONCAT(DISTINCT t.ID) as tag_ID
                        
    FROM tblBook b 
    LEFT JOIN tblAuthor_Book ab ON  b.ID = ab.bookID
    LEFT JOIN tblAuthor a ON ab.authorID = a.ID
    LEFT JOIN tblPublisher_Book pb ON b.ID=pb.bookID
    LEFT JOIN tblPublisher p ON pb.publisherID = p.ID
    LEFT JOIN tblTag_Book tb ON b.ID=tb.bookID
    LEFT JOIN tblTag t ON tb.tagID = t.ID
    INNER JOIN tblLocation loc ON b.locationID = loc.ID
    GROUP BY b.ID";
                        
    $result = mysqli_query($link, $sql);
    $returnString = "";                      
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $returnString .= "<tr>";
        if (!isset($row['cover']) || $row['cover']=='') {
            $row['cover'] = '/images/noImage.png';
        }

        $returnString .= "<td class='align-middle'><img class='img-fluid' src='" . $row['cover'] ."'></td>";
        $returnString .= "<td class='align-middle'>" . $row['title'] . "</td>";
        $returnString .= "<td class='align-middle'>". $row['ISBN'] ."</td>";
        $returnString .= "<td class='align-middle'>". $row['AuthorNames'] ."</td>";
        $returnString .= "<td class='align-middle'>". $row['PublisherNames'] ."</td>";
        $returnString .= "<td class='align-middle'>". $row['TagNames'] ."</td>";
        $returnString .= "<td class='align-middle'>". $row['LocationName'] ."</td>";
        $returnString .= "<td class='text-center align-middle'>". $row['pages'] ."</td>";
        $returnString .= "<td class='text-center align-middle'>". $row['year'] ."</td>";
        $returnString .= "<td class='text-end align-middle'>£". number_format($row['originalCost'] ?? 0,2,'.','') ."</td>";
        $returnString .= "<td class='text-center align-middle'>" . $row['copies'] . "</td>";
        $returnString .= "<td class='text-center align-middle'><button class='btn btn-link' onclick='pencilButton(". $row['ID'] .")'><i class='bi bi-pencil'></i></button></td>";
        $returnString .= "</tr>";
    }
    
    echo $returnString;
}

?>



