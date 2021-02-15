<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');



if (isset($_REQUEST['idCasa']) && isset($_REQUEST['idImg'])) {


    $id = $_REQUEST['idCasa'];
    $idImg = $_REQUEST['idImg'];


    $nom = $id . "_" . $idImg . ".jpg";

    $ruta = "../RutesLloguer/imatges/" . $nom;
    $rutaVista = "../imatges/" . $nom;
    $imageFileType = pathinfo($ruta, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    $valid_extensions = array("jpg", "jpeg", "png");

    $response = 0;

    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        if (isset($_FILES["file"]["tmp_name"]) ){
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $ruta)) {
                $response = $rutaVista;
                echo $response;
                exit;
            }
        }

    }


    echo $response;
}