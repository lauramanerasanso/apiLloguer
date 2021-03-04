<?php


class User{
    protected $conn;

    private $id;
    private $userName;
    private $password;

    public function __construct($db){
        $this->conn = $db;
    }

    public function setId($codi){
        $this->id=$codi;
    }

    public function setUserName($username){
        $this->userName=$username;
    }

    public function setPassword($passwd){
        $this->password=$passwd;
    }

    public function autenticacio(){
        $sql = "SELECT count(*) FROM propietari WHERE nomusuari=? AND contrasenya = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->userName,$this->password);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        return $row['count(*)'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function checkPasswd(){
        $sql = "SELECT contrasenya FROM propietari WHERE id = 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function changePasswd(){
        $sql = "UPDATE propietari SET contrasenya = ? WHERE id = 1;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->password);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function create(){
        $sql = "INSERT INTO users(user_name, privileges) VALUES(?,?);";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->user_name, $this->privileges);
        $stmt->execute();

        return $stmt;

    }

    public function update(){
        $sql = " UPDATE users SET user_name=?, privileges=? WHERE id=? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $this->user_name, $this->privileges, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function delete(){
        $sql = " DELETE FROM users WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function loginClient(){
        $sql = "SELECT token FROM usuari WHERE email=? AND contrasenya = ? AND verificat != 0";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->userName,$this->password);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if(!isset($row['token'])){
            return false;
        }

        return $row['token'];
    }

    public function comprovarLogin($token){
        $sql = "SELECT count(*) FROM usuari WHERE email=? AND token = ? AND verificat != 0";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->userName,$token);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        return $row['count(*)'];
    }
    public function selectPass($token){
        $sql = "SELECT contrasenya FROM usuari WHERE token = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $token);

        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['contrasenya'];
    }

    public function selectID($token){
        $sql = "SELECT id FROM usuari WHERE token = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $token);

        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['id'];

    }

    public function canviarPass($id){
        $sql = "UPDATE usuari SET contrasenya = ? WHERE id = ?;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->password,$id);
        $stmt->execute();



        return $stmt->affected_rows;
    }
}