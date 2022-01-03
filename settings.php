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
                    <img class="profile_pic" src="media/profile_pic.png">
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
                <input type="text" class="form-control" id="name">
            </div>
            <div>
                <button type="submit" class="btn bgPurple text-center boton_nombre" onclick="change_name()">
                    Editar
                </button>
            </div>
        </div>
        <!-- Email -->
        <div class="row">
            <div class="col-md-12 pl-0">
                <h1>Correo electrónico</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" id="email">
            </div>
            <div>
                <button type="submit" class="btn bgPurple text-center boton_email" onclick="change_mail()">
                    Editar
                </button>
            </div>
        </div>
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
                <input type="password" class="form-control" id="current_password" placeholder="Contraseña actual">
                <input type="password" class="form-control" id="new_password" placeholder="Nueva contraseña">
                <input type="password" class="form-control" id="password_confirmation"
                    placeholder="Confirme la nueva contraseña">
            </div>
            <div>
                <button type="submit" class="btn bgPurple text-center boton_pass" onclick="save_pass()">
                    Cambiar contraseña
                </button>
            </div>
        </div>
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
            <button class="btn bgRed" style="margin-right: auto; margin-left: auto;">
                Eliminar cuenta
            </button>
        </div>
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
                <div class="modal-body">
                    <div class="row">
                        <label for="pic_url">Inserta el enlace a una imagen de internet</label>
                    </div>
                    <div class="row pic_url_container">
                        <input id="pic_url" class="col-md-12 form-control" type="text" placeholder="Añade tu url...">
                    </div>
                    <div class="row">
                        <button type="submit" class="btn bgPurple" id="load_pic" onclick="load_pic()">
                            Cargar
                        </button>
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
    <script src="js/settings.js"></script>
</body>

</html>