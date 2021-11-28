

$(document).ready(function() {
  
    //The sign up form will be hidden by default
    $('#signUpModalContent').hide(); 
    $('#forgotPassContent').hide(); 

    //Hide the profile dropdown by default
    $(".profile_dropdown").hide();

    //The sign up button will hide the sign in content and show the sign up form
    $(".signUpButton").click(function() {
        $('#signInModalContent').hide(); 
        $('#forgotPassContent').hide(); 
        $(".modal-title" ).text( "Registrate" );
        $('#signUpModalContent').show();
    });
    //The sign in button will hide the sign up form and show the sign in content
    $(".signInButton").click(function() {
        $('#signUpModalContent').hide(); 
        $('#forgotPassContent').hide(); 
        $(".modal-title" ).text( "Inicia sesión en tu cuenta" );
        $('#signInModalContent').show();
    });

    $("#forgotPassButton").click(function() {
        $('#signUpModalContent').hide(); 
        $('#signInModalContent').hide(); 
        $(".modal-title" ).text( "Restablece la contraseña" );
        $('#forgotPassContent').show();
    })

});

function getURL() {
    document.getElementById("copiedMessage").innerHTML = ""
    let linkfield = document.getElementById("clipboardLink");
    linkfield.value= window.location.href ;
}

function copyURLtoClipboard() {
    /* Get the text field */
    let copyText = document.getElementById("clipboardLink");
  
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
  
     /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);
  
    /* Alert the copied text */
    document.getElementById("copiedMessage").innerHTML = "¡Copiado!"
}

$('.search-bar').on('keydown', function(evt) {
    // If enter is pressed and the value isn't empty
    if(evt.keyCode == 13 && $(this).val() != ''){
        search($(this).val());
        $(this).val('');
    }
} );

$('.btn_ver_mas').click(function(evt) {
    // Get category
    $categoria = "para ti";
    search($categoria);
} ); 

function search(val){
    //TODO search in db
    console.log(val);
    window.location.href = "filtrado.html";
}

//TODO fix
$('#signInButtonInModal').click(function(){
    //TODO check in db
    //TODO once checked in, get a variable which will be used to load
    //the profile dropdown on top of the screen
    $('.signInButton').hide();
    $('.profile_dropdown').show();
    $('.close').click();
});

$('.log_out').on('click', function(){
    //TODO
    $('.signInButton').show();
    $('.profile_dropdown').hide();
})

//Funciones temporales hasta implementar php
$('#editar').click(function() {
    window.location.href = "edit_project.html";
});

$('#create_project_btn').click(function() {
    window.location.href = "your_projects.html";
});

$('#edit_project_btn').click(function() {
    window.location.href = "your_projects.html";
});




