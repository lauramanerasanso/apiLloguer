<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');

$controlador = new controlador_casa();

if(isset($_POST['dataInici']) && isset($_POST['dataFi']) && isset($_POST['idioma'])) {

    $dataInici = $_POST['dataInici'];
    $dataFi = $_POST['dataFi'];
    $idioma = $_POST['idioma'];

    $result = $controlador->selectCasesCerca($dataInici, $dataFi, $idioma);
    echo $result;
    
}else{
    $idioma = $_POST['idioma'];

    $result = $controlador->selectIdioma($idioma);
    echo $result;
}