<?php


class casa
{


    protected $conexio;
    private $id;
    private $nom;
    private $desc;
    private $banys;
    private $hab;

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function __construct($database)
    {
        $this->conexio = $database;
    }


    public function select()
    {

        $query = "SELECT casa.id, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, imatge.img_principal, casa.nBanys, casa.nHabitacions FROM casa JOIN traduccioCasa ON casa.id = traduccioCasa.casa_id JOIN imatge ON casa.id = imatge.casa_id WHERE traduccioCasa.idioma_id='CA';";

        $stmt = $this->conexio->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;

    }

    public function insert($nBanys, $nHab, $x, $y, $pob, $tarifa)
    {


        $stmt = $this->conexio->prepare("INSERT INTO casa (nBanys, nHabitacions, x, y, poblacio_id , propietari_persona_id, tarifaDefault) VALUES (?,?,?,?,?,1,?)");
        $stmt->bind_param("iiddid", $nBanys, $nHab, $x, $y, $pob, $tarifa);
        $stmt->execute();


        return $stmt;

    }


    public function select_id_max()
    {

        $query = "SELECT MAX(id) AS id FROM casa";

        $stmt = $this->conexio->prepare($query);
        $stmt->execute();

        $resultat = $stmt->get_result();
        $row = $resultat->fetch_assoc();

        return $row['id'];

    }

    public function insertImatges($id, $i1, $i2, $i3, $i4, $i5)
    {
        $stmt = $this->conexio->prepare("INSERT INTO imatge VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssssi", $i1, $i2, $i3, $i4, $i5, $id);
        $stmt->execute();


        return $stmt;
    }

    public function insertCaract($idCaract, $idCasa)
    {
        $stmt = $this->conexio->prepare("INSERT INTO caracteristicaCasa VALUES (?,?)");
        $stmt->bind_param("ii", $idCasa, $idCaract);
        $stmt->execute();


        return $stmt;

    }

    public function traduccio($idCasa, $nom1, $desc1, $nom2, $desc2)
    {

        $stmt = $this->conexio->prepare("INSERT INTO traduccioCasa VALUES (?, 'CA', ?, ?), (?,'EN',?,?)");
        $stmt->bind_param("ississ", $idCasa, $desc1, $nom1, $idCasa, $desc2, $nom2);
        $stmt->execute();


        return $stmt;

    }


    public function select_casa_nom($id)
    {

        $stmt = $this->conexio->prepare("SELECT traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio FROM casa JOIN traduccioCasa ON traduccioCasa.casa_id=casa.id WHERE casa.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;

    }

    public function select_nom($id)
    {

        $stmt = $this->conexio->prepare("SELECT traduccioCasa.traduccioNom FROM casa JOIN traduccioCasa ON traduccioCasa.casa_id=casa.id WHERE casa.id = ? AND traduccioCasa.idioma_id = 'CA'");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;

    }

    public function select_caract($id)
    {

        $stmt = $this->conexio->prepare("SELECT caracteristicaCasa.caracteristica_id FROM casa JOIN caracteristicaCasa ON caracteristicaCasa.casa_id = casa.id WHERE casa.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;

    }

    public function select_info($id)
    {

        $stmt = $this->conexio->prepare("SELECT casa.nHabitacions, casa.nBanys, casa.x, casa.y, poblacio.nom, casa.tarifaDefault FROM casa JOIN poblacio ON poblacio.id = casa.poblacio_id WHERE casa.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function updateCasa($idCasa, $nBanys, $nHab, $x, $y, $pob, $tarifa)
    {


        $stmt = $this->conexio->prepare("UPDATE casa SET nBanys = ?, nHabitacions = ?, x = ?, y = ? , poblacio_id = ? , tarifaDefault = ? WHERE id = ?");
        $stmt->bind_param("iiddidi", $nBanys, $nHab, $x, $y, $pob, $tarifa, $idCasa);
        $stmt->execute();


        return $stmt;

    }

    public function deleteCaract($idCasa)
    {
        $stmt = $this->conexio->prepare("DELETE FROM caracteristicaCasa WHERE casa_id = ?");
        $stmt->bind_param("i", $idCasa);
        $stmt->execute();


        return $stmt;
    }

    public function updateTraduccio($idCasa, $desc, $nom, $idioma)
    {

        $stmt = $this->conexio->prepare("UPDATE traduccioCasa SET tradDescripcio = ?, traduccioNom = ? WHERE casa_id = ? AND idioma_id = ?");
        $stmt->bind_param("ssis", $desc, $nom, $idCasa, $idioma);
        $stmt->execute();


        return $stmt;
    }


    public function inserirBloqueig($idCasa, $dataInici, $dataFi)
    {

        $stmt = $this->conexio->prepare("INSERT INTO bloqueig VALUES(?,?,?)");
        $stmt->bind_param("ssi", $dataInici, $dataFi, $idCasa);
        $stmt->execute();

        return $stmt;

    }

    public function comprovarReserva($idCasa, $dataInici, $dataFi)
    {

        $stmt = $this->conexio->prepare("SELECT count(*) FROM reserva JOIN bloqueig ON bloqueig.casa_id=reserva.casa_id WHERE (reserva.data_fi BETWEEN (?) AND (?)) OR (reserva.data_inici BETWEEN (?) AND (?)) AND reserva.casa_id=?");
        $stmt->bind_param("ssssi", $dataInici, $dataFi, $dataInici, $dataFi, $idCasa);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        return $row['count(*)'];

    }

    public function comprovarDatesTarifa($idCasa, $dataInici, $dataFi){

        $stmt = $this->conexio->prepare("SELECT count(*) FROM tarifa WHERE ((? BETWEEN tarifa.data_inici AND tarifa.data_fi) OR (? BETWEEN tarifa.data_inici AND tarifa.data_fi) OR (tarifa.data_inici BETWEEN ? AND ?)) AND tarifa.casa_id = ?");
        $stmt->bind_param("ssssi", $dataInici, $dataFi, $dataInici, $dataFi, $idCasa);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        return $row['count(*)'];

    }

    public function inserirTarifa($idCasa, $preuTarifa, $dataInici, $dataFi, $nomTarifa){

        $stmt = $this->conexio->prepare("INSERT INTO tarifa VALUES(?,?,?,?,?)");
        $stmt->bind_param("idsss",$idCasa, $preuTarifa, $dataInici, $dataFi, $nomTarifa);
        $stmt->execute();

        return $stmt;

    }

    public function seleccionarNomTarifes($id){

        $stmt = $this->conexio->prepare("SELECT nom_tarifa, preu_tarifa FROM tarifa WHERE casa_id = ? group by nom_tarifa");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;

    }


    public function selectTarifes(){

        $stmt = $this->conexio->prepare("SELECT * FROM tarifa WHERE casa_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function selectUnaTarifa($dataInici){

        $stmt = $this->conexio->prepare("SELECT * FROM tarifa WHERE casa_id = ? AND data_inici = ?");
        $stmt->bind_param("i", $this->id, $dataInici);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function updateAplicacioTarifa($dataInici, $dataIniciNew, $dataFiNew, $nom){
        $stmt = $this->conexio->prepare("UPDATE tarifa SET tarifa.data_inici = ?, tarifa.data_fi = ? WHERE tarifa.data_inici = ? AND tarifa.nom_tarifa = ? AND tarifa.casa_id = ?;");
        $stmt->bind_param("ssssi", $dataIniciNew, $dataFiNew, $dataInici, $nom,$this->id);
        $stmt->execute();

        return $stmt;
    }

    public function updateNomPreuTarifa($nom, $nomNew, $preuNew){
        $stmt = $this->conexio->prepare("UPDATE tarifa SET tarifa.nom_tarifa = ?, tarifa.preu_tarifa = ? WHERE tarifa.nom_tarifa = ? AND tarifa.casa_id = ?;");
        $stmt->bind_param("sssi", $nomNew, $preuNew, $nom, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function deleteTarifa($dataInici, $nom){
        $stmt = $this->conexio->prepare("DELETE FROM tarifa WHERE tarifa.nom_tarifa = ? AND tarifa.data_inici = ? AND tarifa.casa_id = ? ;");
        $stmt->bind_param("ssi", $nom, $dataInici, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function selectBloq(){
        $stmt = $this->conexio->prepare("SELECT * FROM bloqueig WHERE casa_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function updateBloq($dataInici, $dataIniciNew, $dataFiNew){
        $stmt = $this->conexio->prepare("UPDATE bloqueig SET bloqueig.data_inici = ?, bloqueig.data_fi = ? WHERE bloqueig.data_inici = ? AND bloqueig.casa_id = ?;");
        $stmt->bind_param("sssi", $dataIniciNew, $dataFiNew, $dataInici, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function deleteBloq($dataInici){
        $stmt = $this->conexio->prepare("DELETE FROM bloqueig WHERE bloqueig.data_inici = ? AND bloqueig.casa_id = ? ;");
        $stmt->bind_param("si", $dataInici, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function carregarReserves()
    {

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA'");
        $stmt->execute();
        $resultat = $stmt->get_result();

        return $resultat;
    }
    public function reserves_mesAny($mes,$any){

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA' AND month(reserva.data_inici) = ? AND year(reserva.data_inici) = ?");
        $stmt->bind_param("ii", $mes,$any);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function reserves_mes($mes){

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA' AND month(reserva.data_inici) = ?");
        $stmt->bind_param("i", $mes);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function reserves_any($any){

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA' AND year(reserva.data_inici) = ?");
        $stmt->bind_param("i", $any);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function reserves_mesNom($mes,$nom){

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA' AND month(reserva.data_inici) = ? AND traducciocasa.traduccioNom = ?");
        $stmt->bind_param("is", $mes,$nom);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function reserves_anyNom($any,$nom){

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA' AND year(reserva.data_inici) = ? AND traducciocasa.traduccioNom = ?");
        $stmt->bind_param("is", $any,$nom);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }


    public function reserves_tot($mes,$any,$nom){

        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, reserva.data_inici, reserva.data_fi, usuari.nom as nomUsuari, usuari.llinatge1, usuari.llinatge2, usuari.DNI, usuari.telefon, usuari.email, usuari.poblacio_id, poblacio.nom as nomPoblacio, reserva.preu_final, data_reserva FROM reserva JOIN casa ON casa.id = reserva.casa_id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id JOIN usuari ON reserva.usuari_id = usuari.id  JOIN poblacio ON poblacio.id = usuari.poblacio_id WHERE NOT (reserva.id = 0) AND traduccioCasa.idioma_id = 'CA' AND month(reserva.data_inici) = ? AND year(reserva.data_inici) = ? AND traducciocasa.traduccioNom = ?");
        $stmt->bind_param("iis", $mes,$any,$nom);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }


    public function select_graficPie(){

        $stmt = $this->conexio->prepare("SELECT count(reserva.casa_id) as cont, traduccioCasa.traduccioNom  from reserva, traduccioCasa WHERE traduccioCasa.casa_id = reserva.casa_id and traduccioCasa.idioma_id = 'CA' GROUP BY reserva.casa_id;");
        
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function select_graficBar(){
        $stmt = $this->conexio->prepare("SELECT count(*) as num FROM reserva GROUP BY month(data_inici)");
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function selectCasesCerca($dataInici, $dataFi,$idioma){
                //SELECT casa.id, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, imatge.img_principal, casa.nBanys, casa.nHabitacions FROM casa JOIN traduccioCasa ON casa.id = traduccioCasa.casa_id JOIN imatge ON casa.id = imatge.casa_id WHERE traduccioCasa.idioma_id='CA' AND casa.id NOT IN (SELECT casa_id FROM reserva WHERE ('2021-03-01' BETWEEN data_inici AND data_fi ) OR ('2021-03-29' BETWEEN data_inici AND data_fi ) OR ( data_inici BETWEEN '2021-03-01' AND '2021-03-29' ));
        $query = "SELECT casa.id, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, imatge.img_principal, casa.nBanys, casa.nHabitacions FROM casa JOIN traduccioCasa ON casa.id = traduccioCasa.casa_id JOIN imatge ON casa.id = imatge.casa_id WHERE traduccioCasa.idioma_id=? AND casa.id NOT IN (SELECT casa_id FROM reserva WHERE ((?) BETWEEN data_inici AND data_fi ) OR ((?) BETWEEN data_inici AND data_fi ) OR ( data_inici BETWEEN (?) AND (?) ))";

        $stmt = $this->conexio->prepare($query);
        $stmt->bind_param("sssss", $idioma ,$dataInici, $dataFi, $dataInici, $dataFi);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function selectCaract($idIdioma){
        $query = "SELECT * FROM traduccioCaracteristica WHERE idioma_id = ? ";

        $stmt = $this->conexio->prepare($query);
        $stmt->bind_param("s", $idIdioma);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function filtrarCaracteristiques($dataInici, $dataFi, $caract,$idioma){
        $caracteristiques = explode(",", $caract);

        $filtreCaract = '';

        for($i = 0 ; $i < count($caracteristiques) ; $i++){
            $filtreCaract .= " AND caracteristicaCasa.caracteristica_id = ". $caracteristiques[$i] ." ";
        }

        $query1 = "SELECT casa.id, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, imatge.img_principal, casa.nBanys, casa.nHabitacions 
        FROM casa JOIN traduccioCasa ON casa.id = traduccioCasa.casa_id 
        JOIN imatge ON casa.id = imatge.casa_id 
        JOIN caracteristicaCasa ON caracteristicaCasa.casa_id = casa.id 
        WHERE traduccioCasa.idioma_id='CA' AND casa.id NOT IN 
        (SELECT casa_id FROM reserva WHERE ((?) BETWEEN data_inici AND data_fi ) OR ((?) BETWEEN data_inici AND data_fi ) OR ( data_inici BETWEEN (?) AND (?) )) 
        ".$filtreCaract." GROUP BY casa.id";
        

        
        $stmt = $this->conexio->prepare("SELECT casa.id, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, imatge.img_principal, casa.nBanys, casa.nHabitacions 
        FROM casa JOIN traduccioCasa ON casa.id = traduccioCasa.casa_id 
        JOIN imatge ON casa.id = imatge.casa_id 
        JOIN caracteristicaCasa ON caracteristicaCasa.casa_id = casa.id 
        WHERE traduccioCasa.idioma_id=? AND casa.id NOT IN 
        (SELECT casa_id FROM reserva WHERE ((?) BETWEEN data_inici AND data_fi ) OR ((?) BETWEEN data_inici AND data_fi ) OR ( data_inici BETWEEN (?) AND (?) )) 
        AND caracteristicaCasa.caracteristica_id IN (".$caract.") GROUP BY casa.id");
        
        $stmt->bind_param("sssss",$idioma, $dataInici, $dataFi, $dataInici, $dataFi);
        $stmt->execute();

        $result = $stmt->get_result();
        
        return $result;
    }

    public function selectCasa($id,$idioma){
        $stmt = $this->conexio->prepare("SELECT casa.id, casa.nBanys, casa.nHabitacions, casa.x, casa.y, poblacio.nom, imatge.img_principal, imatge.img_2, imatge.img_3, imatge.img_4, imatge.img_5, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio FROM casa JOIN poblacio ON poblacio.id=casa.poblacio_id JOIN imatge ON imatge.casa_id = casa.id JOIN traduccioCasa ON traduccioCasa.casa_id = casa.id WHERE traduccioCasa.idioma_id = ? AND casa.id = ?;");
        $stmt->bind_param("si", $idioma,$id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function selectCaracteristiques($id,$idioma){
        $stmt = $this->conexio->prepare("SELECT traduccioCaracteristica.caracteristica_id, traduccioCaracteristica.traduccioNom FROM traduccioCaracteristica JOIN caracteristicaCasa ON traduccioCaracteristica.caracteristica_id = caracteristicaCasa.caracteristica_id WHERE traduccioCaracteristica.idioma_id = ? AND caracteristicaCasa.casa_id = ?;");
        $stmt->bind_param("si", $idioma,$id);
        $stmt->execute();

        $resultat = $stmt->get_result();

        return $resultat;
    }

    public function selectIdioma($idioma)
    {

        $query = "SELECT casa.id, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, imatge.img_principal, casa.nBanys, casa.nHabitacions FROM casa JOIN traduccioCasa ON casa.id = traduccioCasa.casa_id JOIN imatge ON casa.id = imatge.casa_id WHERE traduccioCasa.idioma_id=?;";

        $stmt = $this->conexio->prepare($query);
        $stmt->bind_param("s", $idioma);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;

    }

    public function mostrarReserves($token,$idioma,$data){
        $query = "SELECT poblacio.nom, traduccioCasa.traduccioNom,traduccioCasa.tradDescripcio,reserva.casa_id,  DATE_FORMAT(reserva.data_inici,'%d-%m-%Y') as entrada,  DATE_FORMAT(reserva.data_fi,'%d-%m-%Y') as sortida, reserva.data_reserva, reserva.preu_final, reserva.data_inici  from reserva, usuari, casa, traduccioCasa, poblacio WHERE reserva.usuari_id = usuari.id AND casa.id = traduccioCasa.casa_id AND casa.id = reserva.casa_id AND poblacio.id = casa.poblacio_id AND usuari.token = ? AND traduccioCasa.idioma_id = ? AND reserva.data_inici < ? ORDER BY reserva.data_reserva desc";
        $stmt = $this->conexio->prepare($query);
        $stmt->bind_param("sss",$token, $idioma,$data);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }


    public function proximesReserves($token,$idioma, $data){

        $query = "SELECT poblacio.nom, traduccioCasa.traduccioNom,traduccioCasa.tradDescripcio,reserva.casa_id,  DATE_FORMAT(reserva.data_inici,'%d-%m-%Y') as entrada,  DATE_FORMAT(reserva.data_fi,'%d-%m-%Y') as sortida, reserva.data_reserva, reserva.preu_final, reserva.data_inici  from reserva, usuari, casa, traduccioCasa, poblacio WHERE reserva.usuari_id = usuari.id AND casa.id = traduccioCasa.casa_id AND casa.id = reserva.casa_id AND poblacio.id = casa.poblacio_id AND usuari.token = ? AND traduccioCasa.idioma_id = ? AND reserva.data_inici > ? ORDER BY reserva.data_reserva desc";
        $stmt = $this->conexio->prepare($query);
        $stmt->bind_param("sss",$token, $idioma,$data);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function selectReserva($idioma, $data_inici, $idCasa){
            //SELECT reserva.casa_id, DATE_FORMAT(reserva.data_inici,'%d-%m-%Y') as entrada, DATE_FORMAT(reserva.data_fi,'%d-%m-%Y') as sortida, reserva.preu_final, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, usuari.DNI, usuari.email, poblacio.nom FROM reserva JOIN casa ON reserva.casa_id = casa.id JOIN traduccioCasa ON reserva.casa_id = traduccioCasa.casa_id JOIN usuari ON usuari.id = reserva.usuari_id JOIN poblacio ON poblacio.id = casa.poblacio_id WHERE traduccioCasa.idioma_id = 'CA' AND reserva.data_inici='2021-02-23' AND reserva.casa_id=2
    $query = "SELECT reserva.casa_id, DATE_FORMAT(reserva.data_inici,'%d-%m-%Y') as entrada, DATE_FORMAT(reserva.data_fi,'%d-%m-%Y') as sortida, reserva.preu_final, traduccioCasa.traduccioNom, traduccioCasa.tradDescripcio, usuari.DNI, usuari.email, poblacio.nom FROM reserva JOIN casa ON reserva.casa_id = casa.id JOIN traduccioCasa ON reserva.casa_id = traduccioCasa.casa_id JOIN usuari ON usuari.id = reserva.usuari_id JOIN poblacio ON poblacio.id = casa.poblacio_id WHERE traduccioCasa.idioma_id = ?  AND reserva.data_inici=? AND reserva.casa_id=?";
    $stmt = $this->conexio->prepare($query);
    $stmt->bind_param("ssi",$idioma, $data_inici, $idCasa);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result;
    }


}
