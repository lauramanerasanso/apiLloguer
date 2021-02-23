<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


$controlador = new controlador_casa();
$controlador->select_graficPie();