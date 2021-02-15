<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


if (isset($_POST['idCasa']) && isset($_POST['dataInici']) && isset($_POST['nomTarifa'])) {

    $controlador = new controlador_casa();

    $idCasa = $_POST['idCasa'];
    $dataInici = $_POST['dataInici'];
    $nomTarifa = $_POST['nomTarifa'];

    $controlador->deleteTarifa($idCasa, $dataInici, $nomTarifa);

}