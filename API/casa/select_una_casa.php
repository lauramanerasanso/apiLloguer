<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');


$controlador = new controlador_casa();

if(isset($_GET['id'])){
    $controlador->select_casa_nom($_GET['id']);
}

if(isset($_GET['codi'])){
    $controlador->select_caract($_GET['codi']);
}
if(isset($_GET['idCasa'])){
    $controlador->select_info($_GET['idCasa']);
}

if(isset($_GET['id_casa'])){
    $controlador->select_nom($_GET['id_casa']);
}
