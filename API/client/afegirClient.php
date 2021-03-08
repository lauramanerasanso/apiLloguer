<?php

include_once('controlador/controlador_client.php');
include_once('models/config/DataBase.php');
include_once('models/classes/client/Client.php');
include_once('models/classes/casa/Poblacio.php');

//$nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $poblacio


if(isset($_POST['nom']) && isset($_POST['llinatge1']) && isset($_POST['llinatge2']) && isset($_POST['DNI']) && isset($_POST['telefon']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['poblacio'])){


    $controlador = new controlador_client();

    $nom = $_POST['nom'];
    $llinatge1 = $_POST['llinatge1'];
    $llinatge2 = $_POST['llinatge2'];
    $DNI = $_POST['DNI'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $poblacio = $_POST['poblacio'];

    $idClient =  $controlador->insertClient($nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $poblacio);

    // the message
    $msg = "T'has registrat a MallorcaRustic.me!";

    // send email
    mail($email,"Registre",$msg);

} else if (isset($_POST['nom']) && isset($_POST['llinatge1']) && isset($_POST['llinatge2']) && isset($_POST['DNI']) && !isset($_POST['telefon']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['poblacio'])){

  $controlador = new controlador_client();

  $nom = $_POST['nom'];
  $llinatge1 = $_POST['llinatge1'];
  $llinatge2 = $_POST['llinatge2'];
  $DNI = $_POST['DNI'];
  $telefon = '0';
  $email = $_POST['email'];
  $password = $_POST['password'];
  $poblacio = $_POST['poblacio'];

  $idClient =  $controlador->insertClient($nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $poblacio);
  // the message
  $msg = "T'has registrat a MallorcaRustic.me !";

  // send email
  mail($email,"Registre",$msg);
}
