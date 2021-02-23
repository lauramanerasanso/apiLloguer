<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


if(isset($_POST['idCasa'])){

    $controlador = new controlador_casa();

    $idCasa = $_POST['idCasa'];

    $controlador->selectNomTarifes($idCasa);

}
