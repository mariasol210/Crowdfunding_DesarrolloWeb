$(document).ready(function() {
   
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

    //The sign up form will be hidden by default
    $('#signUpModalContent').hide(); 
    $('#forgotPassContent').hide(); 
});




