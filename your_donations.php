<?php
  include "dbConn.php";   
  session_start();
  $tablename= "projects";

  $sql = "SELECT * FROM `donations` INNER JOIN users ON donations.id_user = users.id_user INNER JOIN projects ON donations.id_project = projects.id_project WHERE users.id_user=". $_SESSION['user_id']. " ORDER BY date ASC";
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

    <!-- Donations history-->
    <div class="container text-center project_header mt-5 mb-5">
        <h1>Tu historial de donaciones</h1>
    </div>
    <div class="container donations_elements">

        <?php 
                   
            for ($i=0; $i<count($donations); $i++) {                 
            echo 
            '<div class="row element">
            <div class="col-md-2 element_col">
            <h1>'. $donations[$i]['donation'].'€</h1>
            </div>
            <div class="col-md-7 element_col">
            <h2><a href="proyectos.php?project_id='.$donations[$i]['id_project'].'">'.$donations[$i]['title'].'</a></h2>
            </div>
            <div class="col-md-3 element_col">
            <h2>'.$donations[$i]['date'].'</h2>
            </div>
            </div>
            ';
            }
        ?>
    
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