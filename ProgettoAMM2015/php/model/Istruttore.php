<?php

include_once 'UtenteGenerico.php';

class Istruttore extends UtenteGenerico {

    private $codiceFiscale;
    private $email;
    private $corso;
    
    public function __construct() {
        parent::__construct();
        $this->setRuolo(UtenteGenerico::Istruttore);
    }
    
    /**
     * Setta il corso
     * @param Corso $corso
     */
    public function setCorso(Corso $corso) {
        $this->corso = $corso;
    }
    
    /**
     * Restituisce il corso
     * @return type
     */
    public function getCorso() {
        return $this->corso;
    }
    
    /**
     * Restituisce il codice fiscale dell'istruttore
     * @return type
     */
    public function getCodiceFiscale() {
        return $this->codiceFiscale;
    }
    
    /**
     * Setta il codice fiscale dell'istruttore
     * @param type $codiceFiscale
     */
    public function setCodiceFiscale($codiceFiscale) {
       $this->codiceFiscale = $codiceFiscale;
    }
    
    /**
     * Restituisce l'email del'istruttore
     * @return type
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * Setta l'email del'istruttore
     * @param type $email
     * @return boolean
     */
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $this->email = $email;
        return true;
    }

}

?>
