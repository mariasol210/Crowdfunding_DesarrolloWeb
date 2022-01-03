<?php
  include "dbConn.php";   
  session_start();
  $tablename= "projects";
  $project_id = $_GET['project_id'];

  $sql = "SELECT projects.*, users.*, COUNT(projects.id_project) AS DONORS, SUM(donations.donation) AS SUM FROM `projects` LEFT JOIN `donations` ON projects.id_project = donations.id_project LEFT JOIN users ON projects.organizer_id = users.id_user GROUP BY projects.id_project ORDER BY start_date DESC LIMIT 8";
  $result = mysqli_query($connection, $sql);
  $projects = [];
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      //recover the info of the project that was clicked
      if($row['id_project'] == $project_id) {
        
        $project_title = htmlspecialchars_decode($row['title'], ENT_QUOTES);
        $money_goal = $row['moneyGoal'];
        $project_donations = $row['SUM'];
        $donors_count = $row['DONORS'];
        $project_pic = $row['picture'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $organizer = $row['name'];
        $organizer_email = $row['email'];
        $organizer_pic = $row['profile_pic'];
        $project_sub = htmlspecialchars_decode($row['subtitle'], ENT_QUOTES);
        $project_info = htmlspecialchars_decode($row['description'], ENT_QUOTES);
        $science = $row['science'];
        $tech = $row['tech'];
        $eng = $row['eng'];
        $art = $row['art'];
        $math = $row['math'];
      } else{
        //Store the rest of the projects for the carrousel
        $projects[] =  $row;
      }
    }
  } else {
    echo "0 results";
  }

  $sql = "SELECT * FROM `donations` INNER JOIN users ON donations.id_user = users.id_user WHERE donations.id_project=". $project_id. " ORDER BY date DESC LIMIT 3";
  $result = mysqli_query($connection, $sql);
  $donations = [];
  
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $donations[] =  $row;
    }
  } else {
    $project_donations='0';
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
    <title><?php echo $project_title;?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="css/style.css" rel="stylesheet" />
    
</head>
<body>
    <!-- Top container -->
    <?php include "top_bar.php"?>
    
  <!-- header and donations info-->
  <div class="container-fluid container project_header mt-5">
        <h1><?php echo $project_title;?></h1>
        <h2><?php echo $project_sub;?></h2>
    <div class="row project">
        <div class="col">
          <!-- Project picture-->
          <div class="row">
            <div class="col">
              <img class="img-fluid" alt="imagen del proyecto" src="<?php echo $project_pic;?>" />
            </div>
          </div>

           <!-- Project progress small screen-->
          <div class="row d-lg-none d-md-none d-xl-none donations">
            <div class="col bg-light ">
              <div class="row progress" style="margin-bottom: 3%; margin-top: 5%;">
              <?php $percentage = floor(($project_donations * 100)/$money_goal ); ?>
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentage?>" aria-valuemin="0" aria-valuemax="100"
                    style="<?php echo 'width: '. $percentage . '%';?>">
                </div>        
              </div>
              <div class="row"><h3><span class="project_money"><?php echo $project_donations ?></span>€</h3></div>
              <div class="row"><p>recaudados de <span class="project_objective"><?php echo $money_goal ?></span>€</p></div>
              <div class="row"><p><span class="project_remaintime"><?php $time_left = strtotime($end_date) - strtotime(gmdate('Y-m-d H:i:s'));
                $days = floor($time_left/ 86400);echo $days;?></span> días más</p></div>
              </div>
          </div>
         
          <!-- Project author-->
          <div class="row" style="margin-top: 3%;margin-left: 5px">
            <img class="sponsor1_pic"src="<?php echo $organizer_pic?>" style="width: 3rem; border-radius: 50%">
            <div class="col"><span class="autor"> <?php echo $organizer ?> </span> es la persona que organiza esta recaudación de fondos.</div>
          </div>
          
          <div class="row">
            <div class="col"><hr /></div>
          </div>

          <!-- Project's Date and tags-->
          <div class="row">
            <div class="col">Fecha de creación: <span id="fecha"><?php $date = strtotime($start_date); echo date('d', $date).' de '.$meses[date('n', $date)-1].' de '. date('Y', $date);?> </span> </div> |
            <div class="col"> 
              <div class="row">
                <?php 
                if($science == 1) {echo '<img class="sponsor1_pic"src="media/itag.png" style="width: 1.7rem; margin-left: 5%;"> <a class="link" id="tag" href="#"> Science </a>';}
                if($tech == 1) {echo '<img class="sponsor1_pic"src="media/itag.png" style="width: 1.7rem; margin-left: 5%;"> <a class="link" id="tag" href="#"> Technology </a>';}
                if($eng== 1) {echo '<img class="sponsor1_pic"src="media/itag.png" style="width: 1.7rem; margin-left: 5%;"> <a class="link" id="tag" href="#"> Engineering </a>';}
                if($art == 1) {echo '<img class="sponsor1_pic"src="media/itag.png" style="width: 1.7rem; margin-left: 5%;"> <a class="link" id="tag" href="#"> Arts </a>';}
                if($math == 1) {echo '<img class="sponsor1_pic"src="media/itag.png" style="width: 1.7rem; margin-left: 5%;"> <a class="link" id="tag" href="#"> Mathematics </a>';}
                ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col"><hr /></div>
          </div>

          <!-- Project description-->
          <div class="row" style="margin-bottom: 5%;">
            <div class="col">
              <?php echo $project_info;?>
            </div>
          </div>

          <!-- Donate or share buttons-->
          <div class="row" style="margin-bottom: 10%;">
            <div class="col">
             
              <button type="button" class="btn bgPink btn-lg btn-block"  onclick=" <?php echo 'location.href=\'donate.php?project_id='.$project_id.'\';';?> ">Patrocinar</button>
            </div>
            <div class="col">
              <button type="button" class="btn bgPurple btn-lg btn-block" onclick="getURL()" data-toggle="modal" data-target="#shareModal" >Compartir</button>
            </div>
          </div>

         <!-- Organizer contact-->
         <div class="row">
          <div class="col"><h3><b>Organizador</b></h3></div>
         </div>
         <div class="row"><div class="col"><hr /></div></div>
          
         <div class="row mb-5" >

            <img class="autor_pic"src="<?php echo $organizer_pic?>" style="width: 5rem; ; border-radius: 50%">

          <div class="col">
            <p class ="autor"> <?php echo $organizer ?>
              <br>Organizador
              <br><span class="autor_ubicacion"> Madrid </span>
            </p>
          </div>
          <div class="col-2">
            <button type="button" class="btn bgPurple contactButton" data-toggle="modal" data-target="#contactModal">
              Contacto
            </button>
          </div>
         </div>

          <!-- Last donations-->
          <div class="row">
            <div class="col"><h3><b>Últimas aportaciones </b></h3></div>
           </div>
           <div class="row"><div class="col"><hr /></div></div>
            <?php
              for ($i=0; $i<count($donations); $i++) {
                $pp = "";
                if ($donations[$i]['profile_pic'] == '' || $donations[$i]['donor_name']=='Anónimo') {$pp = 'media/iuser.jpg';}
                else {$pp = $donations[$i]['profile_pic'];}
                echo '<div class="row"> <img class="sponsor1_pic" style="width: 4rem; border-radius: 50%" src="'.$pp.'" > <div class="col"> <p>'. $donations[$i]['donor_name'].'<br><span>'. $donations[$i]['donation'].'</span>€ </p></div></div><div class="row"><div class="col"><hr /></div></div>';
              }
            ?>
           

          </div>

         <!-- Donations sidebar-->
        <div class="col-4 d-none d-md-block donations">
            <div class="row sidebar"  >
              <div class="col bg-light ">
                <div class="row progress" style="margin-bottom: 3%; margin-top: 5%;">
                  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentage?>" aria-valuemin="0" aria-valuemax="100"
                      style="<?php echo 'width: '. $percentage . '%';?>">
                  </div>        
                </div>
                <div class="row"><h3><span class="project_money"><?php echo $project_donations ?></span>€</h3></div>
                <div class="row"><p>recaudados de <span class="project_objective"><?php echo $money_goal ?></span>€</p></div>
                <div class="row"><h3 class="project_sponsors"><?php echo $donors_count?></h3></div>
                <div class="row"><p>patrocinadores</p></div>
                <div class="row"><h3 class="project_remaintime"><?php echo $days; ?></h3></div>
                <div class="row"><p>días más</p></div>
                <div class="row align-items-end" > <button type="button" class="btn bgPink btn-lg btn-block mb-3" onclick="<?php echo 'location.href=\'donate.php?project_id='.$project_id.'\';';?> ">Patrocinar</button></div>
                <div class="row align-items-end"> <button type="button" class="btn bgPurple btn-lg btn-block mb-3" onclick="getURL()" data-toggle="modal" data-target="#shareModal">Compartir</button></div>
              </div>
            </div>
  
        </div>
    </div>
  </div>

  <!-- Other projects carrousel -->
  <div class="container-fluid container">
    <section class="container pt-5">
      <div class="container contenedor_carrusel">
        <div class="row carrusel">
          <p>También te puede interesar</p>
          <div class="col-md-12">
            <div id="carouselExampleControls" class="carousel slide">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="row">
                    
                    <?php 
                   
                      for ($i=0; $i<count($projects) && $i<4; $i++) {
                        if($projects[$i]['SUM'] == ''){$projects[$i]['SUM']='0';}
                        $percentage = floor(($projects[$i]['SUM'] * 100)/$projects[$i]['moneyGoal'] ); 
                        
                        echo '<div class="col-md-3 col-sm-6 mb-3"><div class="card"> <a href="proyectos.php?project_id='.$projects[$i]['id_project'].'"><img class="img-fluid" alt="imagen del proyecto" src="'.$projects[$i]['picture'].'" /> </a>'.
                          '<div class="card-body"><a href="proyectos.php?project_id='.$projects[$i]['id_project'].'"><h4 class="card-title">'.$projects[$i]['title'].'</h4></a><p class="card-text">'.$projects[$i]['subtitle'].'</p><div class="card-footer">'.
                          '<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%">'.
                          $percentage.'%</div></div></div></div></div></div>';
                      }
                    ?>
                    
                  </div>
                </div>
                    <?php 
                    //only if we have more than 4 projects we display another page
                    if(count($projects)>4){
                      echo '<div class="carousel-item"><div class="row">';
                      for ($i=4; $i<count($projects) && $i<8; $i++) {
                        if($projects[$i]['SUM'] == ''){$projects[$i]['SUM']='0';}
                        $percentage = floor(($projects[$i]['SUM'] * 100)/$projects[$i]['moneyGoal'] ); 
                        
                        echo '<div class="col-md-3 col-sm-6 mb-3"><div class="card"> <a href="proyectos.php?project_id='.$projects[$i]['id_project'].'"><img class="img-fluid" alt="imagen del proyecto" src="'.$projects[$i]['picture'].'" /> </a>'.
                          '<div class="card-body"><a href="proyectos.php?project_id='.$projects[$i]['id_project'].'"><h4 class="card-title">'.$projects[$i]['title'].'</h4></a><p class="card-text">'.$projects[$i]['subtitle'].'</p><div class="card-footer">'.
                          '<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%">'.
                          $percentage.'%</div></div></div></div></div></div>';
                      }

                      echo '</div></div>';
                    }
                    
                  ?>
                  
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

   <!--Categories -->
  <div class="container-fluid container  d-none d-md-block">
    <div class="nav_buttons text-center">
      <div>
        <input type="image" name="para_ti" src="media/para_ti-color.png" alt="para_ti" />
        <p>Para ti</p>
      </div>
      <div>
        <input type="image" name="ciencia" src="media/ciencia-color.png" alt="ciencia" />
        <p>Ciencia</p>
      </div>
      <div>
        <input type="image" name="tech" src="media/tecnologia-color.png" alt="tecnologia" />
        <p>Tecnología</p>
      </div>
      <div>
        <input type="image" name="ingenieria" src="media/ingenieria-color.png" alt="ingenieria" />
        <p>Ingeniería</p>
      </div>
      <div>
        <input type="image" name="arte" src="media/arte-color.png" alt="arte" />
        <p>Arte</p>
      </div>
      <div>
        <input type="image" name="mates" src="media/mates-color.png" alt="matematicas" />
        <p>Matemáticas</p>
      </div>
    </div>
  </div>

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

  <!-- Modal to show contact info-->
    <div class="modal fade" id="contactModal" role="dialog">
      <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" id="signInHeader">
            <h5 class="modal-title">Información de contacto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col" style="text-align: center;" >
                <span><img class="autor_pic"src="<?php echo $organizer_pic?>" style="width:18%;"> </span>
                  <h3 class="autor"> <b> <?php echo $organizer?> </b></h3>
                  <p class="autor_ubicacion"> Madrid</p>
                </div>
              </div>


              <div class="row">
                <div class="col" style="text-align: center;"> Escribe un correo a </div>
              </div>
              <div class="row">
                <div class="col" style="text-align: center;">
                  <span><img src="media/iemail.jpg" style="width: 4%;"></span>
                  <span class="autor_email"> <a href="#" class="link"><?php echo $organizer_email?></a></span>
                </div>
              </div>

              <div class="row d-flex justify-content-center" style="margin-top: 2%;">
                <div class="col-2 col-lg-2 ">
                  <a class="twitter" href="#"><img src="media/itwitter.png" style="width: 100%;"></a>
                </div>
                <div class="col-2 col-lg-2">
                  <a class="facebook" href="#"><img src="media/ifacebook.png" style="width: 100%;"></a>
                </div>
                <div class="col-2 col-lg-2">
                  <a class="linkedin" href="#"><img src="media/ilinkedin.png" style="width: 100%;"></a>
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
</body>
</html>