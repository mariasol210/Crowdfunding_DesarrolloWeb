<?php
    include "dbConn.php"; 
    session_start();
  $tablename= "projects";
  $error_category = "";
  $error_money = "";
  $error_date =  "";
  $error_file = "";
  $allowed_file = array('gif', 'png', 'jpg', 'jpeg');
  // Attemp to do the insertion
  if (isset($_POST['create_project'])) {
    $project_title = htmlspecialchars($_POST['project_title'], ENT_QUOTES);
    $money_goal = $_POST['money_goal'];
    $end_date = new Datetime($_POST['end_date']);
    $end_date = date_format($end_date,"Y-m-d");
    $project_sub = htmlspecialchars($_POST['project_sub'], ENT_QUOTES);
    $project_info = htmlspecialchars($_POST['project_info'], ENT_QUOTES);
    $science = 0;
    $tech = 0;
    $eng = 0;
    $art = 0;
    $math = 0;

    $var1 = rand(1111,9999);  // generate random number in $var1 variable
    $var2 = rand(1111,9999);  // generate random number in $var2 variable
	
    $var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
    $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

    $fnm = $_FILES["project_pic"]["name"];    // get the image name in $fnm variable
    $dst = "./media/projects_pics/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
    $dst_db = "media/projects_pics/".$var3.$fnm; // storing image path into the database with 32 characters hex number and file name

    
    if (isset($_POST['science']) && $_POST['science'] == 'on') {$science = 1; }
    if (isset($_POST['tech']) && $_POST['tech'] == 'on') {$tech = 1; }
    if (isset($_POST['eng']) && $_POST['eng'] == 'on') {$eng = 1; }
    if (isset($_POST['art']) && $_POST['art'] == 'on') {$art = 1; }
    if (isset($_POST['math']) && $_POST['math'] == 'on') {$math = 1; }

        // check validity
        $valid_category = $science + $tech + $eng + $art + $math >=1;
        $valid_goal = is_numeric($money_goal) && $money_goal > 0 ;
        $valid_date = $end_date > date('Y-m-d');
        $ext = pathinfo($fnm, PATHINFO_EXTENSION);
        $valid_file = in_array($ext, $allowed_file);
        if ($valid_category && $valid_goal && $valid_date && $valid_file) {
                
                $sql = "INSERT INTO " . $tablename . "(`title`, `subtitle`, `organizer_id`, `start_date`, `end_date`, `description`, `picture`,`moneyGoal`, `science`, `tech`, `eng`, `art`, `math`) 
                VALUES ('".$project_title."', '".$project_sub."', '".$_SESSION['user_id']."', current_timestamp(), '".$end_date." 23:59:59', '".$project_info."','".$dst_db."' , '".$money_goal."','".$science."', '".$tech."', '".$eng."', '".$art."', '".$math."')";
        
                if (mysqli_query($connection, $sql)) {
                    move_uploaded_file($_FILES["project_pic"]["tmp_name"],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name
                    header('Location: your_projects.php');} 
                else { echo "Error: " . $sql . "<br>" . mysqli_error($connection); }
        }
        else { 
            if(!$valid_goal) {$error_money = "<div class='alert alert-danger' role='alert'> La cantidad debe ser un número mayor a 0. </div>";}
            if (!$valid_date) {$error_date = "<div class='alert alert-danger' role='alert'> La fecha debe ser posterior a la fecha actual. </div>";}
            if(!$valid_category) {$error_category = "<div class='alert alert-danger' role='alert'> Es necesario escoger al menos 1 categoría </div>"; }
            if(!$valid_file) {$error_file = "<div class='alert alert-danger' role='alert'> El archivo escogido no es válido </div>"; }
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

    <!-- Crear proyecto -->
    <div class="container project_header mt-5 ">
        <h1>Crea un proyecto</h1>
        <h2>Empieza tu campaña de recaudación para convertir tu proyecto en realidad.</h2>
        <div class="row mt-2 mx-5">
            <div class="col bg-light">
                <form id="create_project_form" action="#" method="POST" enctype="multipart/form-data">
                    <!--Informacion básica del proyecto (lugar, categoria, titulo) -->
                    <h3 class="mt-3"> <b>Información Básica</b> </h3>
                   
                    <p>Escoge la categoría o categorías de tu proyecto</p>
                    <?php if($error_category != "") {echo $error_category;} ?> 
                    <div class="form-group ml-4">
                        <input class="form-check-input" type="checkbox" name="science" id="cb_science">
                        <label class="form-check-label" for="cb_science">Science</label>
                    </div>

                    <div class="form-group  ml-4">
                        <input class="form-check-input" type="checkbox" name="tech" id="cb_tech">
                        <label class="form-check-label" for="cb_tech">Technology</label>
                    </div>

                    <div class="form-group  ml-4">
                        <input class="form-check-input" type="checkbox" name="eng" id="cb_engineering">
                        <label class="form-check-label" for="cb_engineering">Engineering</label>
                    </div>

                    <div class="form-group  ml-4">
                        <input class="form-check-input" type="checkbox"  name="art" id="cb_arts">
                        <label class="form-check-label" for="cb_arts">Arts</label>
                    </div>

                    <div class="form-group  ml-4">
                        <input class="form-check-input" type="checkbox" name="math" id="cb_math">
                        <label class="form-check-label" for="cb_math">Mathematics</label>
                    </div>
                   
                    <div class="form-group">
                        <label for="title">¿Cuál es título de tu proyecto? </label>
                        <input type="text" class="form-control" name="project_title" id="title" placeholder="Ej. El juego para niños que les hará amar las matemáticas " required>
                        <small id="title_help" class="form-text text-muted"> Trata de incluir la categoria a la que pertence y el propósito </small>
                    </div>

                    <!--Meta de recaudación -->
                    <h3 class="mt-4"> <b>Meta de la recaudación </b>  </h3>     
                    <?php if($error_money != "") {echo $error_money;} ?> 
                    <div class="form-group">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend"> <span class="input-group-text">€</span> </div>
                            <input type="text" name="money_goal" id="goal" maxlength="5" inputmode="numeric" class="form-control form-control-lg" aria-label="Inserta la cantidad meta"
                            style="text-align: right;" required>
                            <div class="input-group-append"> <span class="input-group-text">.00</span></div>
                        </div>
                        <small id="title_help" class="form-text text-muted"> 
                            Ten en cuenta que las tarifas de transacción, incluyendo los cargos de tarjetas de crédito y debito, 
                            son deducidos de cada donación.
                        </small>
                    </div>

                    <!--Fecha limite de proyecto -->
                    <h3> <b> Fecha límite de recaudación</b> </h3>
                    <?php if($error_date != "") {echo $error_date;} ?> 
                    <div class="form-group">
                        <label for="startDate">Final</label>
                        <input id="startDate" name="end_date" class="form-control" type="date" required />
                    </div>
                    
                    <!--Subir foto de portada -->
                    <h3 class="mt-4"> <b> Añadir foto de portada</b> </h3>
                    <p> Una imagen de alta calidad ayudará a describir tu proyecto e inspirar confianza con los donantes  </p>
                    <?php if($error_file != "") {echo $error_file;} ?> 
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Sube una imagen de tu ordenador</label>
                        <input type="file" name="project_pic" class="form-control-file" accept=".png,.gif,.jpg,.webp" id="exampleFormControlFile1" required>
                    </div>

                    <!--Describir el proyecto (subtitulo y cuerpo) -->
                    <h3 class="mt-4"><b>Describe el proyecto</b> </h3>
                    <div class="form-group">
                        <label for="subtitle">Subtitulo del proyecto</label>
                        <textarea class="form-control" name="project_sub" id="subtitle" rows="3" placeholder="Describe brevemente el proyecto " maxlength="200" required><?php if(isset($_POST['project_sub'])) {echo $_POST['project_sub']; unset($_POST['project_sub']);} ?> </textarea>
                    </div>

                    <div class="form-group">
                        <label for="project_info">Información del proyecto</label>
                        <textarea class="form-control" name="project_info" id="project_info" rows="12" required> <?php if(isset($_POST['project_info'])) {echo $_POST['project_info']; unset($_POST['project_info']);} ?></textarea>
                    </div>
                    <div class="text-center my-2"><button  name="create_project" type="submit" value="submit" class="btn bgPurple px-5">Crear proyecto</button></div>
                   
                    <div class="p-2 text-center small m">Al continuar, aceptas las <a class="link" href="#">condiciones</a> y la <a class="link" href="#">declaración de privacidad </a> de Project STEAM.</div>
                </form>

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