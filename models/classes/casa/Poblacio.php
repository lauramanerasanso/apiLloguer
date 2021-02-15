<?php


class Poblacio
{

    private $nom;


    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function __construct($database){
        $this->conexio = $database;
    }

    public function insertPoblacio(){

        $stmt = $this->conexio->prepare("INSERT INTO poblacio(nom) SELECT ? FROM dual WHERE NOT EXISTS (SELECT nom FROM poblacio WHERE nom = ? ) LIMIT 1 ");
        $stmt->bind_param("ss", $this->nom,$this->nom);
        $stmt->execute();


        return $stmt;

    }

    public function selectPoblID(){

        $stmt = $this->conexio->prepare("SELECT id FROM poblacio WHERE nom = ?");
        $stmt->bind_param("s", $this->nom);
        $stmt->execute();

        $resultat = $stmt->get_result();
        $row = $resultat->fetch_assoc();
        return $row['id'];

    }
}