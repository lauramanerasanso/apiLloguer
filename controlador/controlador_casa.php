<?php


class controlador_casa
{

    public function select()
    {

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->select();

        $outp = $result->fetch_all(MYSQLI_ASSOC);
        return $outp;


    }

    public function insertCasa($pob, $banys, $hab, $x, $y, $preu, $nom1, $nom2, $desc1, $desc2, $caract)
    {

        $con_db = DataBase::getConn();

        $p = new Poblacio($con_db);
        $casa = new Casa($con_db);

        $p->setNom($pob);
        $afegit = $p->insertPoblacio();

        if (isset($afegit)) {
            $idPob = $p->selectPoblID();
            $insertCasa = $casa->insert($banys, $hab, $x, $y, $idPob, $preu);
        }

        if (isset($insertCasa)) {
            $idCasa = $casa->select_id_max();
            $casa->traduccio($idCasa, $nom1, $desc1, $nom2, $desc2);

            for ($i = 0; $i < count($caract); $i++) {

                $casa->insertCaract($caract[$i], $idCasa);

            }


        }
        if ($insertCasa > 0) {

            return true;

        }else{
            return false;
        }


    }

    public function id_Max()
    {
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);
        return $casa->select_id_max();
    }

    public function inserirFotos($idCasa, $f1, $f2, $f3, $f4, $f5)
    {
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->insertImatges($idCasa, $f1, $f2, $f3, $f4, $f5);
    }


    public function select_casa_nom($id)
    {
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->select_casa_nom($id);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function select_nom($id)
    {
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->select_nom($id);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function select_caract($id)
    {
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->select_caract($id);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

    }

    public function select_info($id)
    {

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->select_info($id);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

    }

    public function updateCasa($idCasa, $pob, $banys, $hab, $x, $y, $preu, $nom1, $nom2, $desc1, $desc2, $caract)
    {

        $con_db = DataBase::getConn();
        $p = new Poblacio($con_db);
        $casa = new Casa($con_db);

        $p->setNom($pob);
        $afegit = $p->insertPoblacio();

        if (isset($afegit)) {
            $idPob = $p->selectPoblID();
            $update = $casa->updateCasa($idCasa, $banys, $hab, $x, $y, $idPob, $preu);
        }

        if (isset($update)) {
            $casa->deleteCaract($idCasa);

            for ($i = 0; $i < count($caract); $i++) {

                $upcaract = $casa->insertCaract($caract[$i], $idCasa);
            }

            $upd1 = $casa->updateTraduccio($idCasa, $desc1, $nom1, "CA");
            $upd2 = $casa->updateTraduccio($idCasa, $desc2, $nom2, "EN");


        }

        if ($update > 0 || $upcaract > 0 || $upd1 > 0 || $upd2 > 0) {

            return true;

        }else{
            return false;
        }


    }
    public function insertBloqueig($idCasa, $dataInici, $dataFi)
    {

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->inserirBloqueig($idCasa, $dataInici, $dataFi);

    }

    public function comprovReserva($idCasa, $dataInici, $dataFi)
    {

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        return $casa->comprovarReserva($idCasa, $dataInici, $dataFi);
    }

    public function insertTarifa($idCasa, $preuTarifa, $dataInici, $dataFi, $nomTarifa){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $resultat = false;

        if($casa->comprovarDatesTarifa($idCasa, $dataInici, $dataFi) == 0){

            $casa->inserirTarifa($idCasa, $preuTarifa, $dataInici, $dataFi, $nomTarifa);

            $resultat = true;
        }
        return $resultat;

    }

    public function selectNomTarifes($id){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->seleccionarNomTarifes($id);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function selectTarifes($id){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->setId($id);

        $result = $casa->selectTarifes();

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

    }

    public function selectUnaTarifa($id, $dataInici){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->setId($id);


        $result = $casa->selectUnaTarifa($dataInici);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

    }

    public function deleteTarifa($id, $dataInici, $nom){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->setId($id);

        $result = $casa->deleteTarifa($dataInici, $nom);

        echo $result;
    }

    public function updateAppTarifa($id, $dataInici, $dataIniciNew, $dataFi, $dataFiNew, $nom, $nomNew, $preuNew){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $resultat = false;

        $casa->setId($id);

        if ($casa->comprovarDatesTarifa($id, $dataIniciNew, $dataFiNew) == 0){

            $casa->updateAplicacioTarifa($dataInici, $dataIniciNew, $dataFiNew, $nom);

            $casa->updateNomPreuTarifa($nom, $nomNew, $preuNew);

            $resultat = true;

        }elseif ($dataInici == $dataIniciNew || $dataFi == $dataFiNew){

            $casa->deleteTarifa($dataInici, $nom);

            $casa->inserirTarifa($id, $preuNew, $dataIniciNew, $dataFiNew, $nomNew);

            $casa->updateNomPreuTarifa($nom, $nomNew, $preuNew);

            $resultat = true;
        }

        return $resultat;

    }

    public function selectBloq($id){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->setId($id);

        $result = $casa->selectBloq();

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

    }

    public function updateBloq($id, $dataInici, $dataIniciNew, $dataFiNew){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->setId($id);

        $casa->updateBloq($dataInici, $dataIniciNew, $dataFiNew);

        return true;

    }

    public function deleteBloq($id, $dataInici){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $casa->setId($id);

        $casa->deleteBloq($dataInici);

        return true;

    }


    public function carregaReservesTaula(){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->carregarReserves();

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function filtrar_mesAny($mes,$any){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->reserves_mesAny($mes,$any);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }


    public function filtrar_mes($mes){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->reserves_mes($mes);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }


    public function filtrar_any($any){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->reserves_any($any);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }



    public function filtrar_anyNom($any ,$nom){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->reserves_anyNom($any,$nom);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }


    public function filtrar_mesNom($mes,$nom){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->reserves_mesNom($mes,$nom);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }


    public function filtrar_tot($mes,$any,$nom){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->reserves_tot($mes,$any,$nom);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function select_graficPie(){
        $con_db = DataBase::getConn();

        $casa = new Casa($con_db);

        $result = $casa->select_graficPie();

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function select_graficBar(){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->select_graficBar();

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

    }

    public function selectCasesCerca($dataInici, $dataFi,$idioma){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->selectCasesCerca($dataInici, $dataFi,$idioma);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function selectCaract($idIdioma){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->selectCaract($idIdioma);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function filtrarCaracteristiques($dataInici, $dataFi, $caracteristiques, $idioma){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);
        
        $result = $casa->filtrarCaracteristiques($dataInici, $dataFi, $caracteristiques, $idioma);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function selectCasa($id,$idioma){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);
        $result = $casa->selectCasa($id,$idioma);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function mostrarCaracteristiques($id,$idioma){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);
        $result = $casa->selectCaracteristiques($id,$idioma);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function selectIdioma($idioma)
    {

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->selectIdioma($idioma);

        $outp = $result->fetch_all(MYSQLI_ASSOC);
        return json_encode($outp);


    }
    public function mostrarReserves($token,$idioma,$data)
    {

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->mostrarReserves($token,$idioma,$data);

        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);


    }

    public function proximesReserves($token,$idioma,$data){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->proximesReserves($token,$idioma,$data);

        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);


    }

    public function selectReserva($idioma, $data_inici, $idCasa){

        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->selectReserva($idioma, $data_inici, $idCasa);

        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);
    }

    public function insertReserva($id_casa, $token, $data_inici, $data_fi, $preu_final){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);
        $user = new User($con_db);

        $casa->setId($id_casa);

        $data_reserva = date("Y-m-d",time());

        $id_usuari = $user->getIdFromToken($token);
        
        $codiPag = time();

        $result = $casa->insertReserva($id_usuari, $data_inici, $data_fi, $data_reserva, $preu_final, $codiPag );

        if($result > 0){
            return json_encode($codiPag);
        }else{
            return json_encode("ERROR");
        }

        
    }

    public function deleteReserva($codiPag){
        $con_db = DataBase::getConn();
        $casa = new Casa($con_db);

        $result = $casa->deleteReserva($codiPag);
        if($result > 0){
            return json_encode("RESERVA ELIMINADA");
        }else{
            return json_encode("ERROR");
        }
    }

}
