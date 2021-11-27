$(document).ready(function() {

    document.querySelector("#name").disabled="True";
    document.querySelector("#email").disabled="True";


});


function load_pic(){
    let url_nueva = document.getElementById("pic_url").value;

    let elemento_img = document.querySelector(".profile_pic");

    if(url_nueva.endsWith(".png")||url_nueva.endsWith(".jpg")||url_nueva.endsWith(".jpeg")){
        elemento_img.src=url_nueva;
        $('.close').click();
    }
    else {
        console.log("Not the right format")
    }
}

function change_name(){
    if(document.querySelector("#name").disabled=="True"){
        document.querySelector("#name").disabled="False";
        document.querySelector(".boton_nombre").value="Guardar";
    }
    else{
        //save data
        document.querySelector("#name").disabled="True";
    }
}

function change_mail(){
    if(document.querySelector("#email").disabled=="True"){
        document.querySelector("#email").disabled="False";
        document.querySelector(".boton_email").value="Guardar";
    }
    else{
        //save data
        document.querySelector("#email").disabled="True";
    }
}

function save_pass(){
    //check if current password matches

    if(document.querySelector("#new_password").value==document.querySelector("#password_confirmation").value){
        //change passwords
    }
    else{
        //save data
        console.log("Both passwords must match")
    }
}