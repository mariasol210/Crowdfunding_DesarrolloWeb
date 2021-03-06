

$(document).ready(function() {
  
    //The sign up form will be hidden by default
    $('#signUpModalContent').hide(); 
    $('#forgotPassContent').hide(); 

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

    //Open again the modal if the sign in was unsuccesful
    if(document.body.contains(document.getElementById('errorSignIn'))){
        $('#signIn').click();
    }

    //Open again the modal if the sign up was unsuccesful
    if(document.body.contains(document.getElementById('errorSignUp'))){
        $('#signIn').click();
        $(".signUpButton").click();
    }
});

function getURL() {
    document.getElementById("copiedMessage").innerHTML = ""
    let linkfield = document.getElementById("clipboardLink");
    linkfield.value= window.location.href ;
};

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
};

$('.search-bar').on('keydown', function(evt) {
    // If enter is pressed and the value isn't empty
    if(evt.keyCode == 13 && $(this).val() != ''){
        search($(this).val());
        $(this).val('');
    }
} );

function search(val){
    //TODO search in db
    console.log(val);
    window.location.href = "./filtrado.php?q="+val;
};

