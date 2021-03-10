<?php


class Data{
    protected $conn;

    private $id_casa;
    private $data_inici;
    private $data_fi;

    /**
     * @return mixed
     */
    public function getIdCasa()
    {
        return $this->id_casa;
    }

    /**
     * @param mixed $id_casa
     */
    public function setIdCasa($id_casa)
    {
        $this->id_casa = $id_casa;
    }

    /**
     * @return mixed
     */
    public function getDataInici()
    {
        return $this->data_inici;
    }

    /**
     * @param mixed $data_inici
     */
    public function setDataInici($data_inici)
    {
        $this->data_inici = $data_inici;
    }

    /**
     * @return mixed
     */
    public function getDataFi()
    {
        return $this->data_fi;
    }

    /**
     * @param mixed $data_fi
     */
    public function setDataFi($data_fi)
    {
        $this->data_fi = $data_fi;
    }


    public function __construct($db){
        $this->conn = $db;
    }

    public function selectDatesReserva(){
        $sql = "SELECT count(*) as num FROM reserva WHERE casa_id=? AND NOT (reserva.id = 0) AND ( ? BETWEEN data_inici AND data_fi);";

        //SELECT data_inici, data_fi FROM bloqueig WHERE casa_id=? AND data_inici > CURRENT_DATE() OR data_fi > CURRENT_DATE()

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $this->id_casa, $this->data_inici);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['num'];
    }

    public function selectDatesBloqueig(){
        $sql = "SELECT count(*) as num FROM bloqueig WHERE casa_id=? AND (? BETWEEN data_inici AND data_fi);";

        //SELECT data_inici, data_fi FROM bloqueig WHERE casa_id=? AND data_inici > CURRENT_DATE() OR data_fi > CURRENT_DATE()

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $this->id_casa, $this->data_inici);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['num'];
    }

    public function getPreuDates(){
        $sql = "SELECT IFNULL((SELECT preu_tarifa FROM tarifa WHERE (? BETWEEN data_inici AND data_fi) AND casa_id = ?), (SELECT tarifaDefault FROM casa WHERE id = ?)) as preu";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $this->data_inici, $this->id_casa, $this->id_casa);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        return $row['preu'];


    }

    public function intervalEnDies(){

        $sql = "SELECT DATEDIFF(?,?) AS inter";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->data_fi, $this->data_inici);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['inter'];
    }

    public function treuTotsElsDies(){
        $sql = "SELECT DATE_ADD(?,INTERVAL 1 DAY) as dia;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->data_inici);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['dia'];
    }

    public function diesMes(){
        $sql = "SELECT DAY(LAST_DAY(?)) as dia;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->data_fi);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['dia'];
    }

    public function selectPreuTarifaPerDia(){
        $sql = "SELECT tarifa.preu_tarifa FROM tarifa WHERE ? BETWEEN tarifa.data_inici AND tarifa.data_fi AND tarifa.casa_id = ?;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->data_inici, $this->id_casa);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function selectPreuTarifaDefault(){
        $sql = "SELECT casa.tarifaDefault FROM casa WHERE casa.id = ?;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id_casa);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['tarifaDefault'];
    }

    public function whileDates($row){
        $anyInici = $row['YEAR(data_inici)'];
        $mesInici = $row['MONTH(data_inici)'];
        $diaInici = $row['DAY(data_inici)'];
        if(strlen($mesInici)===1){
            $mesInici = "0".$mesInici;
        }
        if(strlen($diaInici)===1){
            $diaInici = "0".$diaInici;
        }
        $_data = $anyInici."-".$mesInici."-".$diaInici;
        return $_data;
    }

    public function selectDatesReservaFront(){

        $sql = "SELECT YEAR(data_inici), MONTH(data_inici), DAY(data_inici), data_inici, data_fi FROM reserva WHERE NOT (reserva.id = 0) AND casa_id=? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id_casa);
        $stmt->execute();

        $result = $stmt->get_result();
        

        return $result;
    }

    public function selectDatesBloqueigFront(){
        $sql = "SELECT YEAR(data_inici), MONTH(data_inici), DAY(data_inici), data_inici, data_fi FROM bloqueig WHERE casa_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id_casa);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }
}

