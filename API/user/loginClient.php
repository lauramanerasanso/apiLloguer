<?php
include_once 'models/classes/user/User.php';
include_once('models/config/DataBase.php');
include_once 'controlador/userControlador.php';


if (isset($_POST['usuari']) && isset($_POST['password'])) {

    $userName = $_POST['usuari'];
    $passwd = $_POST['password'];

    $controlador = new userControlador();
    $token = $controlador->login($userName, $passwd);


    if ($token != "") {

    
        echo json_encode([
            'success' => true,
            'token' => $token,
            'email' => $userName
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);

    }


}