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
        
        $datesReserva = [];

        $result=$dates->selectDatesReservaFront();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                $_data = $dates->whileDates($row);

                $dates->setDataInici($row['data_inici']);
                $dates->setDataFi($row['data_fi']);

                $count = $dates->intervalEnDies();

                array_push($datesReserva, $_data);

                for ($i = 0; $i < $count ; $i++){
                    
                    $_datan = $dates->treuTotsElsDies();
                    $dates->setDataInici($_datan);

                    array_push($datesReserva, $_datan);
                }
            }
        }
        
        $resultat=$dates->selectDatesBloqueigFront();

        if ($resultat->num_rows > 0) {
            while($row = $resultat->fetch_assoc()) {

                $_data = $dates->whileDates($row);

                $dates->setDataInici($row['data_inici']);
                $dates->setDataFi($row['data_fi']);

                $count = $dates->intervalEnDies();

                array_push($datesReserva, $_data);

                for ($i = 0; $i < $count ; $i++){
                   
                    $_datan = $dates->treuTotsElsDies();
                    $dates->setDataInici($_datan);

                    array_push($datesReserva, $_datan);
                }
            }
        }
        return $datesReserva;
    }

    public function preuTotalDates($id_casa, $dataInici, $dataFi){

        $db = DataBase::getConn();

        $dates = new Data($db);

        $dates->setIdCasa($id_casa);
        $dates->setDataInici($dataInici);
        $dates->setDataFi($dataFi);

        $preuTotal = 0;

        $result = $dates->selectPreuTarifaPerDia();

        if (mysqli_num_rows($result)==0) {
            
            $preuTotal += $dates->selectPreuTarifaDefault();

        }else{
            $row = $result->fetch_assoc();

            $preuTotal += $row['preu_tarifa'];
        }

        $count = $dates->intervalEnDies();

        for ($i = 0; $i < $count -1 ; $i++){
            $_datan = $dates->treuTotsElsDies();
            $dates->setDataInici($_datan);
            $result = $dates->selectPreuTarifaPerDia();

            if (mysqli_num_rows($result)==0) {
                $preuTotal += $dates->selectPreuTarifaDefault();
            }else{
                $row = $result->fetch_assoc();
                $preuTotal += $row['preu_tarifa'];
            }
        }
        return $preuTotal;
    }
}