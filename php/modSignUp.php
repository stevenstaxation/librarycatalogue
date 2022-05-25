<div class="modal fade" id="modSignUp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img id='bookImage' height='80px' src="../images/bookstack.jpeg"></img>
                <h3 class="modal-title" id="staticBackdropLabel">Stevens Library Catalogue</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h4 class='form-title h4' style='text-align: center; margin-top: 8px; margin-bottom: 0;'>Create an account</h4>
        
                <form class='formSignUp'>
                    <div class='input-group'>
                        <span class='input-group-text loginIcon' id='userEmailIcon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                            </svg>
                        </span>
                        <input type="text" class='form-control' id='userEmail' name="userEmail" placeholder="Email address" autocomplete="email"><br>
                    </div>
                    <div class='input-group'>
                        <span class='input-group-text loginIcon' id='userNameIcon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </span>
                        <input type="text" class='form-control' id='userName' name="userName" placeholder="User Name" autocomplete="username"><br>
                    </div>     
                    <div class='input-group'>
                        <span class='input-group-text loginIcon' id='userPasswordIcon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                                <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/>
                            </svg>
                        </span>
                        <input type="password" class='form-control' id='userPassword' name="userPassword" placeholder="Create a password" autocomplete="new-password"><br> 
                        <span class='input-group-text loginIcon'>
                            <i class='bi bi-eye-slash' id='eyeIconNew'></i>
                        </span>
                    </div>
                    <div class='input-group'>
                        <span class='input-group-text loginIcon' id='userPasswordRepeatIcon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                            </svg>
                        </span>
                        <input type="password" class='form-control' id='userPasswordRepeat' name="userPasswordRepeat" placeholder="Confirm password" autocomplete="new-password"><br> 
                        <span class='input-group-text loginIcon'>
                            <i class='bi bi-eye-slash' id='eyeIconRepeat'></i>
                        </span>
                    </div>
                    <div class='input-group'>
                        <span class='input-group-text loginIcon' id='userAuthorisationCodeIcon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-123" viewBox="0 0 16 16">
                                <path d="M2.873 11.297V4.142H1.699L0 5.379v1.137l1.64-1.18h.06v5.961h1.174Zm3.213-5.09v-.063c0-.618.44-1.169 1.196-1.169.676 0 1.174.44 1.174 1.106 0 .624-.42 1.101-.807 1.526L4.99 10.553v.744h4.78v-.99H6.643v-.069L8.41 8.252c.65-.724 1.237-1.332 1.237-2.27C9.646 4.849 8.723 4 7.308 4c-1.573 0-2.36 1.064-2.36 2.15v.057h1.138Zm6.559 1.883h.786c.823 0 1.374.481 1.379 1.179.01.707-.55 1.216-1.421 1.21-.77-.005-1.326-.419-1.379-.953h-1.095c.042 1.053.938 1.918 2.464 1.918 1.478 0 2.642-.839 2.62-2.144-.02-1.143-.922-1.651-1.551-1.714v-.063c.535-.09 1.347-.66 1.326-1.678-.026-1.053-.933-1.855-2.359-1.845-1.5.005-2.317.88-2.348 1.898h1.116c.032-.498.498-.944 1.206-.944.703 0 1.206.435 1.206 1.07.005.64-.504 1.106-1.2 1.106h-.75v.96Z"/>
                            </svg>
                        </span>
                        <input type="text" class='form-control' id='userAuthorisationCode' name="userAuthorisationCode" placeholder="Authorisation code" autocomplete="one-time-code"><br> 
                    </div>
                </form>
            </div>

            <div class="modal-footer"> 
                <div class='col-md-12'>
                    <div id='registerMessage'></div>
                    <div class='text-center'>
                        <button type="button" class="btn btn-success" id='registerNewAccount'>Register Account</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<script>
    const togglePasswordNew = document.querySelector('#eyeIconNew');
    const passwordNew = document.querySelector('#userPassword');
    const togglePasswordRepeat = document.querySelector('#eyeIconRepeat');
    const passwordRepeat = document.querySelector('#userPasswordRepeat');
    
    togglePasswordNew.addEventListener('click', function() {
        const type = passwordNew.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordNew.setAttribute('type', type);
        this.classList.toggle('bi-eye');
    });
           
    togglePasswordRepeat.addEventListener('click', function() {
        const type = passwordRepeat.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordRepeat.setAttribute('type', type);
        this.classList.toggle('bi-eye');
    });
</script>
