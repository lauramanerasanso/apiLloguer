<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');

$controlador = new controlador_casa();
if(isset($_POST['data_inici']) && isset($_POST['idioma']) && isset($_POST['id'])) {

    $data_inici = $_POST['data_inici'];
    $idioma = $_POST['idioma'];
    $idCasa = $_POST['id'];

    $controlador->selectReserva($idioma, $data_inici, $idCasa);

}