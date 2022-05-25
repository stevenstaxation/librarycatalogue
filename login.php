<!DOCTYPE html>

<html>

<head>

    <title>Stevens Library Catalogue - Login</title>
    
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>    
    <!-- GOOGLE FONT  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/login.css">

    <script src='js/events.js'></script>
    <script src='js/login.js'></script>

</head>

<body class='login'>

<?php include ("php/modSignUp.php"); ?>


    <h1 class='masthead'>Stevens Library Catalogue</h1>

    <form id="logInForm" method="POST" action='#'>
        <h2>Sign in</h2>

       <div class='input-group'>
            <span class='input-group-text loginIcon' id='unameIcon'>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
            </span>
            <input type="text" class='form-control' id='uname' name="uname" placeholder="User Name" autocomplete="username"><br>
        </div>

        <div class='input-group'>
            <span class='input-group-text loginIcon' id='passwordIcon'>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/>
                </svg>
            </span>
            <input type="password" class='form-control' id='password' name="password" placeholder="Password" autocomplete="current-password"><br> 
            <span class='input-group-text loginIcon'>
                <i class='bi bi-eye-slash' id='eyeIcon'></i>
            </span>
        </div>

        <div class='form-check mt-2 mx-3'>
            <input class='form-check-input' type="checkbox" name="remember" id='remember' value="">
            <label class='form-check-label' for='remember' style='color: #888;font-size: 14px;'>Keep me signed in</label><br>
        </div>
        <div id='logInMessage'></div>
        <div class='col-md-11 d-grid gap-2 mt-3 mx-auto'>
            <button class='btn btn-success btn-block' id='logInButton' type="submit">Login</button>
        </div>
       
        <div class='col-md-12 mt-3 text-center'>
            <a style='color: #888;font-size: 14px;' href='#'>Forgotten your password? click <u>here</u> to reset</a>
        </div>
    </form>

        <div class='col-md-12 mt-5 text-center' style='color: #3b81f1'>
            Not a member? - sign up <a href='#' id='signUp'>here</a>
        </div>

        <script>
            const togglePassword = document.querySelector('#eyeIcon');
            const password = document.querySelector('#password');
    
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('bi-eye');
            });
        </script>
</body>

</html>




