<?php
    include "dbConn.php";
    session_start();

    $sql = "SELECT projects.*, COUNT(projects.id_project) AS DONORS, SUM(donations.donation) AS SUM FROM `projects` LEFT JOIN `donations` ON projects.id_project = donations.id_project WHERE projects.organizer_id = ".$_SESSION['user_id']." GROUP BY projects.id_project ORDER BY start_date ASC";
    $result = mysqli_query($connection, $sql);
    $projects = [];

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
          $projects[] =  $row;
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

    <div class="container text-center project_header mt-5 mb-5 pb-0">
        <h1>Tus proyectos:</h1>
    </div>

    <!-- Projects-->
    <div class="container-fluid content pt-0" style="min-height: 30rem;">
        
    <?php 
                   
            for ($i=0; $i<count($projects); $i++) {
                $end = $projects[$i]['end_date'];
                $time_left = strtotime($end) - strtotime(gmdate('Y-m-d H:i:s'));
                $days = floor($time_left/ 86400);
                $hours = floor(($time_left - $days*86400)/ 3600);
                $percentage = floor(($projects[$i]['SUM'] * 100)/$projects[$i]['moneyGoal'] );
                if ($projects[$i]['SUM']==null){ $projects[$i]['SUM']=0; $projects[$i]['DONORS'] = 0;}             
            echo 
            '<div class="row destacado mt-5 mb-5">
            <div class="col-md-3 columna_imagen">
            <a href="proyectos.php?project_id='.$projects[$i]['id_project'].'">
            <img class="img-fluid" alt="https://www.kickstarter.com/projects/91367227/tether-projecting-safe-zones-around-bikes?ref=section-design-tech-featured-project"
            src="'.$projects[$i]['picture'].'" />
            </a>
            </div>
            <div class="col-md-5 columna_texto">
            <a href="proyectos.php?project_id='.$projects[$i]['id_project'].'">
            <h3>'.$projects[$i]['title'].'</h3>
            </a>
            <div>
            <img class="time_icon" src="media/time_icon_gray.png">
            <p class="time_text">'.$days. ' dias '. $hours . 'h</p>
            </div>
            <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="'. $percentage.'" aria-valuemin="0" aria-valuemax="100"
            style= "width: '. $percentage . '%" >'.$percentage. '%
            </div>
            </div>
            </div>
            <div class="col-md-4 vertical_line">
            <div class="mng_project">
            <div class="text-center">
            <button class="btn" type = "button" id="editar" name = "editar" onclick="location.href=\'edit_project.php?project_id='.$projects[$i]['id_project'].'\'">
            <img class="mng_project_icons" src="media/editar.png" />
            <p>Editar</p>
            </button>
            </div>
            <div class="text-center">
            <button class="btn" type = "button" name = "compartir" onclick="getURL()" data-toggle="modal" data-target="#shareModal">
            <img class="mng_project_icons" src="media/compartir.png" />
            <p>Compartir</p>
            </button>                        
            </div>
            <div class="text-center">
            <button class="btn" type = "button" name = "retirar" data-toggle="modal" data-target="#withdrawModal">
            <img class="mng_project_icons" src="media/retirar.png" />
            <p>Retirar</p>
            </button>
            </div>
            </div>
            <div class="info_project">
            <div class="row">
            <h3><span class="project_money">'.$projects[$i]['SUM'].'€</span></h3>
            <p>&nbsp;recaudados de <span class="project_objective">'.$projects[$i]['moneyGoal'].'</span>€</p>
            </div>
            <div class="row">
            <h3 class="project_sponsors">'.$projects[$i]['DONORS'].'</h3>
            <p>&nbsp;patrocinadores</p>
            </div>
            </div>
            </div>
            </div>
            ';
            }
        ?>


    <!-- Modal to share-->
  <div class="modal fade" id="shareModal" role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="signInHeader">
          <h5 class="modal-title">Comparte para ayudar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">

            <div class="row">
              <div class="col">
                <p> Las campañas que se comparten en las redes sociales recaudan hasta 5 veces más</p>
              </div>
            </div>

            <div class="row"><div class="col"><hr /></div></div>

            <div class="d-flex flex-row justify-content-around flex-wrap mt-1 text-center">
              <div class="p-2">
                <a class="twitter" href="#"><img src="media/itwitter.png" style="height: 5rem;"></a>
                <p>Twitter</p>
              </div>
              <div class="p-2">
                <a class="facebook" href="#"><img src="media/ifacebook.png" style="height: 5rem;"></a>
                <p>Facebook</p>
              </div>
              <div class="p-2">
                <a class="email"  href="#"><img src="media/iemail.jpg" style="height: 5rem;"></a>
                <p>Email</p>
              </div>
              <div class="p-2">
                <a class="whatsapp" href="#"><img src="https://maxcdn.icons8.com/Share/icon/p1em/Logos/whatsapp1600.png" style="height: 5rem;"></a>
                <p>WhatsApp</p>
              </div>
            </div>

            <div class="row"><div class="col"><hr /></div></div>
            <span> Copiar enlace</span>

            
            <div class="row">
              <div class="col">
                <input type="text" class="form-control mb-2 mr-sm-2"  id="clipboardLink" readonly>
                <p class="small text-success" id="copiedMessage"></p>
              </div>
              <div class="col-3">
                <button class="btn btn-primary mb-2" onclick="copyURLtoClipboard()">Copiar</button>
              </div>
            </div>


          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

     <!-- Modal to withdraw-->
     <div class="modal fade" id="withdrawModal" role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Retira tus donativos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">

            <div class="row">
              <div class="col">
                <p> Introduce tu información bancaria</p>
              </div>
            </div>
            <div class="row">
                <div class="col">
                    <form action="">
                    <div class="inputbox"> 
                        <input type="text" name="cardholder" class="form-control" required="required"> <span>Nombre del titular</span> </div>
                    <div class="inputbox"> 
                        <input type="tel" inputmode="numeric" name="cc_number" pattern="[0-9\s]{13,19}" autocomplete="cc-number"  max="19" class="form-control" required="required" maxlength="19"> 
                        <span>Número de tarjeta</span> <i class="fa fa-eye"></i> <p class="small"> Ej. xxxx xxxx xxxx xxxx </p>
                    </div>
                    <div class="col-md-12 text-center">
                        <input class = "btn bgPurple" type="submit" value="Retirar" style="margin-left:auto; margin-right:auto">
                    </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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