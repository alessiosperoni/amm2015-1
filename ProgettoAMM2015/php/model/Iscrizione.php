<?php

include_once 'Utente.php';
include_once 'Corso.php';

class Iscrizione {

    private $dataIscrizione;
    
    private $id;
    
    private $pagato;
    
    private $corso;
    
    private $edizione;
   
    public function __construct() {
        
    }
    
    /**
     * Setta l'edizione del corso relativa all'iscrizione
     * @param Edizione $edizione
     */
    public function setEdizione(Edizione $edizione) {
        $this->edizione = $edizione;
    }
    
    /**
     * Restituisce l'edizione del corso relativa all'iscrizione
     * @return type
     */
    public function getEdizione() {
        return $this->edizione;
    }
    
    /**
     * Cancella un iscrizione dell'utente
     * @param Utente $utente
     * @return type
     */
    public function cancella(Utente $utente) {
      return $this->getCorso()->cancella($utente);
    }
    
    /**
     * Restituisce il Corso relativo al'iscrizione
     * @return type
     */
    public function getCorso() {
        return $this->corso;
    }
    
    /**
     * Setta il corso
     * @param Corso $corso
     */
    public function setCorso(Corso $corso) {
        $this->corso = $corso;
    }
    
    /**
     * Restituisce l'id dell'iscrizione
     * @return type
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Setta l'id dell'iscrizione
     * @param type $id
     * @return boolean
     */
    public function setId($id) {
        $valore = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($valore)) {
            return false;
        }
        $this->id = $valore;
        return true;
    }
    
    /**
     * Restituisce la data di iscrizione ad un corso
     * @return type
     */
    public function getDataIscrizione() {
        return $this->dataIscrizione;
    }
    
    /**
     * Setta la data di iscrizione ad un corso
     * @param type $dataIscrizione
     * @return boolean
     */
    public function setDataIscrizione($dataIscrizione) {
        $this->dataIscrizione = $dataIscrizione;
        return true;
    }
    
    /**
     * Setta la variabile $pagato ai valori "SI" o "NO"
     * @param type $pagato
     * @return boolean
     */
    public function setPagato($pagato) {
        $this->pagato = $pagato;
        return true;
    }
    
    /**
     * Restituisce "SI" o "NO"
     * @return type
     */
    public function getPagato() {
        return $this->pagato;
    }

}

?>

