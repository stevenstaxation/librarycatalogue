<?php
include ('connect.php');
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
    $returnString = "<table id='books' class='table table-bordered table-sm' style='width:100%'>
    <thead>
        <tr class='table-info'>
            <th class='text-center'>Cover</th>
            <th>Title</th>
            <th class='text-center'>ISBN</th>
            <th>Author(s)</th>
            <th>Publisher(s)</th>
            <th>Tags</th>
            <th>Location</th>
            <th class='text-center'>Pages</th>
            <th class='text-center'>Year</th>
            <th class='text-end'>Cost</th>
            <th class='text-center'>Copies</th>
            <th class='text-center'>Edit</th>
        </tr>
    </thead>
    <tbody id='bookListBody'>";                
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $returnString .= "<tr>";
                if (!isset($row['cover']) || $row['cover']=='') {
                    $row['cover'] = '/images/noImage.png';
                }
                $returnString .= "<td class='align-middle'><img class='img-fluid' src='" .$row['cover'] ."'></td>";
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
                $returnString .= "<td class='text-center align-middle'><button onclick='pencilButton(". $row['ID'] .")' class='btn btn-link'><i class='bi bi-pencil'></i></button></td>";
                $returnString .= "</tr>";
            }

$returnString .="
    </tbody>
    <tfoot>
        <tr class='table-info'>
            <th class='text-center'>Cover</th>
            <th>Title</th>
            <th class='text-center'>ISBN</th>
            <th>Author(s)</th>
            <th>Publisher(s)</th>
            <th>Tags</th>
            <th>Location</th>
            <th class='text-center'>Pages</th>
            <th class='text-center'>Year</th>
            <th class='text-end'>Cost</th>
            <th class='text-center'>Copies</th>
            <th class='text-center'>Edit</th>
        </tr>
    </tfoot>
</table>

<script>
    $(document).ready(function(){
        $('#books').DataTable({
            colReorder: true,
            order: [[1, 'asc']],
            pagingType: 'numbers',
            processing: true,
            columnDefs: [
                {width: 100, targets: 0}
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            responsive: true,
            stateSave: true,
            dom: '<\"top\"lfrtip>rt<\"bottom\"pB><\"clear\">',
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Columns'
                },
                {
                    extend: 'copy',
                    text: 'Copy to Clipboard'
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                },
                {
                    extend: 'csv',
                    text: 'Export as CSV',
                },
                {
                    extend: 'print',
                    text: 'Print',
                    orientation: 'landscape'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',                            
                    exportOptions: {
                        columns: ':visible',
                        search: 'applied',
                        order: 'applied'
                    }
                }
            ],
            rowCallback: function (row, data, dataIndex) {
                if ($('body').hasClass('dark')) {
                    $('td', row).css('background-color', '#444444');
                    $('td', row).css('color', 'rgba(224,224,224,1)');
                } else {
                    $('td', row).css('background-color', '#FFFFFF');
                    $('td', row).css('color', 'rgba(68,68,68,1)');
                }
            }                 
        });
    });
</script>";

    echo $returnString;


?>

