<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');


if(isset($_POST['pob']) && isset($_POST['banys']) && isset($_POST['hab']) && isset($_POST['x']) && isset($_POST['y']) && isset($_POST['preu']) && isset($_POST['nom1']) && isset($_POST['nom2']) && isset($_POST['desc1']) && isset($_POST['desc2']) && isset($_POST['caract'])){


    $controlador = new controlador_casa();

    $nom1 = $_POST['nom1'];
    $nom2 = $_POST['nom2'];
    $desc1 = $_POST['desc1'];
    $desc2 = $_POST['desc2'];

    $array = json_decode($_POST['caract'],true);

    $idCasa =  $controlador->insertCasa($_POST['pob'],$_POST['banys'],$_POST['hab'],$_POST['x'],$_POST['y'],$_POST['preu'],$nom1,$nom2,$desc1,$desc2,$array);

}



