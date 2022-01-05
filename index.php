<?php
  include "dbConn.php"; 
  session_start();
  $tablename= "projects";

  $categories = array("para_ti", "science", "tech", "eng", "art", "math"); //array to not deal with strings
  $selected_category = $categories[0]; //default selected category is "para ti"
  
  if (isset($_POST['h_para_ti'])) { $selected_category = $categories[0];}
  if (isset($_POST['h_ciencia'])) { $selected_category = $categories[1];}
  if (isset($_POST['h_tecnologia'])) { $selected_category = $categories[2]; }
  if (isset($_POST['h_ingenieria'])) { $selected_category = $categories[3]; }
  if (isset($_POST['h_arte'])) { $selected_category = $categories[4]; }
  if (isset($_POST['h_matematicas'])) { $selected_category = $categories[5]; }

  $sql = "SELECT projects.*, users.*, COUNT(projects.id_project) AS DONORS, SUM(donations.donation) AS SUM FROM `projects` LEFT JOIN `donations` ON projects.id_project = donations.id_project LEFT JOIN users ON projects.organizer_id = users.id_user";
  //in case selected category is "para_ti", just show projects in whatever order
  if ($selected_category == $categories[0]){
    $sql = $sql. " WHERE `users`.active = 1 GROUP BY projects.id_project";
  }
  //if selected category is one of the above, search in ddbb 
  else{
    $sql = $sql. " WHERE ". $selected_category . " = 1 AND `users`.active = 1 GROUP BY projects.id_project";
  }
  $result = mysqli_query($connection, $sql);
  $projects = [];
  

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $projects[] =  $row;
    }
    //echo $projects[0]['id_project'];
  } else {
    echo "0 results";
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

  <div class="container-fluid content pt-3 pb-0">
    <div class="row d-flex justify-content-around nav text-center">
      <div class="col">
        <a href="#quienesSomos"> ¿Quiénes somos?</a>
      </div>
      <div class="col">
        <a href="#queHacemos"> ¿Qué hacemos?</a>
      </div>
      <div class="col">
        <a  href="#queSon"> ¿Qué es Steam?</a>
      </div>
      <div class="col">
        <a href="#comenzar"> ¿Cómo comenzar?</a>

      </div>
      <div class="col">
        <a href="#logros"> Nuestros logros</a>

      </div>
    </div>

  </div>

  <!-- Navigation bar-->
  <div class="container-fluid colored_container">
    <h1>Descubre proyectos</h1>
    <h2>Explora nuestras categorías</h2>
    <div class="nav_buttons text-center">
      <div>
        <form action="#" method="POST">
        <input type="image" name="para_ti" src="media/para_ti.png" alt="para_ti"/>
        <input type="hidden" name="h_para_ti">
        <p>Para ti</p>
        </form>
      </div>
      <div>
        <form action="#" method="POST">
        <input type="image" name="ciencia" src="media/ciencia.png" alt="ciencia"/>
        <input type="hidden" name="h_ciencia">
        <p>Ciencia</p>
        </form>
      </div>
      <div>
        <form action="#" method="POST">
        <input type="image" name="tecnologia" src="media/tech.png" alt="tecnologia" />
        <input type="hidden" name="h_tecnologia">
        <p>Tecnología</p>
        </form>
      </div>
      <div>
        <form action="#" method="POST">
        <input type="image" name="ingenieria" src="media/ingenieria.png" alt="ingenieria" />
        <input type="hidden" name="h_ingenieria">
        <p>Ingeniería</p>
        </form>
      </div>
      <div>
        <form action="#" method="POST">
        <input type="image" name="arte" src="media/arte.png" alt="arte" />
        <input type="hidden" name="h_arte">
        <p>Arte</p>
        </form>
      </div>
      <div>
        <form action="#" method="POST">
        <input type="image" name="matematicas" src="media/mates.png" alt="matematicas" />
        <input type="hidden" name="h_matematicas">
        <p>Matemáticas</p>
        </form>
      </div>
    </div>
  </div>


  <!-- Main content-->
  <div class="container-fluid content pt-0">
    <!-- Mas populares-->
    <div class="row destacado_titulo">
      <div class="col-md-5 destacado_texto">
        <h1>Más populares</h1>
      </div>
      <div class="col-md-2 destacado_boton">
        <button type="button" class="btn bgPurple btn_ver_mas" onclick=<?php echo "location.href='filtrado.php?selected_category=".$selected_category."'";?>>Ver más</button>
      </div>
    </div>
    <div class="row destacado">
      <div class="col-md-5 columna_imagen">
        <a href=<?php echo "proyectos.php?project_id=".$projects[0]['id_project'];?>>
          <img class="img-fluid" alt="imagen del proyecto" src="<?php echo $projects[0]['picture'];?>" />
        </a>
      </div>
      <div class="col-md-7 columna_texto">
        <a href=<?php echo "proyectos.php?project_id=".$projects[0]['id_project'];?>>
          <h3><?php echo $projects[0]['title'];?></h3>
        </a>
        <p> <?php echo $projects[0]['subtitle'];?> </p>
        <div>
          <img class="time_icon" src="media/time_icon_gray.png">
          <p class="time_text"> <?php $end = $projects[0]['end_date']; $time_left = strtotime($end) - strtotime(gmdate('Y-m-d H:i:s'));
          $days = floor($time_left/ 86400); $hours = floor(($time_left - $days*86400)/ 3600);
          echo $days. ' dias '. $hours . 'h';?> </p>
        </div>
        <div class="progress">
          <?php $percentage = floor(($projects[0]['SUM'] * 100)/$projects[0]['moneyGoal'] ); ?>
          <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentage?>" aria-valuemin="0" aria-valuemax="100"
            style= "<?php echo 'width: '. $percentage . '%';?>"> 
            <?php echo $percentage. "%"?>
          </div>
        </div>
      </div>
    </div>

    <!-- Carrusel-->
    <section class="pt-5">
      <div class="container contenedor_carrusel">
        <div class="row carrusel">
          <div class="col-md-12">
            <div id="carouselExampleControls" class="carousel slide">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="row">

                    <?php 
                    
                        for ($i=1; $i<count($projects) && $i<5; $i++) {
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
                      for ($i=5; $i<count($projects) && $i<9; $i++) {
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

  <!-- About us bar-->
  <div class="container-fluid colored_container">
    <h1>Sobre nosotros</h1>
    <h2>Conócenos</h2>
    <img src="media/icono_manos.png" style="margin-top: 3%; width: 60px; height: auto">
  </div>

  <!-- About us content-->
  <div class="container-fluid content about_us">

    <!-- ¿Quienes somos?-->
    <div class="row about_us_titulo">
      <div class="col-md-12" id="quienesSomos">
        <h1>¿Quienes somos?</h1>
        <h2>Project Steam</h2>
      </div>
    </div>
    <div class="row about_us_info">
      <div class="col-md-12">
        <img class="img-fluid" src="media/ProjectSteam_negro.gif">
        <p class="about_us_texto">Project STEAM es una plataforma de crowdfunding dedicada a crear oportunidades para
          aquellas personas pertenecientes al colectivo STEAM: oportunidades de éxito, de darse a conocer, de ser
          reconocidas, de sacar el mejor partido a sus conocimientos y creatividad y, lo más importante, oportunidades
          de hacer un sueño realidad.
        </p>
      </div>
    </div>

    <!-- ¿Que hacemos?-->
    <div class="row about_us_titulo">
      <div class="col-md-12" id="queHacemos">
        <h1>¿Qué hacemos?</h1>
        <h2>Crowdfunding personal o social</h2>
      </div>
    </div>
    <div class="row about_us_info">
      <div class="col-md-12">
        <img class="img-fluid" src="media/startup.jpeg">
        <p class="about_us_texto">El crowdfunding es un tipo de financiación colectiva (también llamado micromecenazgo)
          en la que a través de pequeñas aportaciones de los usuarios se financian proyectos o iniciativas. Básicamente,
          nos encargamos de poner en contacto a personas que tienen ideas y necesitan financiación con otras que están
          dispuestas a invertir y necesitan esas ideas.
        </p>
      </div>
    </div>

    <!-- Proyectos STEAM-->
    <div class="row about_us_titulo">
      <div class="col-md-12 columna_about_us_titulo" id="queSon">
        <h1>¿Qué son los proyectos STEAM?</h1>
        <h2>¿Por qué financiarlos?</h2>
      </div>
    </div>
    <div class="row about_us_info">
      <div class="col-md-12">
        <img class="img-fluid" src="media/imagen_steam.jpg">
        <p class="about_us_texto">Son proyectos que provienen de las áreas de ciencia, tecnología, ingeniería, artes y
          matemáticas. Estos campos tienen como objetivo la innovación, el pensamiento crítico y la utilización de la
          ingeniería o la tecnología en diseños imaginativos o enfoques creativos para problemas del mundo real mientras
          se construyen sobre la base de las matemáticas y las ciencias. Estos campos han tenido especial crecimiento
          durante los últimos años por su potencial. Por esto mismo hemos creado esta plataforma, para aprovechar esos
          conocimientos y dar impulso a lo que podría ser la tecnología y la ciencia del futuro.
        </p>
      </div>
    </div>

    <!-- Participar-->
    <div class="row about_us_titulo">
      <div class="col-md-12" id="comenzar">
        <h1>¿Cómo comenzar?</h1>
        <h2>Financiar y ser financiado</h2>
      </div>
    </div>
    <div class="row about_us_info">
      <div class="col-md-12">
        <img class="img-fluid" src="media/cerdito.jpg">
        <p class="about_us_texto">
          Dar a conocer tu proyecto es muy sencillo: inicia sesión o regístrate en nuestra plataforma, utiliza nuestras
          plantillas de proyecto, rellena la información requerida y hazlo público. Una vez hecho esto, solo tienes que
          esperar y ver cómo se llena tu barra de progreso con donaciones.
          <br>
          En cambio, si lo que quieres es ayudar con la financiación de un proyecto, puedes empezar explorando nuestras
          categorías o buscando por algún tema que te interese. Para donar deberás iniciar sesión o registrarte.
        </p>
      </div>
    </div>

    <!-- Logros-->
    <div class="row about_us_titulo">
      <div class="col-md-12" id="logros">
        <h1>Nuestros logros</h1>
        <h2>Qué hemos conseguido hasta ahora</h2>
      </div>
    </div>
    <div class="row about_us_info">
      <div class="col-md-12">
        <img class="img-fluid" src="media/logros.jpg">
        <p class="about_us_texto">
          Desde nuestra inauguración hemos conseguido impulsar más de 200.000 proyectos STEAM.
          <br>
          Nuestros patrocinadores superan los 20 millones, de los cuales 7 ya han financiado varios proyectos.
          <br>
          Nos complace anunciar que tenemos un índice de éxito de casi un 50%, lo que nos hace una de las plataformas
          crowdfunding más exitosas.
        </p>
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