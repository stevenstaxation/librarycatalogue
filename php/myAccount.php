<?php
session_start();
include ('connect.php');
$_SESSION['timeout'] = time()+(15*60); // reset timeout

$thisUser = $_SESSION['ID'];

$sql = "SELECT * FROM tblUser";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$returnString = "
<div id='showMyAccount'>
    <h3><strong>My Account - " . $row['userName'] . "</strong></h3>
    <form>
        <div class='form-group'>
            <div class='row'>
                <div class='col-md-6'>
                    <h5><label class='myAccountLabelField' for='myAccountUserName'>User Name</label></h5>
                </div>
                <div class='col-md-6'>
                   <h5><input id='myAccountUserName'class='myAccountTextField' type='text' value = '" . $row['userName'] ."'></h5>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-md-6'>
                    <h5><label class='myAccountLabelField' for='myAccountEmail'>Email Address</label></h5>
                </div>
                <div class='col-md-6'>
                   <h5><input id='myAccountEmail' class='myAccountTextField' type='text' value = '" . $row['email'] ."'></h5>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-md-6'>
                    <h5><label class='myAccountLabelField' for='myAccountPassword'>Password</label></h5>
                </div>
                <div class='col-md-6'>
                    <div class='input-group'>
                        <button class='btn btn-lg btn-link' style='height: 56px;'>change my password</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <div class='form-group'>
            <div class='row'>
                <div class='col-md-6'>
                    <h5><label class='myAccountLabelField' for='darkModeSwitch'>Use Dark Mode</label></h5>
                </div>
                <div class='col-md-6'>
                    <div class='form-check form-switch'>";
                        if ($row['darkmode']==1) {
                            $returnString .="<input class='form-check-input' type='checkbox' id='darkModeSwitch' style='margin: 12px 3px;height:32px; width: 60px' checked>";                    
                        } else {
                            $returnString .="<input class='form-check-input' type='checkbox' id='darkModeSwitch' style='margin: 12px 3px;height:32px; width: 60px'>";
                        }
                    
                    $returnString .="
                    </div>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-md-6'>
                    <h5><label class='myAccountLabelField' for='userDateFormat'>Date Format</label></h5>
                </div>
                <div class='col-md-6'>
                    <div class='input-group'>
                      <select id='userDateFormat' class='custom-select myAccountTextField'>";
                        $sql = 'SELECT * FROM tblDateFormat';                      
                        $result = mysqli_query($link, $sql);
                        while ($rowDate = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            if ($row['dateFormat']==$rowDate['ID']) {
                                $returnString .= "<option value='" . $rowDate['ID'] . "' selected>" . $rowDate['description'] ."</option>";
                            } else {
                                $returnString .="<option value='" . $rowDate['ID'] . "'>" . $rowDate['description'] ."</option>";
                            }
                        }
                      
        $returnString .="</select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div id='accountMessage'></div>
        <br>
        <div class='text-center'>
            <div class='btn-group'>
                <button id='updateMyAccount' class='btn btn-success' style='width:150px; margin-right:30px;' disabled=disabled>Update</button>
                <button id='resetViewAccount' class='btn btn-danger' style='width: 150px; margin-left:30px;'>Reset</button>
            </div>
        </div>      
    </form>

</div>";




echo $returnString;
?>


