<?php

include_once 'Utente.php';

class Corso {
    
    private $nome;
    private $descrizione;
    private $durata;
    private $nmax;
    private $codice;
    private $utente;
    private $iscritti;
    private $edizione;
    private $istruttore;
    
    public function __construct() {
        $this->iscritti = array();
    }
    
    /**
     * Setta l'edizione del corso
     * @param Edizione $edizione
     */
    public function setEdizione(Edizione $edizione) {
        $this->edizione = $edizione;
    }
    
    /**
     * Restituisce l'edizione del corso
     * @return type
     */
    public function getEdizione() {
        return $this->edizione;
    }
    
    /**
     * Restituisce il codice del corso
     * @return type
     */
    public function getCodice() {
        return $this->codice;
    }
    
    /**
     * Setta il codice del corso
     * @param type $codice
     */
    public function setCodice($codice) {
        $this->codice = $codice;
    }
    
    /**
     * Restituisce il nome del corso
     * @return type
     */
    public function getNome() {
        return $this->nome;
    }
    
    /**
     * Setta il nome del corso
     * @param type $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    /**
     * Restituisce la descrizione del corso
     * @return type
     */
    public function getDescrizione() {
        return $this->descrizione;
    }
    
    /**
     * Setta la descrizione del corso
     * @param type $descrizione
     */
    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }
    
    /**
     * Restituisce la durata del corso
     * @return type
     */
    public function getDurata() {
        return $this->durata;
    }
    
    /**
     * Setta la durata del corso
     * @param type $durata
     */
    public function setDurata($durata) {
        $this->durata = $durata;
    }
    
    /**
     * Restituisce il numero massimo di partecipanti al corso
     * @return type
     */
    public function getNMax() {
        return $this->nmax;
    }
    
    /**
     * Setta il numero massimo di partecipanti
     * @param type $nmax
     */
    public function setNMax($nmax) {
        $this->nmax = $nmax;
    }
    
    /**
     * restituisce un Utente iscritto al corso
     * @return type
     */
    public function getUtente() {
        return $this->utente;
    }
    
    /**
     * Setta l'utente come iscritto al corso
     * @param Utente $utente
     */
    public function setUtente(Utente $utente) {
        $this->utente = $utente;
    }
    
    /**
     * Iscrive un utente al corso
     * @param Utente $utente
     * @return boolean
     */
    public function iscrivi(Utente $utente) {
        
        // l'iscrizione può avvenire se non si supera la capienza massima di iscritti
        if (count($this->iscritti) >= $this->nmax) {
            return false;
        }
        
        // e se il certificato medico non è scaduto
        $data1 = strtotime($utente->getDataCertificato());
        $data2 = strtotime(date("Y-m-d"));
        $differenza = (($data2-$data1)/3600)/24;
        
        // se la differenza tra la data del certificato medico e la data odierna è > 365 allora il certificato
        // medico è scaduto (esso ha durata annuale)
        if (floor($differenza) > 365) {
            return false;
        }
        
        // se i due requisiti (certificato medico e capienze) sono rispettati, aggiungo l'utente tra gli iscritti al corso
        $this->iscritti[] = $utente;
        return true;
    }
    
    /**
     * Controlla de un utente è iscritto al corso
     * @param Utente $utente
     * @return boolean
     */
    public function inLista(Utente $utente) {
        $pos = $this->posizione($utente);
        if ($pos > -1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Restituisce gli iscritti al corso
     * @return type
     */
    public function &getIscritti() {
        return $this->iscritti;
    }
    
    /**
     * Determina la posizione dell'utente tra gli iscritti. La funzione è utilizata per controllare se un utente è in lista
     * @param Utente $utente
     * @return int
     */
    private function posizione(Utente $utente) {
        for ($i = 0; $i < count($this->iscritti); $i++) {
            if ($this->iscritti[$i]->equals($utente)) {
                return $i;
            }
        }
        return -1;
    }
    

}

?>

