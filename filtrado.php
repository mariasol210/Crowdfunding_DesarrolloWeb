<?php
    include "dbConn.php";
    session_start();
    
    if (isset($_GET['selected_category'])) $selected_category = $_GET['selected_category']; //if category comes from a category button
    else if (isset($_GET['q'])) $selected_category = $_GET['q']; //else if it comes from the search bar

    $categories = array("para_ti", "science", "tech", "eng", "art", "math"); //array to not deal with strings

    //if any of the category buttons gets pressed
    if (isset($_POST['h_para_ti'])) { $selected_category = $categories[0];}
    if (isset($_POST['h_ciencia'])) { $selected_category = $categories[1];}
    if (isset($_POST['h_tecnologia'])) { $selected_category = $categories[2]; }
    if (isset($_POST['h_ingenieria'])) { $selected_category = $categories[3]; }
    if (isset($_POST['h_arte'])) { $selected_category = $categories[4]; }
    if (isset($_POST['h_matematicas'])) { $selected_category = $categories[5]; }

    //fill the page
    $sql = "SELECT projects.*, users.*, COUNT(projects.id_project) AS DONORS, SUM(donations.donation) AS SUM FROM `projects` LEFT JOIN `donations` ON projects.id_project = donations.id_project LEFT JOIN users ON projects.organizer_id = users.id_user";
    
    if ($selected_category == $categories[0]){ //in case selected category is "para_ti", just show projects in whatever order
      $sql = $sql. " WHERE `users`.active = 1 GROUP BY projects.id_project";
      $title = "Para ti";
    }
   
    else if (in_array($selected_category, $categories, true)){  //if selected category is one of the above, search in ddbb 
      $sql = $sql. " WHERE ". $selected_category . " = 1 AND `users`.active = 1 GROUP BY projects.id_project";
      //set title name
      if ($selected_category == $categories[1]) $title = "Ciencia";
      if ($selected_category == $categories[2]) $title = "Tecnología";
      if ($selected_category == $categories[3]) $title = "Ingeniería";
      if ($selected_category == $categories[4]) $title = "Arte";
      if ($selected_category == $categories[5]) $title = "Matemáticas";
    }
    
    else{ //if it is none of them, that means it comes from the search bar and a query using "CONTAINS" must be used
        $sql = "SELECT projects.*, users.*, COUNT(projects.id_project) AS DONORS, SUM(donations.donation) AS SUM FROM `projects` LEFT JOIN `donations` ON projects.id_project = donations.id_project LEFT JOIN users ON projects.organizer_id = users.id_user". 
        " WHERE `users`.active = 1 AND `projects`.title LIKE '%".$selected_category."%' OR `projects`.subtitle LIKE '%".$selected_category."%' OR `projects`.description LIKE '%".$selected_category."%' GROUP BY projects.id_project";
        $title = $selected_category;

    }
    $result = mysqli_query($connection, $sql);
    $projects = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $projects[] =  $row;
        }
        //echo $projects[0]['id_project'];
    }     else {
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

    <!-- Container with results-->
    <div class="container results_container">
        <div class="project_header mt-5 mb-5">
            <h1>Proyectos mostrados: "<span class="#search_title"><?php echo $title?></span>"</h1>
        </div>

        <?php 
            $i = 0; //project index
            for ($j=0; $j<3; $j++){ //row counter
                echo '<div class="row">';
                
                for ($cont=0; $i<count($projects) && $cont<3; $cont++) { //cont is item counter in row
                    $end = $projects[$i]['end_date'];
                    $time_left = strtotime($end) - strtotime(gmdate('Y-m-d H:i:s'));
                    $days = floor($time_left/ 86400);
                    $hours = floor(($time_left - $days*86400)/ 3600);
                    $percentage = floor(($projects[$i]['SUM'] * 100)/$projects[$i]['moneyGoal'] );
                    if ($projects[$i]['SUM']==null){ $projects[$i]['SUM']=0;}   
                    
                    echo '<div class="col-md-4 col-sm-6"><div class="card search_card"> <a href="proyectos.php?project_id='.$projects[$i]['id_project'].'"><img class="img-fluid carrusel_img" alt="imagen del proyecto" src="'.$projects[$i]['picture'].'" /> </a>'.
                    '<div class="card-body"><a href="proyectos.php?project_id='.$projects[$i]['id_project'].'"><h4 class="card-title">'.$projects[$i]['title'].'</h4></a><p class="card-text">'.$projects[$i]['subtitle'].'</p><div class="card-footer">'.
                    '<div><img class="time_icon" src="media/time_icon_gray.png"><p class="time_text">&nbsp'.$days. ' dias '. $hours . 'h</p></div>'.
                    '<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%">'.
                    $percentage.'%</div></div></div></div></div></div>';

                    $i++;
                }
                echo '</div>';
            }        
        ?>
    </div>


    <!-- Bottom navigation-->
    <nav aria-label="page_navigation">
        <ul class="pagination justify-content-center mt-4">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Bottom categories-->
    <div class="content text-center pt-3 pb-3" style="margin-inline: auto;">
        <hr style="width: 50%">
        <h1>Explora nuestras categorías:</h1>
    </div>
    <div class="container nav_buttons text-center mt-0 mb-5">
        <div>
        <form action="#" method="POST">
          <input type="image" name="para_ti" src="media/para_ti-color.png" alt="para_ti" />
          <input type="hidden" name="h_para_ti">
          <p>Para ti</p>
        </form>
        </div>
        <div>
        <form action="#" method="POST">
          <input type="image" name="ciencia" src="media/ciencia-color.png" alt="ciencia" />
          <input type="hidden" name="h_ciencia">
          <p>Ciencia</p>
          </form>
        </div>
        <div>
        <form action="#" method="POST">
          <input type="image" name="tech" src="media/tecnologia-color.png" alt="tecnologia" />
          <input type="hidden" name="h_tecnologia">
          <p>Tecnología</p>
          </form>
        </div>
        <div>
        <form action="#" method="POST">
          <input type="image" name="ingenieria" src="media/ingenieria-color.png" alt="ingenieria" />
          <input type="hidden" name="h_ingenieria">
          <p>Ingeniería</p>
          </form>
        </div>
        <div>
        <form action="#" method="POST">
          <input type="image" name="arte" src="media/arte-color.png" alt="arte" />
          <input type="hidden" name="h_arte">
          <p>Arte</p>
          </form>
        </div>
        <div>
        <form action="#" method="POST">
          <input type="image" name="mates" src="media/mates-color.png" alt="matematicas" />
          <input type="hidden" name="h_matematicas">
          <p>Matemáticas</p>
          </form>
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