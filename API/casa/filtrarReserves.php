<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


$controlador = new controlador_casa();

if(isset($_POST['mes']) && isset($_POST['any']) && !isset($_POST['nom'])) {
    $mes = $_POST['mes'];
    $any = $_POST['any'];

    $controlador->filtrar_mesAny($mes,$any);


} else if( isset($_POST['mes']) && !isset($_POST['any'])  && !isset($_POST['nom'])){

    $mes = $_POST['mes'];

    $controlador->filtrar_mes($mes);

}else if( !isset($_POST['mes']) && isset($_POST['any'])  && !isset($_POST['nom'])){

    $any = $_POST['any'];

    $controlador->filtrar_any($any);

}else if( isset($_POST['mes']) && isset($_POST['any']) && isset($_POST['nom'])){

    $mes = $_POST['mes'];
    $any = $_POST['any'];
    $nom = $_POST['nom'];

    $controlador->filtrar_tot($mes,$any,$nom);

}else if( !isset($_POST['mes']) && isset($_POST['any']) && isset($_POST['nom'])){


    $any = $_POST['any'];
    $nom = $_POST['nom'];

    $controlador->filtrar_anyNom($any,$nom);

}else if( isset($_POST['mes']) && !isset($_POST['any']) && isset($_POST['nom'])){

    $mes = $_POST['mes'];
    $nom = $_POST['nom'];

    $controlador->filtrar_mesNom($mes,$nom);
}

