<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');

$controlador = new controlador_casa();

if(isset($_POST['dataInici']) && isset($_POST['dataFi']) && isset($_POST['array']) && isset($_POST['idioma'])) {

    $dataInici = $_POST['dataInici'];
    $dataFi = $_POST['dataFi'];
    $array = $_POST['array'];
    $idioma = $_POST['idioma'];

    if(empty($array)){
        $result = $controlador->selectIdioma($idioma);
    }else{

        $result = $controlador->filtrarCaracteristiques($dataInici, $dataFi, $array,$idioma);
    }
    echo $result;

}else if(isset($_POST['array']) && isset($_POST['idioma'])){

    $dataInici = '';
    $dataFi = '';
    $array = $_POST['array'];
    $idioma = $_POST['idioma'];

    if(empty($array)){
        $result = $controlador->selectIdioma($idioma);
    }else{

    $result = $controlador->filtrarCaracteristiques($dataInici, $dataFi, $array,$idioma);
        }
    echo $result;
}