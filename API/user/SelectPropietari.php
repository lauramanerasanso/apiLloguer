<?php
include_once('controlador/userControlador.php');
include_once('models/config/DataBase.php');
include_once('models/classes/user/User.php');



$controlador = new userControlador();
$result = $controlador->selectPropietari();
echo json_encode($result);
