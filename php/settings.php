<?php
    session_start();
    include ('connect.php');
    $_SESSION['timeout'] = time()+(15*60); // reset timeout

    $thisUser = $_SESSION['ID'];
?>

<div id='showLocation'>
    <h3><strong>Location List</strong></h3>
    <form>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-9 col-md-10 col-lg-11'>
                    <h6 style='margin-left: 10px'>Description</h6>
                </div>
                <div class='col-sm-3 col-md-2 col-lg-1'>
                    <h6 style='text-align: center'>Count</h6>
                </div>
            </div>
            <div class='row' style='max-height: 70vh; overflow: auto;'>
                <div class='col-12'>
                    <ul class='list-group list-group-flush locationList'>

                    <?php
                        $sql = 'SELECT * FROM tblLocation';                      
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $sql = "SELECT COUNT(*) FROM tblBook WHERE locationID='" . $row['ID'] ."'";
                            $countResult = mysqli_query($link, $sql);
                            $count = mysqli_fetch_array($countResult);
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center' value='" . $row['ID'] ."'>" .$row['Description'] ."<span class='badge bg-danger rounded-pill'>$count[0]</span></li>";
                        }
                    ?>
                        
                    </ul>
                </div>
            </div>
  
            <br>
            <hr>
            <div id='settingsMessage'></div>
            <br>
            <div class='text-center'>
                <div class='btn-group'>
                    <button id='addLocation' class='btn btn-success' style='width:150px; margin-right:30px;'>Add Location</button>
                </div>
            </div>      
        </div>
    </form>
</div>



