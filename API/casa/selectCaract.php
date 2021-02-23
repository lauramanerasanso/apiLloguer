<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');


$controlador = new controlador_casa();
if(isset($_POST['id']) && isset($_POST['idioma'])) {

    $id = $_POST['id'];
    $idioma = $_POST['idioma'];
    $controlador->mostrarCaracteristiques($id,$idioma);

}

