<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');

$controlador = new controlador_casa();

if(isset($_POST['dataInici']) && isset($_POST['dataFi'])) {

    $dataInici = $_POST['dataInici'];
    $dataFi = $_POST['dataFi'];

    $result = $controlador->selectCasesCerca($dataInici, $dataFi);
    echo $result;
    
}else{

    $result = $controlador->select();
    echo $result;
}