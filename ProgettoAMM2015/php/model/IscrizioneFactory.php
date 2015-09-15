<?php

include_once 'Iscrizione.php';
include_once 'UtenteGenericoFactory.php';
include_once 'Utente.php';
include_once 'UtenteGenerico.php';
include_once 'EdizioneFactory.php';

class IscrizioneFactory {

    private static $singleton;
    
    private function __constructor(){
    }
    
    
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new IscrizioneFactory();
        }
        
        return self::$singleton;
    }
    
    /**
     * Restituisce i corsi a cui è iscritto l'utente
     * @param Utente $utente
     * @return array
     */
    public function &getCorsiIscrizionePerUtente(Utente $utente) {
        
        $corsiIscrizione = array();
        $query = " 
            SELECT Istruttori.Cognome Istruttori_Cognome, Istruttori.Nome Istruttori_Nome, Iscrizioni.id Iscrizioni_id, Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, Iscrizioni.Pagato Iscrizioni_Pagato, Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione, Corsi.NMax Corsi_NMax, Corsi.Durata Corsi_Durata, Corsi.Codice Corsi_Codice, Edizioni.Numero Edizioni_Numero, Edizioni.Giorno Edizioni_Giorno, Edizioni.Ora Edizioni_Ora, Edizioni.Prezzo Edizioni_Prezzo
            FROM Corsi
            JOIN Edizioni ON Corsi.Codice = Edizioni.CodiceCorso
            JOIN Istruttori ON Istruttori.id = Edizioni.idIstruttore
            JOIN Iscrizioni ON Iscrizioni.NumeroEdizione = Edizioni.Numero
            JOIN Utenti ON Iscrizioni.idUtente = Utenti.id
            WHERE Utenti.id = ?";
        
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return $corsiIscrizione;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return $CorsiIscrizione;
        }
        
          
        if (!$stmt->bind_param('i', $utente->getId())) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return $corsiIscrizione;
        }
        
        $corsiIscrizione =  self::caricaCorsi($stmt);
         
        $mysqli->close();
        return $corsiIscrizione;
    }
    
    /**
     * Caricamento corsi
     * @param mysqli_stmt $stmt
     * @return type
     */
    private function &caricaCorsi(mysqli_stmt $stmt){
        $corsiIscrizione = array();
         if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            return $null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['Istruttori_Cognome'],
                $row['Istruttori_Nome'],
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
                $row['Edizioni_Prezzo']
              );
        
        if (!$bind) {
            error_log("Impossibile effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $corsiIscrizione[] = self::crea($row);
        }
        
        $stmt->close();
        
        return $corsiIscrizione;
    }
    
    public function crea($row){
        
        $iscrizione = new Iscrizione();
        $iscrizione->setId($row['Iscrizioni_id']);
        $iscrizione->setDataIscrizione($row['Iscrizioni_DataIscrizione']);
        $iscrizione->setPagato($row['Iscrizioni_Pagato']);
        $iscrizione-> setCorso(CorsiFactory::instance()->crea($row));
        $iscrizione->setEdizione(EdizioneFactory::instance()->crea($row));
        
        return $iscrizione;
    }
    
    /**
     * Query di aggiunta di un iscrizione
     * @param Utente $utente
     * @param Corso $corso
     * @return type
     */
    public function aggiungiIscrizione(Utente $utente, Corso $corso){
        $query = "insert into Iscrizioni values (?, ?, ?, ?, ?)";
        return $this->queryIscrizione($utente, $corso, $query);
    }
    
    /**
     * Modifica il database aggiungendo l'iscrizione
     * @param Utente $utente
     * @param Corso $corso
     * @param type $query
     * @return int
     */
    private function queryIscrizione(Utente $utente, Corso $corso, $query){
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }
        
        // l'utente si è appena iscritto: non ha pagato ancora pagatoe la data di iscrizione è quella odierna (date();)
        $no = 'NO';
        if (!$stmt->bind_param("sssii", $null, date("Y-m-d"), $no , $corso->getCodice(), $utente->getId())) {
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
 
}

?>


