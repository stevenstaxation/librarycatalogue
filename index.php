<?php
    session_start();
    if (!isset($_SESSION['email']) || !isset($_SESSION['userName']) || !isset($_SESSION['ID']) ) {
        header("Location: login.php");
    }
   $_SESSION['timeout'] = time()+(2*60); // timeout after 15 minutes of inactivity
?>

<!DOCTYPE HTML>

<HTML lang='en'>
    <HEAD>
       
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
        <meta charset='utf-8'>
        <meta http-equiv='x-ua-compatible' content='ie=edge'>
        
    
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        
        <!--JQUERY-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        
        <!--BOOTSTRAP DATATABLES-->
        <link rel='stylesheet' href='https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css'>
        <script src='https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js'></script>
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/fc-4.0.2/fh-3.2.2/r-2.2.9/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/fc-4.0.2/fh-3.2.2/r-2.2.9/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
        
        <!-- GOOGLE FONT  -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">

        <!-- SWEETALERT 2 -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- STYLE SHEETS -->
        <link rel="stylesheet" href="styles/main.css">

        <title>Stevens Library Catalogue</title>

    </HEAD>
    <BODY onload='setDarkMode(<?php echo $_SESSION['darkMode'];?>);'>
  
 
        <?php 
            include('php/logoheader.php');
            include('php/navbar.php');
            include('php/connect.php');
            include('php/modAddBook.php');
            include('php/modAddBookByTitle.php');
            include('php/modEditBook.php');
            include('php/modAddLocation.php');
            include('php/modEditLocation.php');
            include('php/updateBookList.php');
        ?>
        <input type='hidden' id='darkModeSession' style='display: none' value="<?php echo $_SESSION['darkMode']; ?>">
        <div class='container' id='myAccount'></div>
        <div class='container' id='settings'></div>
        <div class='container' id='uploadContainer'></div>
        <div class='container' id='searchBox'>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='input-group mb-3 textSearcher'>
                        <input type='text' class='form-control text-control' id='ISBNSearch' placeholder='Enter ISBN to lookup and add book...'>
                        <div class='input-group-append'>
                            <span class='input-group-button'><button id='ISBNSearchButton' class='btn btn-success'>+</button></span>
                        </div>        
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='input-group mb-3 textSearcher'>
                        <input type='text' class='form-control text-control'  id='textSearch' placeholder='Enter title text to add book...'>
                        <div class='input-group-append'>
                            <span class='input-group-button'><button id='textSearchButton' class='btn btn-success'>+</button></span>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        <div id='messageCentre'></div>
        <hr id='bookDivider'>
        <div class='container-fluid' id='bookList'>
            <table id='books' class='table table-bordered table-sm' style='width:100%'>
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
                <tbody id='bookListBody'>
                    <?php
                    updateBookList($link);
                    ?>
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
                        pagingType: "numbers",
                        processing: true,
                        columnDefs: [
                            {width: 100, targets: 0}
                        ],
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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

            </script>

        </div>
        
        
        <script src='js/events.js'></script>

    </BODY>
    
    

    </HTML>
