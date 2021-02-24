<?php

include_once 'models/classes/user/User.php';
include_once('models/config/DataBase.php');
include_once 'controlador/userControlador.php';


if (isset($_POST['email']) && isset($_POST['token'])) {

    $userName = $_POST['email'];
    $token = $_POST['token'];

    $controlador = new userControlador();
    $existeix = $controlador->comprovarlogin($userName, $token);

    if ($existeix) {

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