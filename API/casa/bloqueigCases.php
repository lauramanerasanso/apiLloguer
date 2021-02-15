<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');





if(isset($_POST['idCasa']) && isset($_POST['dataInici']) && isset($_POST['dataFi'])){

    $controlador = new controlador_casa();

    $count = $controlador->comprovReserva($_POST['idCasa'],$_POST['dataInici'],$_POST['dataFi']);

    if($count == 0){

        $controlador->insertBloqueig($_POST['idCasa'],$_POST['dataInici'],$_POST['dataFi']);
        $json = [
            'success' => true,
            'data' => $count
        ];
    } else {

        $json = [
            'success' => false,
            'data' => $count
        ];
    }

}

echo json_encode($json);
