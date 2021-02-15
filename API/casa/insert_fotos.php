<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');


    $cont = new controlador_casa();
    $id = $cont->id_Max();

    $contador = 1;

  foreach ($_FILES as $f){


      $nom = $id."_".$contador.".jpg";

      $ruta =  "../backLloguerVacacional/imatges/" .$nom;
      $imageFileType = pathinfo($ruta, PATHINFO_EXTENSION);
      $imageFileType = strtolower($imageFileType);
      $temp = $f['tmp_name'];

      $valid_extensions = array("jpg", "jpeg", "png");



      if (in_array(strtolower($imageFileType), $valid_extensions)) {
          /* Upload file */
          if (move_uploaded_file($temp, $ruta)) {
              $response = $ruta;
          }
      }

      $contador++;


  }

  $f1 = $id."_1.jpg";
  $f2 = $id."_2.jpg";
  $f3 = $id."_3.jpg";
  $f4 = $id."_4.jpg";
  $f5 = $id."_5.jpg";

  $cont->inserirFotos($id,$f1,$f2,$f3,$f4,$f5);

  header("Location: http://admin.mallorcarustic.me/cases");




