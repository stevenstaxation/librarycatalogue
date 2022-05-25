<?php
    session_start();
    include('connect.php');

    // Rules for a valid form
    // $userEmail cannot be empty, must be a validly formatted email address and must not already be in use.
    // $userName cannot be empty, must be a unique username not already be in use.
    // $userPassword cannot be empty, must be a minimum of 8 digits, include one capital, one number and one symbol.
    // $userPassword2 must be identical to $userPassword.
    // $userAuthCode is supplied manually from genAuthCode.php algorithm, 8 characters.

    $errors = "";

    if (empty($_POST['userEmail'])) {
        // user email cannot be empty
        $errors .= "<li>Email address cannot be empty</li>";
    } 
    else 
    {
        // user email must be a validly formatted address
        $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errors .= "<li>Email address is not valid</li>";
        }
    }

    if (empty($_POST['userName'])) {
        // user name cannot be empty
        $errors .= "<li>Username cannot be empty</li>";
    } 
    else 
    {
        $userName = filter_var($_POST['userName'],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST['userPassword'])) {
        // password cannot be empty
        $errors .= "<li>Password cannot be empty</li>";
    } elseif (!(strlen($_POST['userPassword'])>=8 and preg_match('/[A-Z]/', $_POST['userPassword']) and preg_match('/[0-9]/', $_POST['userPassword']))) {
        // Password must be 8 or more characters, include at leat one capital letter, one number and one symbol
        $errors .= "<li>Password does not meet security requirements</li>";      
    } 
    else 
    {
        $userPassword = filter_var($_POST['userPassword'],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($_POST['userPasswordRepeat'])) {
            // Password2 cannot be empty
            $errors .= "<li>Confirmation password cannot be empty</li>";
        } else 
        {
            $userPassword2 = filter_var($_POST['userPasswordRepeat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Password2 must be identical to Password
            if ($userPassword !== $userPassword2) {
                $errors .= "<li>Password confirmation does not match password</li>";
            }
        }
    }   

    if (empty($_POST['userAuthorisationCode'])) {
            // Password2 cannot be empty
            $errors .= "<li>Authorisation code cannot be empty</li>";
    } 
    else 
    {
        $userAuthCode = filter_var($_POST['userAuthorisationCode'],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($userAuthCode != hash('crc32',$userEmail,false)) {
            $errors .= "<li>Invalid authorisation code</li>";
        }
    }
    

    if ($errors) {
        $errors = "<div class='alert alert-danger' style='font-size:12px'><strong>There are errors in your input</strong><br><ul>" . $errors . "</ul></div>";
        echo $errors;
        exit();
    }

    // prepare data for adding to database
    $userEmail = mysqli_real_escape_string($link, $userEmail);
    $userName = mysqli_real_escape_string($link, $userName);
    $userPassword = mysqli_real_escape_string($link, $userPassword);
    $userPassword = password_hash($userPassword, PASSWORD_BCRYPT);

    // does the email already exist?
    $sql = "SELECT * FROM tblUser WHERE email = '$userEmail'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-warning'>Database not currently available. " . mysqli_error($link) . "</div>";
        exit();
    }
    if (mysqli_num_rows($result)) {
        echo "<div class='alert alert-warning'>That email address has already been registered.<br>Do you want to <a href='../logIn.php'>log in</a> instead?</div>";
        exit();
    }

    // does the user name already exist?
    $sql = "SELECT * FROM tblUser WHERE userName = '$userName'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-warning'>Database not currently available. " . mysqli_error($link) . "</div>";
        exit();
    }
    if (mysqli_num_rows($result)) {
        echo "<div class='alert alert-warning'>That username has already been registered.<br>Do you want to <a href='../logIn.php'>log in</a> instead?</div>";
        exit();
    }

    // create a unique activation key
    $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    $sql = "INSERT INTO tblUser (email, userName, password, activation, darkmode) VALUES ('$userEmail', '$userName', '$userPassword', '$activationKey', 0)";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo "<div class='alert alert-warning'>Database not currently available. " . mysqli_error($link) . "</div>";
        exit();
    }

    $newUserID = $link->insert_id;

    // send user an email with an activation link
    require_once('../mailer/SMTP.php');
    require_once('../mailer/PHPMailer.php');
    require_once('../mailer/Exception.php');

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
   
    try {
        $mail->SMTPDebug=0; // verbose debug output
        $mail->isSMTP(); // set mailer to use SMTP
        $mail->Host='mail.overssl.net';
        $mail->SMTPAuth=true; // enable SMTP authentication
        $mail->Username='mailbox@stevenstaxation.com'; 
        $mail->Password='will220307'; 
        $mail->SMTPSecure='ssl';
        $mail->Port=465;
        $mail->setFrom('mailbox@stevenstaxation.com', 'Stevens Library Catalogue');
        $mail->addAddress($userEmail, $userEmail);  // Add a recipient
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Activate your Stevens Library Catalogue account now';
        $mail->Body = "
         <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
         <html xmlns='https://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
         <head>
            <title>Stevens Library Catalogue</title>
            <meta http–equiv='Content-Type' content='text/html; charset=utf-8'>
            <meta http–equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0 '>
            <meta name='format-detection' content='telephone=no'>
            <link rel='preconnect' href='https://fonts.googleapis.com'>
            <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
            <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;400;700&display=swap' rel='stylesheet'>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js' integrity='sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13' crossorigin='anonymous'></script>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css'>
            
           
            <script src='https://code.jquery.com/jquery-3.6.0.js' integrity='sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=' crossorigin='anonymous'> </script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
            


            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: 'Roboto', san-serif;
                 }
                h3 {
                    font-family: 'Roboto', san-serif;
                    font-weight: 700;    
                    font-size: 20px;
                }
                h4 {
                    font-family: 'Roboto', san-serif;
                    font-weight: 200;
                    font-size: 15px;
                }
                h5 {
                    font-family: 'Roboto', san-serif;
                    font-weight: 200;
                    font-size: 10px;
                }
                h6 {
                    font-family: 'Roboto', san-serif;
                    font-weight: 100;
                    font-size: 9px;
                }
            </style>
         </head>
         <body bgcolor='#ffffff'; >
             <table class='table table-borderless' valign='top' width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#ffffff' align='center'>
                 <tbody>
                     <tr><td><img style='display:block; margin-left: auto; margin-right: auto;' src='http://127.0.0.1:8080/images/bookstack.jpeg' width='120px'></td></tr>
                     <tr><td style='text-align:center'><h3>Welcome to Stevens Library Catalogue</h3></td></tr>
                     <tr class='text-center py-5'><td><h4>Thanks for registering for access to Stevens Library Catalogue.<br>All you need to do is verify your email address and activate your account by clicking on the button below.</h4></td></tr>
                     <tr class='text-center py-5'><td><a href='http://127.0.0.1:8080/php/activate.php?email=" . urlencode($userEmail) . "&key=$activationKey'><button type='button' class='btn btn-warning'>Activate Account</button></a></td></tr>
                     <tr class='text-center py-5'><td><h5>You are receiving this email because you recently created an account to access Stevens Library Catalogue. If this was not you, please ignore this email.</h5></td></tr>
                     <tr class='text-center py-5'><td><h6>&copy;&nbsp;2022 Stevens Taxation Services Ltd - All Rights Reserved</h6></td></tr>
                </tbody>
             </table>  
         </body>
         </html>
";
        
        $mail->AltBody= "Thanks for registering for access to the Stevens Library Catalogue.\n\nIf you are happy to continue your registration please click on the following link to activate your account.\n\n 127.0.0.1:8080/php/activate.php?email=" . urlencode($userEmail) . "&key=$activationKey</body></html>";
        $mail->send();

        echo "<div class='alert alert-success'>Thank you for registering.  A confirmation email has been sent to $userEmail.  You will need to click on the activation link in this email to activate your account before you can log in.</div>";
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: '.$mail->ErrorInfo;   
    }

?>

