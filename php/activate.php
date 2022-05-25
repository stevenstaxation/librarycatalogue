<?php
session_start();
include('connect.php');

?>

<!DOCTYPE html>
<HTML lang='en'>
    <HEAD>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name = "viewport" content="width-device-width, initial-scale=1">
        <title>Account Activation</title>
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!--JQUERY-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>    

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Roboto', san-serif;
                font-weight: 200
            }
        h1 {
            color: purple;
        }
        .contactForm {
            border: 1px solid mediumseagreen;
            margin-top: 50px;
            border-radius: 15px;
        }
        </style>

    </HEAD>

    <BODY>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-sm offset-1 col-sm-10 contactForm'>
                    <h1>Stevens Library Catalogue</h1>
                
                    <?php
                    // If email or activation key is missing then show an error
                    if (!isset($_GET['email']) || !isset($_GET['key'])) {
                        echo '<div class="alert alert-warning">There was an error registering your account, please click on the activation link you received by email</div>';
                        exit();
                    }

                    $email = mysqli_real_escape_string($link,$_GET['email']);
                    $key = mysqli_real_escape_string($link,$_GET['key']);

                    // Run query - set activation field to activated for the email provided
                    $sql = "UPDATE tblUser SET activation='activated' WHERE (email = '$email' AND activation ='$key') LIMIT 1";
                    $result = mysqli_query($link,$sql);
                    // If query is successful, show success message and invite user to login
                    if (mysqli_affected_rows($link) == 1) {
                        $sql = "SELECT ID FROM tblUser WHERE (email='$email' AND activation='activated')";
                        $result = mysqli_query($link, $sql);
                        $row = mysqli_fetch_array($result);
            
                        echo '<div class="alert alert-success">Your account registration has been completed successfully</div>';
                        echo '<a href="../login.php" type="button" class="btn-lg btn-success" style="margin-bottom: 10px;">Log In</a>'; 
                    } else {
                        // Show error message
                        echo '<div class="alert alert-danger">Your account could not be activated.</div>';
                    }       
                    ?>
                
                </div>
            </div>
        </div>
    </BODY>


</HTML>





































