<?php

include_once 'UtenteGenerico.php';
include_once 'Iscrizione.php';

class Utente extends UtenteGenerico {

    private $telefono;
    
    private $dataCertificato;

    public function __construct() {
   
        parent::__construct();
        $this->setRuolo(UtenteGenerico::Utente);  
    }

    /**
     * Restituisce il numero di telefono dell'utente
     * @return type
     */
    public function getTelefono() {
        return $this->telefono;
    }

   /**
    * Setta il numero di telefono del'utente
    * @param type $telefono
    */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;           
    }
    
   /**
    * Restituisce la data del certificato medico del'utente
    * @return type
    */
    public function getDataCertificato() {
        return $this->DataCertificato;
    }

    /**
     * Setta la data del certificato medico dell'utente
     * @param type $DataCertificato
     */
    public function setDataCertificato($DataCertificato) {
        $this->DataCertificato = $DataCertificato;
    }

}

?>

