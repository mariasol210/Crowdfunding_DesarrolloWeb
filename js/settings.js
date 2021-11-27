function load_pic(){
    let url_nueva = document.getElementById("pic_url").value;

    let elemento_img = document.querySelector(".profile_pic");

    if(url_nueva.endsWith(".png")||url_nueva.endsWith(".jpg")||url_nueva.endsWith(".jpeg")){
        elemento_img.src=url_nueva;
        $('.close').click();
    }
    else {
        console.log("slfdd")
    }
}