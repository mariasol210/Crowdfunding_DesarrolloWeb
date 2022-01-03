<?php
    include "dbConn.php";   
    session_start();
  $tablename= "donations";
  $error_money = "";
  $error_date = "";
  $project_id = $_GET['project_id'];

  $sql = "SELECT title, projects.picture, users.name AS name FROM `projects` INNER JOIN `users` ON projects.organizer_id=users.id_user WHERE id_project=" . $project_id;
  $result = mysqli_query($connection, $sql);
  $project_title = "";
  $project_organizer = "";

  //SELECT QUERY TO GET TITLE AND ORGANIZER
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      
      $project_title = $row['title'];
      $project_organizer = $row['name'];
      $project_pic = $row['picture'];
    }
  } else {
    echo "0 results";
  }
  
  // Attemp to do the insertion
  if (isset($_POST['donate_now'])) {
    $donation_input = $_POST['donation_input'];
    //La contribucion no se añade a la donacion, va a la pagina
    //$contribution_input = $_POST['contribution_input'];
    //$contribution_input = ($donation_input*$contribution_input) /100;
    // recover the cc info
    $cc_number = $_POST['cc_number'];
    $cc_ccv = $_POST['cc_cvv'];
    $cc_month = $_POST['cc_month'];
    $cc_year = $_POST['cc_year'];
    // Build the date to later compare
    $cc_date = $cc_year . '-' . $cc_month . '-01';
    $date = strtotime($cc_date); 
    $cc_date = date('Y-m-d', $date);
    $donor_name = $_SESSION['name'];
    $newsletter_subs = 0;
    if (isset($_POST['checkNoName']) && $_POST['checkNoName'] == 'on') {$donor_name = 'Anónimo'; }
    if (isset($_POST['checkReceiveMail']) && $_POST['checkReceiveMail'] == 'on') {$newsletter_subs = 1; }
        
      // validation
      $valid_money = is_numeric($donation_input) && $donation_input > 0 ;
      $valid_date = $cc_date > date('Y-m-d');
      if ($valid_money && $valid_date) {
                     
        $sql = "INSERT INTO " . $tablename . "(`donation`, `id_project`, `id_user`, `donor_name`) 
        VALUES ('".$donation_input."', '".$project_id."', '".$_SESSION['user_id']."', '".$donor_name."')"; 
        
        if (mysqli_query($connection, $sql)) {echo "New record created successfully"; header("location: proyectos.php?project_id=".$project_id);} 
        else { echo "Error: " . $sql . "<br>" . mysqli_error($connection); } 
      }
      else { 
        if(!$valid_money) {$error_money = "<div class='alert alert-danger' role='alert'> La cantidad debe ser un número mayor a 0. </div>";}
        if (!$valid_date) {$error_date = "<div class='alert alert-danger' role='alert'> La fecha de caducidad de la tarjeta debe ser posterior a la fecha actual. </div>";}
      }
    }

    // 5. Close database connection
    mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrocina a ProjectName</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Top container -->
    <?php include "top_bar.php"?>

  <div class="container-fluid container" id="project_donation">
    <div class="row project_payment" style="margin-top: 5%;">
        <div class="col bg-light">
            <!-- Go back button-->
            <div class="row mt-4">
                <div class="col">
                    <button class="btn border-dark "  onclick=" <?php echo 'location.href=\'proyectos.php?project_id='.$project_id.'\';';?>">
                        <span><img src="https://th.bing.com/th/id/R.29544a3340db9dc03301b695fcd352cd?rik=fVV6C43tVrgnPg&riu=http%3a%2f%2fpixsector.com%2fcache%2fa8009c95%2fav8a49a4f81c3318dc69d.png&ehk=lem5JWJPALCUYvcxVJXDyYyiOIuRHwdkyposar1mnvk%3d&risl=&pid=ImgRaw&r=0" style="height: 1rem;"></span> 
                        Volver al proyecto</button>
                </div>
            </div>
            
            <!-- donation summary -->
            <div class="row mt-3" >
                <div class="col-5 d-none d-md-block"> <img class="sponsor1_pic"src="<?php echo $project_pic?>" style="width: 100%;height: 100%;">
                </div>
                <div class="col"> 
                    <p>Estás apoyando <span class="project_name"><b> <?php echo $project_title?> </b> </span> </p>
                    <p>Tu donativo tendrá como beneficiario/a a <span class="autor"> <b> <?php echo $project_organizer?> </b> </span></p>
                </div>
            </div>

            <form id="donation_form" action="#" method="POST" >
              <!-- Money to donate to the project -->
              <p class="mt-4"><b>Indica el donativo </b></p>
              <?php if($error_money != "") {echo $error_money;} ?> 
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">€</span>
                  </div>
                  <input type="text" id="donation_input" name= "donation_input" maxlength="5" inputmode="numeric" class="form-control form-control-lg" aria-label="Amount (to the nearest dollar)"
                  style="text-align: right;">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>
              </div>

              <!-- Money to contribute to the page -->
              <div class="form-group mt-4 ">
                  <p><b>Aportación voluntaria a los servicios de GoFundMe </b> </p>
                  <p>Project STEAM aplica una comisión de la plataforma del 0 % a los organizadores. Project STEAM seguirá ofreciendo sus servicios gracias a una aportación opcional que harán los donantes aquí:</p>
                  
                      <p style="text-align: center;"><b><span id="demo"></b></span></p>
                      <div class="d-flex">
                          <div class="p-2"> 0%</div>
                          <div class="p-2 flex-grow-1" style=" width: 100%;">
                              <input type="range" class="form-range slider" min="0" max="30" step="5" id="contribution_input" name= "contribution_input"
                              data-bs-toggle="tooltip" data-bs-placement="top" title="15%">
                          </div>
                          <div class="p-2">30%</div>
                      </div>
                  
              </div>
              
              <div class="row"><div class="col"><hr /></div></div>

              <!-- Payment method -->
              
              <?php if($error_date != "") {echo $error_date;} ?> 
              <div class="form-group">
                  <div class="col"><span><b>Método de pago</b></span>
                      <ul class="nav nav-tabs" id="paymentTab" role="tablist">
                          <li class="nav-item" role="presentation"> <a class="nav-link active" id="visa-tab" data-toggle="tab" href="#visa" role="tab" aria-controls="visa" aria-selected="true"> <img src="media/ivisa.png" width="80"> </a> </li>
                          <li class="nav-item" role="presentation"> <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false"> <img src="media/ipaypal.png" width="80"> </a> </li>
                      </ul>
                      <div class="tab-content" id="paymentTabContent">
                          <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                              <div class="mt-4 mx-4">
                                  <div class="text-center"><h5>Tarjeta de credito</h5></div>
                                  <div class="form-group mt-3">
                                      <div class="inputbox"> <input type="email" name="email" class="form-control" required="required"> <span>Dirección de email</span> </div>
                                      <div class="d-flex flex-row">
                                          <div class="inputbox mr-4"> <input type="text" name="firstname" min="1" max="999" class="form-control" required="required"> <span>Nombre</span> </div>
                                          <div class="inputbox"> <input type="text" name="lastname" min="1" max="999" class="form-control" required="required"> <span>Apellidos</span> </div>
                                      </div>
                                      <div class="inputbox"> <input type="text" name="cardholder" class="form-control" required="required"> <span>Nombre del titular</span> </div>
                                      <div class="inputbox"> <input type="tel" inputmode="numeric" name="cc_number" pattern="[0-9\s]{13,19}" autocomplete="cc-number"  max="19" class="form-control" required="required" maxlength="19"> 
                                        <span>Número de tarjeta</span> <i class="fa fa-eye"></i> <p class="small"> Ej. xxxx xxxx xxxx xxxx </p></div>
                                      <div class="d-flex flex-row">      
                                          <div class="inputbox  mr-4"> <input type="text" inputmode="numeric" name="cc_month" pattern="[0-9]{2}" min="2" max="2" class="form-control" required="required" maxlength="2"> <span>Mes</span> <p class="small">Formato: MM</p></div>
                                          <div class="inputbox  mr-4"> <input type="text" inputmode="numeric" name="cc_year" pattern="[0-9]{4}" min="4" max="4" class="form-control" required="required" maxlength="4"> <span>Año</span> <p class="small">Formato: AAAA</p> </div>
                                          <div class="inputbox"> <input type="text" name="cc_cvv" pattern="[0-9]{3-4}" min="3" max="4" class="form-control" required="required" maxlength="4"> <span>CVV</span> </div>
                                      </div>
                                      
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                              <div class="px-5 mt-5">
                                  <div class="inputbox"> <input type="text" name="PP_email" class="form-control" DISABLED > <span>Correo de Paypal</span> 
                                  <p class="small"> Lo sentimos, esta función no está disponible todavía. </p> </div>
                                  
                              </div>
                          </div>
                      </div>
                      
                  </div>
              </div>
          
              <div class="row"><div class="col"><hr /></div></div>

              <!-- Donation optional data -->
              <div class="row">
                  <div class="col"><span><b>Datos del donativo (opcional)</b></span>
                      <div class="form-check mt-3">
                          <input class="form-check-input" type="checkbox" id="checkNoName" name="checkNoName">
                          <label class="form-check-label" for="flexCheckDefault">
                              No mostrar mi nombre públicamente en la recaudación de fondos.
                          </label>
                        </div>
                        <div class="form-check mt-3">
                          <input class="form-check-input" type="checkbox" id="checkReceiveMail" name="checkReceiveMail" checked>
                          <label class="form-check-label" for="flexCheckChecked">
                              Recibe de vez en cuando comunicaciones de marketing de GoFundMe. Puedes anular la suscripción en cualquier momento.
                          </label>
                        </div>
                  </div>
              </div>

              <div class="row"><div class="col"><hr /></div></div>

              <!-- total sidebar for small screens -->
              <div class="row d-lg-none d-md-none d-xl-none">
                  <div class="col"><span><b>Tu donativo</b></span>
                      
                      <div class="row mt-3">
                          <div class="col"><p>Tu donativo</p></div>
                          <div class="col-3"><p><span class="donativo">13,00</span>€</p></div>
                      </div>
                      <div class="row">
                          <div class="col"><p>Aportación para Project STEAM</p></div>
                          <div class="col-3"><p><span class="aportacion">1,95</span>€</p></div>
                      </div>
                      <div class="row"><div class="col"><hr /></div></div>
                      <div class="row" style="padding-bottom: 12px;">
                          <div class="col"><h3>Total</h3></div>
                          <div class="col-3"><p><span class="total">14,95</span>€</p></div>
                      </div>

                  </div>
              </div>

              <!-- PAY Button -->
              <div class="d-flex flex-column mb-3">
              <?php if(!isset($_SESSION['user_id'])){echo ' <div class="alert-danger text-center small">Debes iniciar sesión para hacer una donación</div>';}?>
                  <div class="p-2"><button type="submit" name="donate_now" type="submit" value="submit" class="btn btn-block bgPurple" <?php if(!isset($_SESSION['user_id'])){echo 'Disabled';} ?>>Donar ahora</button></div>
                  <div class="p-2 text-center small">Donativo protegido</div>
                  <div class="p-2 text-center small">Al continuar, aceptas las <a class="link" href="#">condiciones</a> y la <a class="link" href="#">declaración de privacidad </a> de Project STEAM.</div>
              </div>
            </form>

            <!-- Warranty -->
            <div class="row"><div class="col"><hr /></div></div>

            <div class="row small">
                <img class="ml-3 mt-3" src="https://th.bing.com/th/id/R.1eba74d0302981eb12097585249a2113?rik=SODym1EBlfnIpw&riu=http%3a%2f%2fcdn.onlinewebfonts.com%2fsvg%2fimg_279196.png&ehk=S6Usc2BVMO8wkud7M1zgDQnca686tZoLUTXwzAKO1i4%3d&risl=&pid=ImgRaw&r=0" style="width: 2rem;height: 100%;">
                <div class="col">
                    <p class="mb-2"><b>Garantía de Project STEAM</b></p>
                    <p>En el caso poco probable de que algo no vaya bien, trabajaremos contigo para determinar si se ha hecho un mal uso.</p>
                </div>
            </div>

            <div class="row"><div class="col"><hr /></div></div>

    </div>

     <!-- Donation total sidebar-->
    <div class="col-4 d-none d-md-block donations">
        <div class="row sidebar"  >
          <div class="col bg-light">

            <div class="row" style="padding-top: 12px;"><h3><b>Tu donativo</b> </h3></div>
            <div class="row">
                <div class="col"><p>Tu donativo</p></div>
                <div class="col-3"><p><span class="donativo">13,00</span>€</p></div>
            </div>
            <div class="row">
                <div class="col"><p>Aportación para Project STEAM</p></div>
                <div class="col-3"><p><span class="aportacion">1,95</span>€</p></div>
            </div>
            <div class="row"><div class="col"><hr /></div></div>
            <div class="row" style="padding-bottom: 12px;">
                <div class="col"><h3>Total</h3></div>
                <div class="col-3"><p><span class="total">14,95</span>€</p></div>
            </div>
            
          </div>
        </div>

    </div>
</div>
</div>

<!-- Footer-->
<div class="container-fluid">
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
          <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Idioma
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="#">Inglés</a>
            <a class="dropdown-item" href="#">Francés</a>
            <a class="dropdown-item" href="#">Español</a>
          </div>
        </div>
        <div class="dropdown show">
          <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
</div>

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
<script src="js/donations.js"></script>
</body>
</html>