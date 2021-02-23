<?php


class controlador_data{
    public $dades = [];

    public function arrayDies($id_casa, $mes){
        $db = DataBase::getConn();

        $dates = new Data($db);
        $dates->setIdCasa($id_casa);

        $info = [];

        $dates->setDataFi($mes."-"."01");
        $countDies = $dates->diesMes();


        for ($i = 1 ; $i <= $countDies ; $i++){
            $_data = $mes."-".$i;

            $dates->setDataInici($_data);

            $isReservat = $dates->selectDatesReserva();

            $isBloquetjat = $dates->selectDatesBloqueig();

            $preu = $dates->getPreuDates();

            if($isReservat > 0){
                array_push($info, array("estat"=>"reservat", "preu"=>$preu));

            }else if($isBloquetjat > 0){
                array_push($info, array("estat"=>"bloquetjat", "preu"=>$preu));

            }else{
                array_push($info, array("estat"=>"lliure", "preu"=>$preu));


            }



        }

        echo json_encode( $info );

    }

    public function datesReservat($id_casa, $mes){
        $db = DataBase::getConn();

        $dates = new Data($db);
        $dates->setIdCasa($id_casa);

        $countDies = $dates->diesMes();

        for ($i = 1 ; $i <= $countDies ; $i++){
            $_data = $mes."-".$i;

            $dates->setDataInici($_data);

            $ocupacio = $dates->selectDatesReserva();

            if($ocupacio > 0){
                $this->dades[$i] = array("estat"=>"reservat");
            }else{
                $this->dades[$i] = array("estat"=>"lliure");
            }

        }
    }

    public function datesBloquetjat($id_casa, $mes){
        $db = DataBase::getConn();

        $dates = new Data($db);
        $dates->setIdCasa($id_casa);

        $countDies = $dates->diesMes();

        for ($i = 1 ; $i <= $countDies ; $i++){
            $_data = $mes."-".$i;

            $dates->setDataInici($_data);

            $ocupacio = $dates->selectDatesBloqueig();

            if($ocupacio > 0){
                $this->dades[$i] = array("estat"=>"bloquetjat");
            }else{
                $this->dades[$i] = array("estat"=>"lliure");
            }

        }
    }

    public function intervalDates($id_casa){

        $db = DataBase::getConn();

        $dates = new Data($db);
        $dates->setIdCasa($id_casa);


        $result=$dates->selectDatesReserva();

        $row = $result->fetch_assoc();

        while($row = $result->fetch_assoc()) {
            $anyInici = $row['YEAR(data_inici)'];
            $mesInici = $row['MONTH(data_inici)'];
            $diaInici = $row['DAY(data_inici)'];

            $_data = [
                "year" => $anyInici,
                "month" => $mesInici,
                "day" => $diaInici
            ];;

            $dates->setDataInici($row['data_inici']);
            $dates->setDataFi($row['data_fi']);

            $count = $dates->intervalEnDies();

            $datesReserva = [];

            array_push($datesReserva, $_data);

            for ($i = 0; $i < $count ; $i++){

            }
        }

    }
}