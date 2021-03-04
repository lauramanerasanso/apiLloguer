<?php

class controlador_client{
  public function insertClient($nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $poblacio)

  {

      $con_db = DataBase::getConn();

      $p = new Poblacio($con_db);
      $client = new Client($con_db);

      $p->setNom($poblacio);
      $afegit = $p->insertPoblacio();
      $existeix = $client->existeixClient($email);

if (!$existeix){

      if (isset($afegit)) {

          $idPob = $p->selectPoblID();
          $token = bin2hex(openssl_random_pseudo_bytes(32));
          $insertClient = $client->createClient($nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $idPob, $token);
          $s = "OK";
      }

    } else {

$s = "ERROR";

    }

echo $s;

  }

}
