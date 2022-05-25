$(document).ready(function(){
    setInterval(function(){
   
            $.get("../php/checkTimeout.php", function(data){
            if(data==0) window.location.href="../php/logout.php";
           
             if (data>-60) {
                $('#messageCentre').html ("<div style = 'color:red'>WARNING: You will be logged out in " + (-data) + " seconds, due to inactivity</div>");
             } else {
                $('#messageCentre').html();
             }
            });
        },60*1000); // check once every minute
});


document.querySelector('#ISBNSearch').addEventListener('keydown', (e) => {
    
    // allow backspace
    if (e.keyCode===8) {
        return;
    }

    // allow X or x (which can be a check digit for a 10 digit ISBN)
    if (e.keyCode===88 || e.keyCode===120) {
        return;
    }

    // allow arrow keys
    if (e.keyCode>=37 && e.keyCode<=40) {
        return;
    }
    
    // allow numbers
    if (e.keyCode>=48 && e.keyCode<=57) {
        return;
    }

    // enter initiates search
    if (e.keyCode===13) {
        $('#ISBNSearchButton').click();
    }

    e.preventDefault();

});

document.querySelector('#textSearch').addEventListener('keydown', (e) => {
    // enter initiates search
    if (e.keyCode===13) {
        $('#textSearchButton').click();
    }

});

document.querySelector('#ISBNSearchButton').addEventListener('click', (e) => {

    let dataToPost = {
        ISBNTextField: document.querySelector('#ISBNSearch').value
    }
    
    $.ajax ({
        url: '../php/ISBNLookup.php',
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (checkJSON(data)=='string') {
                $('#messageCentre').html(data);  
                setTimeout(function() {
                    $('#messageCentre').html('');
                },2500)           
            } else {
                data = JSON.parse(data);
                $('#bookImage').attr('src', data['coverSource']);
                $('#ISBN').html(data['ISBN']);
                $('#bookTitle').val(data['title']);
                $('#bookDescription').html(data['notes']);
                $('#bookAuthors').html(data['authors']);
                $('#bookPublisher').html(data['publisher']);
                $('#bookTags').html(data['categories']);
                $('#bookYear').val(data['firstDate']);
                $('#bookPages').val(data['pages']);
                $('#modAddBook').modal('show');
            }        
        }
    })
});

document.querySelector('#textSearchButton').addEventListener('click', (e) => {
    $('#bookTitleByTitle').val(document.querySelector('#textSearch').value);
    $('#modAddBookByTitle').modal('show');
});

document.querySelector('#addNewBookButton').addEventListener('click', (e) => {
    let dataToPost = {};
    dataToPost.ISBN = $('#ISBN').html();
    dataToPost.title = $('#bookTitle').val();
    dataToPost.description = $('#bookDescription').val();
    dataToPost.authors = $('#bookAuthors').val();
    dataToPost.publisher = $('#bookPublisher').val();
    dataToPost.year = $('#bookYear').val();
    dataToPost.pages = $('#bookPages').val();
    dataToPost.location = $('#bookLocation').val();
    dataToPost.tags = $('#bookTags').val();
    dataToPost.copies = $('#bookCopies').val();    
    dataToPost.cost = $('#bookCost').val();
    dataToPost.cover = $('#bookImage').attr('src');

    $.ajax ({
        url: '../php/addBook.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#bookList').html(data);
            $('#modAddBook').modal('hide');
            $('#messageCentre').html("<div class='alert alert-success'>Book added successfully</div>");
            $('#ISBNSearch').val('');
            setTimeout (function() {
                $('#messageCentre').html('');
            }, 2000);
        }
    });
});

document.querySelector('#addNewBookButtonByTitle').addEventListener('click', (e) => {
    let dataToPost = {};
    dataToPost.ISBN = $('#ISBNByTitle').val();
    dataToPost.title = $('#bookTitleByTitle').val();
    dataToPost.description = $('#bookDescriptionByTitle').val();
    dataToPost.authors = $('#bookAuthorsByTitle').val();
    dataToPost.publisher = $('#bookPublisherByTitle').val();
    dataToPost.year = $('#bookYearByTitle').val();
    dataToPost.pages = $('#bookPagesByTitle').val();
    dataToPost.location = $('#bookLocationByTitle').val();
    dataToPost.tags = $('#bookTagsByTitle').val();
    dataToPost.copies = $('#bookCopiesByTitle').val();    
    dataToPost.cost = $('#bookCostByTitle').val();
    dataToPost.cover = $('#bookImageByTitle').attr('src');

    $.ajax ({
        url: '../php/addBookByTitle.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#bookList').html(data);
            $('#modAddBookByTitle').modal('hide');
            $('#messageCentre').html("<div class='alert alert-success'>Book added successfully</div>");
            $('#textSearch').val('');
            setTimeout (function() {
                $('#messageCentre').html('');
            }, 2000);
        }
    });
});

document.querySelector('#bulkImport').addEventListener('click', (e) => {
    $.ajax ({
        url: "../php/getLocationList.php",
        timeout: 30000,
        type: "POST",
        success: function(data) {
            $('#uploadContainer').html(data);
        }
    });
    $('#searchBox').slideUp();
    $('#bookList').slideUp();
    $('#settings').slideUp();
    $('#bookDivider').hide();
    $('#myAccount').slideUp();
    $('#uploadContainer').slideDown();

});

$(document).on('click','#uploadButton', function() {
    document.querySelector('#file').click();    
})

$('#file').change(function(event) {
    let fileName =$(this).val().split('\\').pop();
    uploadFile (event.target.files)
 
});

$(document).on('click', '#logOut', function() {
    $.ajax ({
        url: "../php/logout.php",
        type: "GET",
        success: function() {
            window.location.href="../index.php"
        },
        error: function() {
            window.location.href="../index.php"    
        }
    })
});

$(document).on('click', '#myAccountButton', function() {
    $.ajax ({
        url: "../php/myAccount.php",
        timeout: 30000,
        type: "POST",
        success: function(data) {
            $('#myAccount').html(data);
            setDarkMode($('#darkModeSwitch').is(':checked'));
        }
    });
    $('#searchBox').slideUp();
    $('#bookList').slideUp();
    $('#settings').slideUp();
    $('#uploadContainer').slideUp();
    $('#bookDivider').hide();
    $('#myAccount').slideDown();
});

$(document).on('click', '#resetViewAccount', function(event) {
    event.preventDefault();
    $('#myAccountButton').trigger('click');
});

$(document).on('click', '#updateMyAccount', function (event) {
    event.preventDefault();
    let dataToPost = {};
    dataToPost.userName = $('#myAccountUserName').val();
    dataToPost.userEmail = $('#myAccountEmail').val();
    dataToPost.userDarkMode = $('#darkModeSwitch').is(':checked');
    dataToPost.userDateFormat = $('#userDateFormat').val();
    $.ajax ({
        url: '../php/updateMyAccount.php',
        data: dataToPost,
        type: 'POST',
        timeout: 30000,
        success: function(data) {
            if (data.includes('success')) {
                $('#updateMyAccount').prop('disabled', true);
                $('#accountMessage').html(data);
                setTimeout (function() {
                    $('#accountMessage').html('');
                }, 2000);
            } else {
                $('#accountMessage').html(data);
            }
        }
   });
});

$(document).on('focus', '#myAccountUserName', function () {
    $('#updateMyAccount').prop('disabled', false);
});
$(document).on('focus', '#myAccountEmail', function () {
    $('#updateMyAccount').prop('disabled', false);
});
$(document).on('change', '#darkModeSwitch', function() {
    setDarkMode($('#darkModeSwitch').is(':checked'));
    $('#updateMyAccount').prop('disabled', false);
});

$(document).on('click', '#userDateFormat', function () {
    $('#updateMyAccount').prop('disabled', false);
});

$(document).on('click', '#showBooks', function() {
    $('#myAccount').slideUp();
    $('#searchBox').slideDown();
    $('#settings').slideUp();
    $('#uploadContainer').slideUp();
    $('#bookDivider').show();
    $('#bookList').slideDown();
    $.get("../php/resetTimeOut.php", function(){
    });
});

$(document).on('click', '#addLocation', function() {
    $('#modAddLocation').modal('show');
});

$(document).on('click', '#addNewLocationButton', function() {
    let dataToPost = {};
    dataToPost.newLocation = $('#newLocation').val();

    $.ajax ({
        url: '../php/addLocation.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            if (data.includes('success')) {
                $('#addLocationModalMessage').html(data);
                setTimeout(function() {
                    $('#addLocationModalMessage').html('');
                    $('#modAddLocation').modal('hide');    
                    $('#showSettings').trigger('click');

                },2000)
            } else {
                $('#addLocationModalMessage').html(data)     
            }
        }
    })
});

$(document).on('dblclick', '.locationList', function(e) {
    let dataToPost = {};
    dataToPost.locationID = e.target.value;
    $('#editableLocationID').val(dataToPost.locationID); // save the ID so it can be used in delete and update calls

    $.ajax ({
        url: '../php/getLocationToEdit.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            let location = data.split("~");
            if (location[0] != 0) {
                $('#deleteLocationButton').attr('disabled', true);
            } else {
                $('#deleteLocationButton').attr('disabled', false);
            }
            $('#editLocation').val(location[1]);
            $('#modEditLocation').modal('show');
        }
    })
});

$(document).on('click', '#editLocationButton', function () {
    let dataToPost = {};
    dataToPost.editableLocationID = $('#editableLocationID').val();
    dataToPost.editedLocation = $('#editLocation').val();

    $.ajax ({
        url: '../php/updateLocation.php',
        timeout: 30000,
        type: 'POST',
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                $('#editLocationModalMessage').html(data);
                setTimeout(function() {
                    $('#editLocationModalMessage').html('');
                    $('#modEditLocation').modal('hide');
                    $('#showSettings').trigger('click');
                },2000);
            } else {
                $('#editLocationModalMessage').html(data);
                setTimeout(function() {
                    $('#editLocationModalMessage').html('');
                },5000);
            }
        }
    });
})

$(document).on('click', '#deleteLocationButton', function() {
let dataToPost = {};
    dataToPost.deletableLocationID = $('#editableLocationID').val();
 new swal ({
     title: 'Are you sure you want to delete location?',
     showDenyButton: true,
     confirmButtonText: 'Delete',
     denyButtonText: "Don't Do It", 
 }).then((result) => {
     if (result.isConfirmed) {
        $.ajax ({
            url: '../php/deleteLocation.php',
            timeout: 30000,
            type: 'POST',
            data: dataToPost,
            success: function(data) {
                if (data.includes('success')) {
                    $('#editLocationModalMessage').html(data);
                    setTimeout(function() {
                        $('#editLocationModalMessage').html('');
                        $('#modEditLocation').modal('hide');
                        $('#showSettings').trigger('click');
                    },2000);
                } else {
                    $('#editLocationModalMessage').html(data);
                }
            }
        })  
     } 
 })
   
});

$(document).on('click', '#editBookButton', function() {
    let dataToPost = {};
    dataToPost.editableBookID = $('#editingHiddenRow').val();
    dataToPost.ISBN = $('#editISBN').val();
    dataToPost.title = $('#editBookTitle').val();
    dataToPost.description = $('#editBookDescription').val();
    dataToPost.authors = $('#editBookAuthors').val();
    dataToPost.publisher = $('#editBookPublisher').val();
    dataToPost.year = $('#editBookYear').val();
    dataToPost.pages = $('#editBookPages').val();
    dataToPost.location = $('#editBookLocation').val();
    dataToPost.tags = $('#editBookTags').val();
    dataToPost.copies = $('#editBookCopies').val();
    dataToPost.cost = $('#editBookCost').val();
    dataToPost.cover = $('#editBookImage').attr('src');
    
    $.ajax ({
        url: '../php/updateBook.php',
        timeout: 30000,
        type: 'POST',
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                $('#editBookModalMessage').html(data);
                setTimeout(function() {
                    $('#editBookModalMessage').html('');
                    $('#modEditBook').modal('hide');
                    $.when(updateBookList()).done(function(bookList) {
                        $('#bookList').html(bookList);
                    });     
                },2000);
            } else {
                $('#editBookModalMessage').html(data);
            }
        }
    })
});


$(document).on('click', '#deleteBookButton', function() {
    let dataToPost = {};
    dataToPost.deletableBookID = $('#editingHiddenRow').val();

    new swal ({
        title: 'Are you sure you want to delete this book?',
        showDenyButton: true,
        confirmButtonText: 'Delete',
        denyButtonText: "Don't Do It", 
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax ({
                url: '../php/deleteBook.php',
                timeout: 30000,
                type: 'POST',
                data: dataToPost,
                success: function(data) {
                    if (data.includes('success')) {
                        $('#editBookModalMessage').html(data);
                        setTimeout(function() {
                            $('#editBookModalMessage').html('');
                            $('#modEditBook').modal('hide');
                            $.when(updateBookList()).done(function(bookList) {
                                $('#bookList').html(bookList);
                            });     
                        },2000);
                    } else {
                        $('#editBookModalMessage').html(data);
                    }
                }
            })
        }
    });
});


$(document).on('click','#showSettings', function() {
    $.ajax ({
        url: "../php/settings.php",
        timeout: 30000,
        type: "POST",
        success: function(data) {
            $('#settings').html(data);
        }
    });
    $('#searchBox').slideUp();
    $('#bookList').slideUp();
    $('#uploadContainer').slideUp();
    $('#bookDivider').hide();
    $('#myAccount').slideUp();
    $('#settings').slideDown();
});

function pencilButton (rowID) {
    let dataToPost = {};
    dataToPost.bookID = rowID;
    $.ajax ({
        url: '../php/getBookData.php',
        timeout: 30000,
        type: "POST",
        data: dataToPost,
        success: function(data) {
            data = JSON.parse(data);
            $('#editingHiddenRow').val(rowID);
            $('#editISBN').val(data['ISBN']);
            $('#editBookTitle').val(data['title']);
            $('#editBookDescription').val(data['description']);
            $('#editBookAuthors').val(data['Authors']);
            $('#editBookPublisher').val(data['Publishers']);
            $('#editBookImage').attr('src', data['cover']);
            $('#editBookYear').val(data['year']);
            $('#editBookPages').val(data['pages']);
            $('#editBookLocation').val(data['LocationID']);
            $('#editBookTags').val(data['Tags']);
            $('#editBookCopies').val(data['copies']);
            $('#editBookCost').val(data['originalCost']);
            $('#modEditBook').modal('show');
        }
    });
}



function uploadFile (filename) {
    let file = filename[0];
    let formData = new FormData();
    formData.append("customFile", file);
    let ajax = new XMLHttpRequest();
    
    let isbnList;

    ajax.onreadystatechange = function() {
        if (ajax.readyState == XMLHttpRequest.DONE) {
            isbnList = JSON.parse(ajax.response);
            var isbnCount = 0;
            uploadISBNList(isbnList);
        }
    }
    ajax.open("POST", "../php/upload.php");
    ajax.send(formData);    
}

function uploadISBNList(isbnArray) {
    var errorText = '';
    var isbnCount = 0;
    var errorCount = 0;
    var isbnLength = isbnArray.length;
    isbnArray.map(function(item) {
        let dataToPost = {ISBN: item[0], LocationID: item[1]};
        $.ajax ({
            url: "../php/bulkLookupISBN.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                if (data=='success'){
                    isbnCount++;
                    let messageHTML ="<div class='progress'><div class='progress-bar bg-info progress-bar-striped progress-bar-animated' style='width:" + parseInt((errorCount+isbnCount)*100/isbnLength) +  "%'>" + (isbnCount+errorCount) + " of " + isbnLength + " books reviewed</div></div>";

                    $('#messageCentre').html(messageHTML);
                    if (isbnLength == (isbnCount+errorCount)) {
                        var messageString = "<div class='alert alert-success'>";
                        if (isbnCount!=0) {
                            if (isbnCount==1) {
                                messageString += "Import complete. " + isbnCount + " book imported successfully.<br>";
                            } else {
                                messageString += "Import complete. " + isbnCount + " books imported successfully.<br>";
                            }
                            messageString +="</div>";
                        }
                        if (errorCount!=0) {
                            messageString += "<div class='alert alert-danger'>";
                            if (errorCount==1) {
                                messageString += "<strong>" + errorCount + " item could not be imported due to the following errors</strong><br><br>" + errorText;
                            } else {
                                messageString += "<strong>" + errorCount + " items could not be imported due to the following errors</strong><br><br>" + errorText;
                            }
                            messageString +="</div>";
                        }
                       $('#messageCentre').html(messageString);
                       setTimeout( function() {
                            $('#messageCentre').html('');
                        },5000);
                        $.when(updateBookList()).done(function(bookList) {
                            $('#bookList').html(bookList);
                        });        
                    }
                } else {
                    errorText += data + "</br>";
                    errorCount++;
                }  
            }
        });
    });
   
}
      
function checkJSON (jsonObject) {
    try {
        JSON.parse(jsonObject);
        return 'json';
    }
    catch (e) {
        return 'string';
    }
}

function updateBookList() {
    return $.ajax ({
            url: "../php/updateBookList_nonfunc.php",
            type: "POST",
            success: function(bookList) {
                return bookList;
            }
        })
    }

function setDarkMode(colMode) {
    if (colMode==true) {
        $("body").addClass("dark");
        $('.headerImage').attr('src', '../images/bookstack_dark.jpeg');
    } else {
        $("body").removeClass("dark");
        $('.headerImage').attr('src', '../images/bookstack.jpeg');
    } 
    $("#books").DataTable().draw();
}




