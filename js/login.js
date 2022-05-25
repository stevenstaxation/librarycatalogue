
$(document).on('click', '#signUp', function (event) {
    event.preventDefault();
    $('#modSignUp').modal('show');
});

$(document).on('click', '#registerNewAccount', function(event) {
    event.preventDefault();
    let form = $('.formSignUp');
    
    $.ajax ({
        type: "POST",
        url: "../php/checkRegistration.php",
        data: form.serialize(),
        success: function (data) {
            if (data.includes('success')) {
                $('#registerMessage').html(data);
                setTimeout(function() {
                    $('#registerMessage').html('');
                    $('#modSignUp').modal('hide');
                },3500);
            }
            $('#registerMessage').html(data);
        }       
    });

})

$(document).on('submit','#logInForm', function(event) {
    event.preventDefault();
    let dataToPost = $(this).serializeArray();

    $.ajax({
        url: '../php/verify.php',
        timeout: 30000,
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                $('#logInMessage').html('');
                window.location = 'index.php';
            } else {
                $('#logInMessage').html(data);
            }

        }
    })
});

$(document).on('focus', '#uname', function() {
    $('#logInMessage').html('');
});

$(document).on('focus', '#password', function() {
    $('#logInMessage').html('');
});





