<?php

include_once 'Utente.php';
include_once 'Corso.php';
include_once 'UtenteGenericoFactory.php';

class CorsiFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CorsiFactory();
        }

        return self::$singleton;
    }
    
    /**
     * Cerca tutti i corsi a cui sono iscritti gli utenti
     * @param Utente $user
     * @return array
     */
    public function &corsiPerUtente(Utente $user) {
        
        $corsi = array();
        $query = "SELECT Istruttori.password Istruttori_password, Istruttori.username Istruttori_username, Istruttori.id Istruttori_id, Istruttori.Cognome Istruttori_Cognome, Istruttori.Nome Istruttori_Nome, Istruttori.DataNascita Istruttori_DataNascita, Istruttori.CodiceFiscale Istruttori_CodiceFiscale, Istruttori.Email Istruttori_Email, Iscrizioni.id Iscrizioni_id, Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, Iscrizioni.Pagato Iscrizioni_Pagato, Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione, Corsi.NMax Corsi_NMax, Corsi.Durata Corsi_Durata, Corsi.Codice Corsi_Codice, Edizioni.Numero Edizioni_Numero, Edizioni.Giorno Edizioni_Giorno, Edizioni.Ora Edizioni_Ora, Edizioni.Prezzo Edizioni_Prezzo
                  from
                  Corsi 
                  JOIN Edizioni ON Corsi.Codice = Edizioni.CodiceCorso
                  JOIN Istruttori ON Istruttori.id = Edizioni.idIstruttore
                  JOIN Iscrizioni ON Iscrizioni.NumeroEdizione = Edizioni.Numero
                  ";

        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log(" Impossibile inizializzare il database");
            $mysqli->close();
            return $corsi;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return $corsi;
        }
        
        $corsi = self::caricaCorsi($stmt);
        foreach($corsi as $corso){
            self::caricaIscritti($corso);
        }
        
        $mysqli->close();
        return $corsi;
    }
    
    /**
     * Caricamento dei corsi
     * @param mysqli_stmt $stmt
     * @return \typeCarica
     * @param mysqli_stmt $stmt
     * @return typeCarica i corsi
     */
    public function &caricaCorsi(mysqli_stmt $stmt) {
        $corsi = array();
        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['Istruttori_password'],
                $row['Istruttori_username'],
                $row['Istruttori_id'],
                $row['Istruttori_Cognome'],
                $row['Istruttori_Nome'],
                $row['Istruttori_DataNascita'],
                $row['Istruttori_CodiceFiscale'],
                $row['Istruttori_Email'],
                $row['Iscrizioni_id'],
                $row['Iscrizioni_DataIscrizione'],
                $row['Iscrizioni_Pagato'],
                $row['Corsi_Nome'],
                $row['Corsi_Descrizione'],
                $row['Corsi_NMax'], 
                $row['Corsi_Durata'], 
                $row['Corsi_Codice'],
                $row['Edizioni_Numero'],
                $row['Edizioni_Giorno'], 
                $row['Edizioni_Ora'], 
                $row['Edizioni_Prezzo']);
                
        if (!$bind) {
            error_log("Impossibile effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $corsi[] = self::crea($row);
        }

        $stmt->close();

        return $corsi;
    }
    
    /**
     * Caricamento di tutti gli iscritti ad un corso
     * @param Corso $corso
     * @return type
     */
    public function caricaIscritti(Corso $corso){
        
        $query = "select 
            Utenti.id studenti_id,
            Utenti.Nome studenti_Nome,
            Utenti.Cognome Utenti_Cognome,
            Utenti.DataNascita Utenti_DataNascita,
            Utenti.Telefono Utenti_Telefono,
            Utenti.DataCertificato Utenti_DataCertificato,
            Utenti.username Utenti_username,
            Utenti.password Utenti_password,
            
            Corsi.Codice Corsi_Codice,
            Corsi.Nome Corsi_Nome
            
            from Corsi
            JOIN Edizioni ON Corsi.Codice = Edizioni.CodiceCorso
            JOIN Istruttori ON Istruttori.id = Edizioni.IdIstruttore
            JOIN Iscrizioni ON Iscrizioni.NumeroEdizione = Edizioni.Numero
            JOIN Utenti ON Iscrizioni.idUtente = Utenti.id
            where Corsi.Codice = ?";
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('i', $corso->getCodice())) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            $mysqli->close();
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['Utenti_id'], 
                $row['Utenti_Nome'], 
                $row['Utenti_Cognome'], 
                $row['Utenti_DataNascita'],
                $row['Utenti_Telefono'],
                $row['Utenti_DataCertificato'],
                $row['Utenti_username'], 
                $row['Utenti_password'], 
                $row['Corsi_Codice'],
                $row['Corsi_Nome']);
        if (!$bind) {
            error_log("Impossibile effettuare il binding in output");
            $mysqli->close();
            return null;
        }

        while ($stmt->fetch()) {
            $corso->iscrivi(UtenteGenericoFactory::instance()->creaUtente($row));
        }
        
        $mysqli->close();
        $stmt->close();
        
    }
    
    /**
     * Ricerca di un corso con un dato codice
     * @param type $corsoCodice
     * @return array
     */
    public function cercaCorsoPerCodice($corsoCodice){
        $corsi = array();
        
        $query = "
               SELECT Istruttori.password Istruttori_password, Istruttori.username Istruttori_username, Istruttori.id Istruttori_id, Istruttori.Cognome Istruttori_Cognome, Istruttori.Nome Istruttori_Nome, Istruttori.DataNascita Istruttori_DataNascita, Istruttori.CodiceFiscale Istruttori_CodiceFiscale, Istruttori.Email Istruttori_Email, Iscrizioni.id Iscrizioni_id, Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, Iscrizioni.Pagato Iscrizioni_Pagato, Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione, Corsi.NMax Corsi_NMax, Corsi.Durata Corsi_Durata, Corsi.Codice Corsi_Codice, Edizioni.Numero Edizioni_Numero, Edizioni.Giorno Edizioni_Giorno, Edizioni.Ora Edizioni_Ora, Edizioni.Prezzo Edizioni_Prezzo
               
               FROM Corsi
               JOIN Edizioni ON Corsi.Codice = Edizioni.CodiceCorso
               JOIN Istruttori ON Istruttori.id = Edizioni.idIstruttore
               JOIN Iscrizioni ON Iscrizioni.NumeroEdizione = Edizioni.Numero
              
               WHERE Corsi.Codice = ?";
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return $corsi;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return $corsi;
        }

        
        if (!$stmt->bind_param('i', $corsoCodice)) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return $corsi;
        }

        $corsi =  self::caricaCorsi($stmt);
        
        foreach($corsi as $corso){
            self::caricaIscritti($corso);
        }
        
        if(count($corsi > 0)){
            $mysqli->close();
            return $corsi[0];
        }else{
            $mysqli->close();
            return null;
        }
    }
    
    /**
     * Ricerca dei corsi sostenuti da un dato istruttore
     * @param Istruttore $istruttore
     * @return array
     */
    public function &getCorsiPerIstruttore(Istruttore $istruttore) {
        
        $corsi = array();
       
        $query = "SELECT Istruttori.password Istruttori_password, Istruttori.username Istruttori_username, Istruttori.id Istruttori_id, Istruttori.Cognome Istruttori_Cognome, Istruttori.Nome Istruttori_Nome, Istruttori.DataNascita Istruttori_DataNascita, Istruttori.CodiceFiscale Istruttori_CodiceFiscale, Istruttori.Email Istruttori_Email, Iscrizioni.id Iscrizioni_id, Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, Iscrizioni.Pagato Iscrizioni_Pagato, Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione, Corsi.NMax Corsi_NMax, Corsi.Durata Corsi_Durata, Corsi.Codice Corsi_Codice, Edizioni.Numero Edizioni_Numero, Edizioni.Giorno Edizioni_Giorno, Edizioni.Ora Edizioni_Ora, Edizioni.Prezzo Edizioni_Prezzo
            FROM Corsi
            JOIN Edizioni ON Corsi.Codice = Edizioni.CodiceCorso
            JOIN Istruttori ON Istruttori.id = Edizioni.idIstruttore
            JOIN Iscrizioni ON Iscrizioni.NumeroEdizione = Edizioni.Numero
           
            WHERE Istruttori.id = ?
            group by Corsi.Nome";
        
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return $corsi;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('i', $istruttore->getId())) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $corsi =  self::caricaCorsi($stmt);
        foreach($corsi as $corso){
            self::caricaIscritti($corso);
        }
        $mysqli->close();
        return $corsi;
    }
    
    public function crea($row) {
        $corso = new Corso();
        
        $corso->setDescrizione($row['Corsi_Descrizione']);
        $corso->setDurata($row['Corsi_Durata']);
        $corso->setCodice($row['Corsi_Codice']);
        $corso->setNMax($row['Corsi_NMax']);
        $corso->setNome($row['Corsi_Nome']);
        $corso->setEdizione(EdizioneFactory::instance()->crea($row));
        
        return $corso;
    }
    
    /**
     * Salvataggio dei cambiamenti agli attributi di un corso
     * @param Corso $corso
     * @return type
     */
    public function salva(Corso $corso){
         $query = "update Corsi set 
                    Nome = ?,
                    Descrizione = ?,
                    Durata = ?,
                    NMax = ?
                    where Codice = ?";
         
        return $this->modificaDB($corso, $query);
        
    }

    /**
     * Modifico il database in seguito ai cambiamenti sugli attributi di un corso
     * @param Corso $corso
     * @param type $query
     * @return int
     */
    private function modificaDB(Corso $corso, $query){
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();
       
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('sssii', 
                $corso->getNome(),
                $corso->getDescrizione(),
                $corso->getDurata(),
                $corso->getNMax(),
                $corso->getCodice())) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
     * Aggiunge un utente e lo iscrive ad un corso
     * @param type $request
     * @param type $corsi
     * @return boolean
     */
    public function addSignIn(&$request, &$corsi){
         
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return false;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt2 = $mysqli->stmt_init();
        
        // query di aggiunta di un utente
        $aggiungi_utente = "insert into Utenti (password, username, id, Cognome, Nome, DataNascita, Telefono, DataCertificato) values (?, ?, ?, ?, ?, ?, ?, ?)";
        
        // query di aggiunta di un iscrizione
        $aggiungi_iscrizione = "insert into Iscrizioni (id, DataIscrizione, Pagato, NumeroEdizione, idUtente) values (default, ?, ?, ?, ?)";
        
        $stmt->prepare($aggiungi_utente);
        if (!$stmt) {
            error_log("Impossibile inizializzare il primo  prepared statement");
            $mysqli->close();
            return false;
        }


        $stmt2->prepare($aggiungi_iscrizione);
        if (!$stmt2) {
            error_log("Impossibile inizializzare il secondo prepared statement");
            $mysqli->close();
            return false;
        }
        
        // cerco l'id sucessivo
        $id = $this->cercaUltimoId();
        $id++;
       
        $flag = 0;
        
        // controllo gli input del form di aggiunta e iscrizione di un utente
        
        if (isset($request['password']) && $request['password'] !== "") {
            $password = $request['password'];
            $flag++;
        }
       
        if (isset($request['username']) && $request['username'] !== "") {
            $username = $request['username'];
            $flag++;
        }
        
        if (isset($request['Cognome']) && $request['Cognome'] !== "") {
            $cognome = $request['Cognome'];
            $flag++;
        }
        
        if (isset($request['Nome']) && $request['Nome'] !== "") {
            $nome = $request['Nome'];
            $flag++;
        }
        
        if (isset($request['DataNascita']) && $request['DataNascita'] !== "") {
            $dataNascita = $request['DataNascita'];
            $flag++;
        }
        
        if (isset($request['Telefono']) && $request['Telefono'] !== "") {
            $telefono = $request['Telefono'];
            $flag++;
        }
        
        if (isset($request['DataCertificato']) && $request['DataCertificato'] !== "") {
            $dataCertificato = $request['DataCertificato'];
            $flag++;
        }
        
        if (isset($request['DataIscrizione']) && $request['DataIscrizione'] !== "") {
            $dataIscrizione = $request['DataIscrizione'];
            $flag++;
        }
        
        if (isset($request['Pagato']) && $request['Pagato'] !== "") {
            $pagato = $request['Pagato'];
            $flag++;
        }
        
         if (isset($request['NumeroEdizione']) && $request['NumeroEdizione'] !== "") {
            $numeroEdizione = $request['NumeroEdizione'];
            $flag++;
        }
       
        // se ci sono campi vuoti
        if($flag < 10) {
            $mysqli->close();
            echo '<p class="messaggio">Impossibile eseguire la richiesta. <br> E\' necessario compilare tutti i campi<p>';
            return false;
        }
        
        // tutti i campi sono stati compilati
        if (!$stmt->bind_param('ssisssss', $password, $username, $id, $cognome, $nome, $dataNascita, $telefono, $dataCertificato)) { 
            error_log("Impossibile effettuare il binding in input stmt1");
            $mysqli->close();
            return false;
        } 
        
        if (!$stmt2->bind_param('ssii', $dataIscrizione, $pagato, $numeroEdizione, $id)) {
            error_log("Impossibile effettuare il binding in input stmt1");
            $mysqli->close();
            return false;
        }
        
        // inizio la transazione
        $mysqli->autocommit(false);
        
        
        if (!$stmt->execute()) {
            error_log("Impossibile eseguire il primo statement");
            $mysqli->rollback();
            $mysqli->close();
            return false;
        }
        
        if (!$stmt2->execute()) {
            error_log("Impossibile eseguire il secondo statement");
            $mysqli->rollback();
            $mysqli->close();
            return false;
        }
        
        
        // ok
        $mysqli->commit();
        $mysqli->autocommit(true);
        $mysqli->close();

        return true;
    }

    private function cercaUltimoId(){
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return false;
        }
        
        $query = "select * from Utenti";
        $result = $mysqli->query($query);
        $mysqli->close();
        return $result->num_rows;
        
    }
         
    
}

?>
