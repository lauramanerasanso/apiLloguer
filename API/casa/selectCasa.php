<?php

include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');


$controlador = new controlador_casa();
$result = $controlador->select();
echo json_encode($result);
