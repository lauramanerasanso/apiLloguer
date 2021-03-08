<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');


$controlador = new controlador_casa();
if(isset($_POST['token']) && isset($_POST['idioma']) && isset($_POST['data'])) {

        // the message
        $msg = "Missatge de prova!";

        // send email
        mail("lauraams99@gmail.com","Estàs mirant les reserves",$msg);
        
    $token = $_POST['token'];
    $idioma = $_POST['idioma'];
    $data = $_POST['data'];
    $controlador->proximesReserves($token,$idioma,$data);

}


