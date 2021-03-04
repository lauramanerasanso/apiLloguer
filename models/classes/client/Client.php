<?php


class Client{
    protected $conexio;

    private $id;
    private $clientName;
    private $password;

    public function __construct($db){
        $this->conexio = $db;
    }

    public function setId($codi){
        $this->id=$codi;
    }

    public function setClientName($clientName){
        $this->clientName=$clientname;
    }

    public function setPassword($passwd){
        $this->password=$passwd;
    }

    public function createClient($nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $idPob, $token){

      $stmt = $this->conexio->prepare("INSERT INTO usuari (nom, llinatge1, llinatge2, DNI, telefon, email, contrasenya, poblacio_id, token) VALUES (?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param("ssssissis", $nom, $llinatge1, $llinatge2, $DNI, $telefon, $email, $password, $idPob, $token);
      $stmt->execute();

      return $stmt;
    }

    public function select_info_client($id)
    {

        $stmt = $this->conexio->prepare("SELECT usuari.nom, usuari.llinatge1, usuari.llinatge2, usuari.DNI, poblacio.nom, usuari.telefon, usuari.email, usuari.contrasenya, usuari.token FROM usuari JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE usuari.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function existeixClient ($email)
    {

      $stmt = $this->conexio->prepare("SELECT usuari.email FROM usuari WHERE usuari.email = ?");
      $stmt->bind_param("s",$email);
      $stmt->execute();

      $resultat = $stmt->get_result();
      return $resultat->num_rows;

    }

  }
