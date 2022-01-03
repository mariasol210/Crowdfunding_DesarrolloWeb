<?php 
include "dbConn.php";
$error_signin = "";

// Sign in
if (isset($_POST['sign_in'])) {
  $email = $_POST['email'];
  $pass = $_POST['pass'];

  $sql = "SELECT * FROM `users` WHERE email='" . $email . "'";
  $result = mysqli_query($connection, $sql);

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if(password_verify($pass, $row['password'])){
        $_SESSION['user_id'] = $row['id_user'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['profile_pic'] = $row['profile_pic'];
        unset($_POST['sign_in']);
      }
      
    }
  } else {
    $error_signin = "<div class='alert alert-danger' id='errorSignIn' role='alert'> Correo electrónico o contraseña incorrecta. Intentelo de nuevo </div>";
  }
}

$error_signup = "";
// Sign up
if(isset($_POST['sign_up'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT, [15]);
  //INSERT new user
  $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES('".$name."', '".$email."', '".$pass."')";

  if (mysqli_query($connection, $sql)) {
    //IF it is succesful store the info for the session
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    
    //Then recover the user id to store in the session
    $sql = "SELECT id_user FROM `users` WHERE email='" . $email . "'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_id'] = $row['id_user'];
        $_SESSION['profile_pic'] = '';
        unset($_POST['sign_up']);
      }
    } 
  } 
  else {$error_signup = "<div class='alert alert-danger' id='errorSignUp' role='alert'> Error. Correo ya registrado. </div>"; }
}

// 5. Close database connection
mysqli_close($connection);

?>

<!-- Top container -->
<div class="container-fluid" id="top_bar">
    <div class="top_bar">
      <div style="margin-block: auto">
        <h1>Project STEAM</h1>
        <h2>Only the begining</h2>
      </div>
      <a class="logo"href="index.php"><img class="img-fluid logo " src="media/logo_multicolor.png" /></a>
      <div id="top_buttons">
        <button type="button" class="btn search_button" data-toggle="modal" data-target="#searchModal">
          <img src="media/search.png" style="width: 24px" />
        </button>
        <!-- Button trigger modal -->
        <button type="button" id="signIn" class="btn bgPurple signInButton" <?php if(isset($_SESSION['user_id'])) {echo 'style="display: none"';}?>
        data-toggle="modal" data-target="#signInModal" >
          Iniciar sesión
        </button>
        <div class="dropdown show" <?php if(!isset($_SESSION['user_id'])) {echo 'style="display: none"';} else{echo 'style=""';}?>>
          <a class="btn dropdown-toggle profile_dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <?php if ($_SESSION['profile_pic'] == '') {$pp = 'media/profile_pic.png';}
                else {$pp = $_SESSION['profile_pic'];}?>
              <img class="img-fluid pr-1 profile_pic" src="<?php echo $pp?>" style="width: 24px; border-radius: 50%">
              <span class="profile_name"><?php if(isset($_SESSION['user_id'])) {echo $_SESSION['name'];}?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="your_projects.php">
                  <img class="img-fluid mr-1 pb-1" src="media/your_projects.png" style="width:20px">
                  Tus proyectos
              </a>
              <a class="dropdown-item" href="add_project.php">
                  <img class="img-fluid mr-1 pb-1" src="media/add_project.png" style="width:20px">
                  Publicar proyecto
              </a>
              <a class="dropdown-item" href="your_donations.php">
                  <img class="img-fluid mr-1 pb-1" src="media/your_donations.png" style="width:20px">
                  Tus donativos
              </a>
              <a class="dropdown-item" href="settings.php">
                  <img class="img-fluid mr-1 pb-1" src="media/settings.png" style="width:20px">
                  Configuración
              </a>
              <a class="dropdown-item log_out" href="logout.php">
                  <img class="img-fluid mr-1 pb-1" src="media/log_out.png" style="width:20px">
                  Cerrar sesión
              </a>
          </div>
      </div>
      </div>
    </div>
</div>

<!-- Modal to sign in-->
<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="SignInModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" id="signInHeader">
          <h5 class="modal-title">Inicia sesión en tu cuenta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <!--Sign in content-->
              <div class="col-sm" id="signInModalContent">
                <div class="row">
                  <div class="col-sm-6 col-sm-12">
                    <button type="button" class="btn btn-light socialMediaButton" style="text-align: left">
                      <span><img src="media/igoogle.png" id="socialMediaIcons" /></span>
                      Inicia sesión con Google
                    </button>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn btn-light socialMediaButton">
                      <span><img src="media/ifacebook.png" id="socialMediaIcons" /></span>
                      Inicia sesión con Facebook
                    </button>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn btn-light socialMediaButton">
                      <span><img src="media/iapple.png" id="socialMediaIcons" /></span>
                      Inicia sesión con Apple
                    </button>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm">
                    <hr />
                  </div>
                  <div class="col-sm-1">o</div>
                  <div class="col-sm">
                    <hr />
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <!-- Sign in form -->
                    <form id="sign_in_form" action="#" method="POST">
                    <?php if($error_signin != "") {echo $error_signin;} ?> 
                      <div class="form-group">
                        <label for="Email1">Correo electrónico</label>
                        <input type="email" class="form-control" id="Email1" name="email" aria-describedby="emailHelp"
                          placeholder="Enter email" required/>
                        <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu correo con nadie
                          más.</small>
                      </div>
                      <div class="form-group">
                        <label for="Password1">Contraseña</label>
                        <input type="password" class="form-control" id="Password1" name="pass" placeholder="Password" required />
                      </div>
                      <button type="submit" class="btn bgPurple btn-lg btn-block" value="submit" id="signInButtonInModal" name="sign_in" style="margin-bottom: 5%">
                        Iniciar sesión
                      </button>
                    </form>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <p class="link" id="forgotPassButton">
                      <small class="text-left">
                        ¿Has olvidado tu contraseña?</small>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <small class="text-left">
                      <span>¿Es tu primera vez en Project STEAM? </span>
                      <button type="button" class="btn btn-light btn-sm signUpButton">
                        Regístrate
                      </button>
                    </small>
                  </div>
                </div>
              </div>
              <!--Sign up form-->
              <div class="col-sm" id="signUpModalContent">
                <div class="row">
                  <div class="col">
                    <form id="sign_up_form" action="#" method="POST">
                    <?php if($error_signup != "") {echo $error_signup;} ?> 
                      <div class="form-group">
                        <label for="user">Nombre</label>
                        <input type="text" class="form-control" id="user" name= "name" aria-describedby="nameHelp"
                          placeholder="John Doe" />
                      </div>
                      <div class="form-group">
                        <label for="Email2">Correo electrónico</label>
                        <input type="email" class="form-control" id="Email2" name="email" aria-describedby="emailHelp"
                          placeholder="name@workemail.com" />
                        <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu correo con nadie
                          más.</small>
                      </div>
                      <div class="form-group">
                        <label for="newPassword2">Contraseña</label>
                        <input type="password" class="form-control" id="newPassword2" name="pass" aria-describedby="passwordHelp"
                          placeholder="Contraseña" />
                        <small id="passwordHelp" class="form-text text-muted">Usa 8 o más caracteres y combina letras,
                          números y
                          símbolos..</small>
                      </div>
                      <button type="submit" class="btn bgPurple btn-lg btn-block" name="sign_up" value="submit" style="margin-bottom: 5%">
                        Crear cuenta
                      </button>
                    </form>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <p>
                      <small class="text-left">
                        Al continuar, estás aceptando los
                        <span class="link">Términos y condiciones de uso</span>
                        (se abre en una ventana nueva). Consulta nuestra
                        <span class="link"> Política de privacidad</span> (se
                        abre en una ventana nueva).</small>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <small class="text-left">
                      <span>¿Ya te has registrado?</span>
                      <button type="button" class="btn btn-light btn-sm signInButton">
                        Inicia Sesión
                      </button>
                    </small>
                  </div>
                </div>
              </div>
              <!--Forgot password form-->
              <div class="col-sm" id="forgotPassContent">
                <div class="row">
                  <div class="col">
                    <p>
                      <small class="text-left">
                        No te preocupes. Te enviaremos un mensaje para
                        ayudarte a restablecer tu contraseña.</small>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <form>
                      <div class="form-group">
                        <label for="Email3">Correo electrónico</label>
                        <input type="email" class="form-control" id="Email3" aria-describedby="emailHelp"
                          placeholder="Enter email" />
                      </div>
                      <button type="submit" class="btn bgPurple btn-lg btn-block" style="margin-bottom: 5%">
                        Continuar
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 d-none d-lg-block">
                <img src="media/signInModal.jpeg" class="img-fluid" id="imgModal" alt="Project steam logo" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal to search-->
<div class = "modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="SearchModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" id="signInHeader">
          <img src="media/search.png" style="width: 26px; margin: auto auto 5px auto;">
          <input class="search-bar shadow-none" type="text" placeholder="Buscar..">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
  </div>