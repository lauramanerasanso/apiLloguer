<?php


class userControlador
{

    public function checkAuth($userName, $passwd)
    {

        $db = DataBase::getConn();

        $user = new User($db);
        $user->setUserName($userName);
        $user->setPassword($passwd);

        $result = $user->autenticacio();


        if ($result > 0) {

            return true;

        }

        return false;

    }

    public function changePassword($oldPasswd, $newPasswd)
    {
        $db = DataBase::getConn();

        $user = new User($db);
        $user->setPassword($oldPasswd);

        $result = $user->checkPasswd();

        $row = $result->fetch_assoc();

        if ($oldPasswd == $row['contrasenya']) {
            $user1 = new User($db);
            $user1->setPassword($newPasswd);
            $res = $user1->changePasswd();
            $s = "OK";

        } else {

            $s = "ERROR";
        }
        echo json_encode($s);
    }

    public function login($userName, $passwd)
    {

        $db = DataBase::getConn();

        $user = new User($db);
        $user->setUserName($userName);
        $user->setPassword($passwd);

        $result = $user->loginClient();


        return $result;

    }

    public function comprovarlogin($email,$token)
    {

        $db = DataBase::getConn();

        $user = new User($db);
        $user->setUserName($email);


        $result = $user->comprovarLogin($token);

        if($result > 0){
            return true;
        }

        return false;

    }

    public function canviarPasswordCLient($token,$actual, $nova)
    {
        $db = DataBase::getConn();

        $user = new User($db);
        $user->setPassword($actual);

        $result = $user->selectPass($token);



        if ($actual == $result) {
            $user1 = new User($db);
            $user1->setPassword($nova);
            $id = $user1->selectID($token);
            $res = $user1->canviarPass($id);

            if ($res > 0) {

                return true;

            }else{
                return false;
            }



        } else {

           return false;
        }

}