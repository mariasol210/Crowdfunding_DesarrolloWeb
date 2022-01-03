<?php
  include "dbConn.php"; 
  session_start();
  $tablename= "projects";
  $sql = $sql = "SELECT *, COUNT(projects.id_project) AS DONORS, SUM(donations.donation) AS SUM  FROM `projects` INNER JOIN `donations` ON projects.id_project = donations.id_project GROUP BY projects.id_project";
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
        <input type="image" name="para_ti" src="media/para_ti.png" alt="para_ti" />
        <p>Para ti</p>
      </div>
      <div>
        <input type="image" name="ciencia" src="media/ciencia.png" alt="ciencia" />
        <p>Ciencia</p>
      </div>
      <div>
        <input type="image" name="tech" src="media/tech.png" alt="tecnologia" />
        <p>Tecnología</p>
      </div>
      <div>
        <input type="image" name="ingenieria" src="media/ingenieria.png" alt="ingenieria" />
        <p>Ingeniería</p>
      </div>
      <div>
        <input type="image" name="arte" src="media/arte.png" alt="arte" />
        <p>Arte</p>
      </div>
      <div>
        <input type="image" name="mates" src="media/mates.png" alt="matematicas" />
        <p>Matemáticas</p>
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
        <button type="button" class="btn bgPurple btn_ver_mas">Ver más</button>
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
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/105659142/atomic-size-matters?ref=discovery&term=chemistry"
                            src="media/p_chemistrymatters.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              El Tamaño Atómico importa
                            </h4>
                          </a>
                          <p class="card-text">
                            Una tesis doctoral en química teórica del estado
                            sólido... en forma de cómic.
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">48 dias 23h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="68" aria-valuemin="0"
                                aria-valuemax="100" style="width: 68%">
                                68%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/xscapistlj/comixscape-collection-1?ref=section-comics-illustration-featured-project"
                            src="media/p_comic.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              COMIXSCAPE Colección 1!
                            </h4>
                          </a>
                          <p class="card-text">
                            ¡Un ómnibus de más de 150 páginas de los primeros
                            3 volúmenes de mi serie de webcomic COMIXSCAPE,
                            además de algunos extras muy especiales para
                            lectores nuevos y antiguos!
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">25 dias 7h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100" style="width: 75%">
                                75%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/980681112/bunny-numbers-game-helps-children-to-be-confident-in-maths?ref=discovery&term=math"
                            src="media/p_bunny.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              El juego “Bunny Numbers” ayuda a niños a
                              aprender matemáticas
                            </h4>
                          </a>
                          <p class="card-text">
                            Aprender tablas de multiplicar jugando el juego.
                            Los niños disfrutan jugando a este juego - los
                            disfrutarás aprendiendo matemáticas
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">77 dias 1h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0"
                                aria-valuemax="100" style="width: 88%">
                                88%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/1450781303/bonjour-smart-alarm-clock-with-artificial-intellig?ref=discovery&term=smart%20clock"
                            src="media/p_bonjour.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              Bonjour | Reloj despertador inteligente con IA
                            </h4>
                          </a>
                          <p class="card-text">
                            Su reloj despertador ahora es un asistente
                            personal. Al conocer su agenda y sus pasatiempos,
                            Bonjour le ayuda a aprovechar al máximo cada día.
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">51 dias 4h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="71" aria-valuemin="0"
                                aria-valuemax="100" style="width: 71%">
                                71%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/deckrx/deckrx-the-deckbuilding-racing-videogame?ref=discovery&term=videogame"
                            src="media/p_deckrx.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              Deck: El videojuego de carrera de construcción
                              de Decks
                            </h4>
                          </a>
                          <p class="card-text">
                            Deck RX combina elementos tradicionales de
                            construcción de mazos roguelike con el género de
                            los videojuegos de carreras.
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">29 dias 6h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                                aria-valuemax="100" style="width: 85%">
                                85%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img" alt="100%x280" src="media/p_stempower.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              Kit de actividades STEMpowerkids
                            </h4>
                          </a>
                          <p class="card-text">
                            STEMpowerkids ofrece kits de actividades de
                            ciencia, tecnología, ingeniería y matemáticas
                            mensuales para niños de 3 a 8 años.
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">24 dias 17h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="89" aria-valuemin="0"
                                aria-valuemax="100" style="width: 89%">
                                89%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/newhamptonschool/the-class-that-harnessed-the-wind-0?ref=discovery&term=engineering"
                            src="media/p_wind.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              The Class That Harnessed the Wind
                            </h4>
                          </a>
                          <p class="card-text">
                            Los estudiantes de secundaria aprenden principios
                            de diseño, ingeniería y publicación al construir
                            una turbina eólica en funcionamiento.
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">21 dias 23h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="77" aria-valuemin="0"
                                aria-valuemax="100" style="width: 77%">
                                77%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <div class="card">
                        <a href="#">
                          <img class="img-fluid carrusel_img"
                            alt="https://www.kickstarter.com/projects/2045724330/kenneth-mbenes-soil-chemistry-report?ref=discovery&term=chemistry"
                            src="media/p_chemistryreport.png" />
                        </a>
                        <div class="card-body">
                          <a href="#">
                            <h4 class="card-title">
                              Informe de química del suelo de Kenneth Mbene
                            </h4>
                          </a>
                          <p class="card-text">
                            Tesis sobre la capacidad de fijación de fósforo en
                            suelos y cuerpos de agua volcánicos del suroeste
                            de Camerún.
                          </p>
                          <div class="card-footer">
                            <div>
                              <img class="time_icon" src="media/time_icon_gray.png">
                              <p class="time_text">44 dias 9h</p>
                            </div>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="91" aria-valuemin="0"
                                aria-valuemax="100" style="width: 91%">
                                91%
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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