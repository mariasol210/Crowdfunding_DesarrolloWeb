<?php
    include "dbConn.php";   
    session_start();
    $error_pass="";
    $error_acc="";
    $error_file="";
    $error_name="";
    $error_mail="";
    $allowed_file = array('gif', 'png', 'jpg', 'jpeg');

    //change profile pic
    if(isset($_POST['profilePicChange'])){
        $var1 = rand(1111,9999);  // generate random number in $var1 variable
        $var2 = rand(1111,9999);  // generate random number in $var2 variable
	
        $var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
        $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

        $fnm = $_FILES["upload_profile_pic"]["name"];    // get the image name in $fnm variable
        $dst = "./media/users_pp/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
        $dst_db = "media/users_pp/".$var3.$fnm; // storing image path into the database with 32 characters hex number and file name
        
        $ext = pathinfo($fnm, PATHINFO_EXTENSION);
        $valid_file = in_array($ext, $allowed_file);

        if ($valid_file) {
                
            $sql = "UPDATE `users` SET `profile_pic` = '".$dst_db."' WHERE id_user=" . $_SESSION['user_id'];
    
            if (mysqli_query($connection, $sql)) {
                move_uploaded_file($_FILES["upload_profile_pic"]["tmp_name"],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name
                $_SESSION['profile_pic'] = $dst_db;
            }
            else { echo "Error: " . $sql . "<br>" . mysqli_error($connection); }
        }
        else {$error_file = "<div class='alert alert-danger' role='alert'> El archivo escogido no es válido </div>"; }
    }
    
    //change name
    if(isset($_POST['btnNameChange'])){
        //check that the name in the field is different
        if($_SESSION['name']!=$_POST['new_name']){
            $sql = "UPDATE `users` SET `name` = '".$_POST['new_name']."' WHERE id_user=" . $_SESSION['user_id'];

            if (mysqli_query($connection, $sql)) {
                $error_name = "<div class='alert alert-success' role='alert'> Nombre cambiado correctamente. </div>";
                $_SESSION['name'] = $_POST['new_name'];
            }
            else {$error_name = "<div class='alert alert-danger' role='alert'> Se ha producido un error. </div>";}
        }
        else{
            $error_name = "<div class='alert alert-warning' role='alert'> No hay nada que cambiar. </div>";
        }
    }

    //change mail
    if(isset($_POST['btnMailChange'])){
        //check that the mail in the field is different
        if($_SESSION['email']!=$_POST['new_email']){
            $sql = "UPDATE `users` SET `email` = '".$_POST['new_email']."' WHERE id_user=" . $_SESSION['user_id'];

            if (mysqli_query($connection, $sql)) {
                $error_mail = "<div class='alert alert-success' role='alert'> Correo cambiado correctamente. </div>";
                $_SESSION['email'] = $_POST['new_email'];
            }
            else {$error_mail = "<div class='alert alert-danger' role='alert'> Error. Este correo ya existe. </div>";}
        }
        else{
            $error_mail = "<div class='alert alert-warning' role='alert'> No hay nada que cambiar. </div>";
        }

    }

    //change password
    if(isset($_POST['btnPassChange'])){
        //get user's password
        $sql = "SELECT `password` FROM `users` WHERE id_user=" . $_SESSION['user_id'];
        $result = mysqli_query($connection, $sql);
        $user_pass = "";

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $user_pass=$row['password'];
            }
        }

        //validation
        if(password_verify($_POST['current_password'], $user_pass) && $_POST['new_password']==$_POST['password_confirmation']){
            //update
            $pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT, [15]);

            $sql = "UPDATE `users` SET `password` = '".$pass."' WHERE `id_user`= ".$_SESSION['user_id'];

            if(mysqli_query($connection, $sql)){
                $error_pass = "<div class='alert alert-success' id='errorDeletion' role='alert'> Contraseña cambiada con éxito. </div>";
            }
            else{
                $error_pass = "<div class='alert alert-danger' id='errorDeletion' role='alert'> No se ha podido cambiar la contraseña. </div>";
            }

        }
        else{
            $error_pass = "<div class='alert alert-danger' id='errorDeletion' role='alert'> Comprueba los campos. </div>";
        }

    }


    //delete account
    if(isset($_POST['deleteAccount'])) {
        
        $sql = "UPDATE `users` SET `active` = 0 WHERE `users`.`id_user` = ".$_SESSION['user_id'];
        if(!mysqli_query($connection, $sql)){
            $error_acc = "<div class='alert alert-danger' id='errorDeletion' role='alert'> Error. No se ha podido eliminar la cuenta. </div>";
        }
        else{
            header('Location: logout.php');
        }
    }
    // 5. Close database connection
    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Project STEAM</title>
    <meta charset="utf-8" />
    <meta name="authors" content="Maria Sol Torres L & Teodora Nikolaeva" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="css/style.css" rel="stylesheet" />

</head>

<body>
    <!-- Top container -->
    <?php include "top_bar.php"?>

    <!-- Settings content-->
    <div class="container text-center project_header mt-5 pb-0">
        <h1>Tu cuenta:</h1>
    </div>

    <div class="container-fluid content settings pt-0" style="width:70%;">
        <!-- Profile picture-->
        <div class="row">
            <div class="col-md-12 pl-0">
                <h1>Foto de perfil</h1>
            </div>
        </div>
        <div class="row">
            <div class="text-center">
                <div class="profile_pic_container">
                    <?php if ($_SESSION['profile_pic'] == '') {$pp = 'media/profile_pic.png';}
                    else {$pp = $_SESSION['profile_pic'];}?>
                    <img class="profile_pic" src="<?php echo $pp?>">
                </div>
            </div>
            <div>
                <button type="submit" class="btn bgPurple text-center" data-toggle="modal"
                    data-target="#uploadPicModal">
                    Subir foto
                </button>
            </div>
        </div>
        <!--Name-->
        <div class="row">
            <div class="col-md-12 pl-0">
                <h1>Nombre</h1>
            </div>
        </div>
        <div class="row">
            <p>Tu nombre sirve para presentarte ante el resto de usuarios. Recomendamos no cambiarlo con frecuencia.</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form id="nameChange" action="#" method="POST">
                <input type="text" class="form-control" name="new_name" value ="<?php echo $_SESSION['name'];?>">
                </form>
            </div>
            <div>
                <button type="submit" form="nameChange" class="btn bgPurple text-center boton_nombre" name="btnNameChange">
                    Editar
                </button>
            </div>
        </div>
        <?php echo $error_name?>
        <!-- Email -->
        <div class="row">
            <div class="col-md-12 pl-0">
                <h1>Correo electrónico</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form id="mailChange" action="#" method="POST">
                <input type="text" class="form-control" name="new_email" value ="<?php echo $_SESSION['email'];?>">
                </form>
            </div>
            <div>
                <button type="submit" form="mailChange" class="btn bgPurple text-center boton_email" name="btnMailChange">
                    Editar
                </button>
            </div>
        </div>
        <?php echo $error_mail?>
        <!-- Password-->
        <div class="row">
            <div class="col-md-12 pl-0">
                <h1>Contraseña</h1>
            </div>
        </div>
        <div class="row">
            <p>Para cambiar la contraseña deberás proporcionar tu contraseña actual. Si la has olvidado, cierra sesión y
                reestablécela.</p>
        </div>
        <div class="row"> 
            <div class="col-md-4">
                <form id="passChange" action="#" method="POST">
                <input type="password" class="form-control" name="current_password" placeholder="Contraseña actual">
                <input type="password" class="form-control" name="new_password" placeholder="Nueva contraseña">
                <input type="password" class="form-control" name="password_confirmation"
                    placeholder="Confirme la nueva contraseña">
                </form>
            </div>
            <div>
                <button type="submit" form="passChange" class="btn bgPurple text-center boton_pass" name="btnPassChange">
                    Cambiar contraseña
                </button>
            </div>
        </div>
        <?php echo $error_pass?>
        <!-- Delete profile-->
        <div class="row">
            <div class="col-md-12 pl-0">
                <h1>Eliminar cuenta</h1>
            </div>
        </div>
        <div class="row">
            <p>Esta acción es irreversible. Se eliminarán todos tus datos y proyectos, y no podrás volver a iniciar
                sesión con la misma cuenta.</p>
        </div>
        <div class="row">
            <form action="#" method ="POST" style="margin-right: auto; margin-left: auto;">
            <button type="submit" class="btn bgRed" name="deleteAccount">
                Eliminar cuenta
            </button>
            </form> 
        </div>
        <?php echo $error_acc?>
    </div>

    <!-- Modal to uploadPic-->
    <div class="modal fade" id="uploadPicModal" tabindex="-1" role="dialog" aria-labelledby="uploadPicLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="signInHeader">
                    <h1>Editar imagen de perfil</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="row">
                        <label for="pic_url">Selecciona un archivo de tu ordenador</label>
                    </div>
                    <div class="row pic_url_container">
                        <div class="col-md-12 pl-0">
                        <form action="#" id="changePic" method="POST" enctype="multipart/form-data">
                        <input type="file" name="upload_profile_pic" class="form-control-file" accept=".png,.gif,.jpg,.webp" required>
                        </form>
                        </div>
                    </div>
                    <div class="row" style="min-height:1rem;">
                        <?php if($error_file != "") {echo $error_file;} ?>
                    </div>
                    <div class="row mt-1 mb-1" style="height:1rem;">
                        <hr width=100%>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn bgPurple" form="changePic" name="profilePicChange">
                                Cargar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer-->
    <footer class="row footer_container">
        <div class="col-md-3 footer_columna">
            <img class="img-fluid logo" src="media/logo_multicolor.png" />
        </div>
        <div class="col-md-6 footer_columna">
            <a href="#">Atención al cliente</a>
            <a href="#">Términos y condiciones</a>
            <a href="#">Contacto</a>
        </div>
        <div class="col-md-3 footer_columna">
            <div class="dropdown show">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Idioma
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Inglés</a>
                    <a class="dropdown-item" href="#">Francés</a>
                    <a class="dropdown-item" href="#">Español</a>
                </div>
            </div>
            <div class="dropdown show">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Moneda
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Libra</a>
                    <a class="dropdown-item" href="#">Euro</a>
                    <a class="dropdown-item" href="#">Dólar</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="js/projectSteam.js"></script>
</body>

</html>