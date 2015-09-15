<?php

include_once 'Database.php';
include_once 'UtenteGenerico.php';
include_once 'Utente.php';
include_once 'Istruttore.php';

class UtenteGenericoFactory {
    
    private static $singleton;

    private function __constructor() {
        
    }

  
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UtenteGenericoFactory();
        }

        return self::$singleton;
    }
    
    /**
     * Cerca un utente/istruttore con un id specifico
     * @param type $id
     * @param type $ruolo
     * @return type
     */
    public function cercaUtentePerId($id, $ruolo) {
        
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        switch ($ruolo) {
            // cerco prima su un utente
            case UtenteGenerico::Utente:
                $query = "select 
                    Utenti.id Utenti_id, Utenti.Nome Utenti_Nome, Utenti.Cognome Utenti_Cognome,
                    Utenti.DataNascita Utenti_DataNascita,
                    Utenti.Telefono Utenti_Telefono, Utenti.DataCertificato Utenti_DataCertificato,
                    Utenti.username Utenti_username, Utenti.password Utenti_password,
                    Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione,
                    Corsi.Durata Corsi_Durata, Corsi.NMax Corsi_NMax, Corsi.Codice Corsi_Codice,
                    Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, 
                    Iscrizioni.Pagato Iscrizioni_Pagato, Iscrizioni.NumeroEdizione Iscrizioni_NumeroEdizione
                    from Corsi
                    join Edizioni on Corsi.Codice = Edizioni.CodiceCorso
                    join Iscrizioni on Iscrizioni.NumeroEdizione = Edizioni.Numero
                    join Utenti on Utenti.id = Iscrizioni.idUtente
                    where Utenti.id = ?";
                
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("Impossibile inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("Impossibile effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }
                
                return self::caricaUser($stmt);
            
            // cerco ora un istruttore
            case UtenteGenerico::Istruttore:
                $query = "select 
                    Istruttori.id Istruttori_id, Istruttori.Nome Istruttori_Nome, Istruttori.Cognome Istruttori_Cognome,
                    Istruttori.DataNascita Istruttori_DataNascita,Istruttori.CodiceFiscale Istruttori_CodiceFiscale,
                    Istruttori.Email Istruttori_Email,
                    Istruttori.username Istruttori_username,Istruttori.password Istruttori_password,
                    Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione,
                    Corsi.Durata Corsi_Durata, Corsi.NMax Corsi_NMax, Corsi.Codice Corsi_Codice,
                    Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, 
                    Iscrizioni.Pagato Iscrizioni_Pagato, Iscrizioni.NumeroEdizione Iscrizioni_NumeroEdizione,
                    Edizioni.Numero Edizioni_Numero, Edizioni.Giorno Edizioni_Giorno, Edizioni.Ora Edizioni_Ora, Edizioni.Prezzo Edizioni_Prezzo
                    from Corsi
                    join Edizioni on Corsi.Codice = Edizioni.CodiceCorso
                    join Iscrizioni on Iscrizioni.NumeroEdizione = Edizioni.Numero
                    join Istruttori on Istruttori.id = Edizioni.IdIstruttore
                    where Istruttori.id = ?";

                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("Impossibile inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("Impossibile effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet =  self::caricaIstruttore($stmt);
                $mysqli->close();
                return $toRet;

            default: 
                return null;
        }
    }
    
    /**
     * Carica un istruttore
     * @param mysqli_stmt $stmt
     * @return type
     */
    private function caricaIstruttore(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['Istruttori_id'],
                $row['Istruttori_Nome'],
                $row['Istruttori_Cognome'],
                $row['Istruttori_DataNascita'],
                $row['Istruttori_CodiceFiscale'],
                $row['Istruttori_Email'],
                $row['Istruttori_username'],
                $row['Istruttori_password'],
                $row['Corsi_Nome'], 
                $row['Corsi_Descrizione'],
                $row['Corsi_Durata'],
                $row['Corsi_NMax'],
                $row['Corsi_Codice'],
                $row['Iscrizioni_DataIscrizione'], 
                $row['Iscrizioni_Pagato'], 
                $row['Iscrizioni_NumeroEdizione'],
                $row['Edizioni_Numero'],
                $row['Edizioni_Giorno'],
                $row['Edizioni_Ora'],
                $row['Edizioni_Prezzo']);
        if (!$bind) {
            error_log("Impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaIstruttore($row);
    }
    
    /**
     * Carica un utente
     * @param mysqli_stmt $stmt
     * @return type
     */
    private function caricaUser(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
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
                $row['Corsi_Nome'], 
                $row['Corsi_Descrizione'],
                $row['Corsi_Durata'],
                $row['Corsi_NMax'],
                $row['Corsi_Codice'],
                $row['Iscrizioni_DataIscrizione'], 
                $row['Iscrizioni_Pagato'], 
                $row['Iscrizioni_NumeroEdizione']
                 );
        if (!$bind) {
            error_log("Impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaUtente($row);
    }
    
    /**
     * Carica un utente/istruttore
     * @param type $username
     * @param type $password
     * @return type
     */
    public function caricaUtente($username, $password) {


        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        $query = "select 
                    Utenti.id Utenti_id, Utenti.Nome Utenti_Nome, Utenti.Cognome Utenti_Cognome,
                    Utenti.DataNascita Utenti_DataNascita,
                    Utenti.Telefono Utenti_Telefono, Utenti.DataCertificato Utenti_DataCertificato,
                    Utenti.username Utenti_username, Utenti.password Utenti_password,
                    Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione,
                    Corsi.Durata Corsi_Durata, Corsi.NMax Corsi_NMax, Corsi.Codice Corsi_Codice,
                    Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, 
                    Iscrizioni.Pagato Iscrizioni_Pagato, Iscrizioni.NumeroEdizione Iscrizioni_NumeroEdizione
                    from Corsi
                    join Edizioni on Corsi.Codice = Edizioni.CodiceCorso
                    join Iscrizioni on Iscrizioni.NumeroEdizione = Edizioni.Numero
                    join Utenti on Utenti.id = Iscrizioni.idUtente
                where Utenti.username = ? and Utenti.password = ?";
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $utente = self::caricaUser($stmt);
        if (isset($utente)) {
            $mysqli->close();
            return $utente;
        }
        
        $query = "select 
                    Istruttori.id Istruttori_id, Istruttori.Nome Istruttori_Nome, Istruttori.Cognome Istruttori_Cognome,
                    Istruttori.DataNascita Istruttori_DataNascita, Istruttori.CodiceFiscale Istruttori_CodiceFiscale,
                    Istruttori.Email Istruttori_Email,
                    Istruttori.username Istruttori_username, Istruttori.password Istruttori_password,
                    Corsi.Nome Corsi_Nome, Corsi.Descrizione Corsi_Descrizione,
                    Corsi.Durata Corsi_Durata, Corsi.NMax Corsi_NMax, Corsi.Codice Corsi_Codice,
                    Iscrizioni.DataIscrizione Iscrizioni_DataIscrizione, 
                    Iscrizioni.Pagato Iscrizioni_Pagato, Iscrizioni.NumeroEdizione Iscrizioni_NumeroEdizione,
                    Edizioni.Numero Edizioni_Numero, Edizioni.Giorno Edizioni_Giorno, Edizioni.Ora Edizioni_Ora, Edizioni.Prezzo Edizioni_Prezzo
                    from Corsi
                    join Edizioni on Corsi.Codice = Edizioni.CodiceCorso
                    join Iscrizioni on Iscrizioni.NumeroEdizione = Edizioni.Numero
                    join Istruttori on Istruttori.id = Edizioni.IdIstruttore
                where Istruttori.username = ? and Istruttori.password = ?";

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("Impossibile effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $istruttore = self::caricaIstruttore($stmt);
        if (isset($istruttore)) {
            $mysqli->close();
            return $istruttore;
        }
    }
    
    public function creaUtente($row) {
         
        $Utente = new Utente();
        $Utente->setId($row['Utenti_id']);
        $Utente->setNome($row['Utenti_Nome']);
        $Utente->setCognome($row['Utenti_Cognome']);
        $Utente->setDataNascita($row['Utenti_DataNascita']);
        $Utente->setTelefono($row['Utenti_Telefono']);
        $Utente->setDataCertificato($row['Utenti_DataCertificato']);
        $Utente->setRuolo(UtenteGenerico::Utente);
        $Utente->setUsername($row['Utenti_username']);
        $Utente->setPassword($row['Utenti_password']);
        
        return $Utente;
    }
    
    public function creaIstruttore($row) {
        
        $Istruttore = new Istruttore();
        $Istruttore->setId($row['Istruttori_id']);
        $Istruttore->setNome($row['Istruttori_Nome']);
        $Istruttore->setCognome($row['Istruttori_Cognome']);
        $Istruttore->setDataNascita($row['Istruttori_DataNascita']);
        $Istruttore->setCodiceFiscale($row['Istruttori_CodiceFiscale']);
        $Istruttore->setEmail($row['Istruttori_Email']);
        $Istruttore->setRuolo(UtenteGenerico::Istruttore);
        $Istruttore->setUsername($row['Istruttori_username']);
        $Istruttore->setPassword($row['Istruttori_password']);
        $Istruttore->setCorso(CorsiFactory::instance()->crea($row));
        
        return $Istruttore;
    }
    
    /**
     * Salva le modifiche di un utente/istruttore
     * @param UtenteGenerico $user
     * @return int
     */
    public function salva(UtenteGenerico $user) {
        
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("Impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }
        
        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($user->getRuolo()) {
            case UtenteGenerico::Utente:
                // nel caso in cui sia un utente
                $count = $this->salvaUtente($user, $stmt);
                break;
            case UtenteGenerico::Istruttore:
                // nel caso in cui sia un istruttore
                $count = $this->salvaIstruttore($user, $stmt);
        }

        $stmt->close();
        $mysqli->close();
        return $count;
    }
    
    /**
     * Salva le modifiche di un utente
     * @param Utente $utente
     * @param mysqli_stmt $stmt
     * @return int
     */
    private function salvaUtente(Utente $utente, mysqli_stmt $stmt) {
         
        $query = "update Utenti set 
                    username = ?,
                    password = ?,
                    Cognome = ?,
                    Nome = ?,
                    DataNascita = ?,
                    Telefono = ?,
                    DataCertificato = ?
                    where Utenti.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile  inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('sssssssi', $utente->getUsername(), $utente->getPassword(), $utente->getCognome(), $utente->getNome(), $utente->getDataNascita(), $utente->getTelefono(), $utente->getDataCertificato(), $utente->getId())) {
            error_log("Impossibile effettuare il binding in input");
            return 0;
        }
           
       
        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }
    
    /**
     * Salva le modifiche di un istruttore
     * @param Istruttore $i
     * @param mysqli_stmt $stmt
     * @return int
     */
    private function salvaIstruttore(Istruttore $i, mysqli_stmt $stmt) {
        $query = " update Istruttori set 
                    username = ?,
                    password = ?,
                    Cognome = ?,
                    Nome = ?,
                    CodiceFiscale = ?,
                    DataNascita = ?,
                    Email = ?,
                    CodiceCorso = ?
                    where Istruttori.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("Impossibile inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('sssssssii',
                $i->getUsername(),
                $i->getPassword(), 
                $i->getCognome(), 
                $i->getNome(), 
                $i->getCodiceFiscale(),
                $i->getDataNascita(),
                $i->getEmail(), 
                $i->getCorso()->getCodice(),
                $i->getId())) {
            error_log("Impossibile effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("Impossibile eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }
    
}
?>
