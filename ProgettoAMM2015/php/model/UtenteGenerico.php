<?php

class UtenteGenerico {
    
    private $username;
    
    private $password;
    
    private $nome;

    private $cognome;
 
    private $ruolo;
    
    const Istruttore = 1;
    
    const Utente = 2;
    
    private $dataNascita;
 
    private $id;

    public function __construct() {
        
    }

    /**
     * Restituisce l'username dell'utente/istruttore
     * @return type
     */
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * Setta l'username dell'utente/istruttore
     * @param type $username
     * @return boolean
     */
    public function setUsername($username) {
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z]{5,}/')))) {
            return false;
        }
        $this->username = $username;
        return true;
    }
    
    /**
     * Restituisce la password dell' utente/istruttore
     * @return type
     */
    public function getPassword() {
        return $this->password;
    }
    
    /**
     * Setta la password dell'utente/istruttore
     * @param type $password
     * @return boolean
     */
    public function setPassword($password) {
        $this->password = $password;
        return true;
    }
    
    /**
     * Restituisce il nome dell'utente/istruttore
     * @return type
     */
    public function getNome() {
        return $this->nome;
    }
    
    /**
     * Setta il nome dell'utente/istruttore
     * @param type $nome
     * @return boolean
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }
    
    /**
     * Restituisce il cognome dell'utente/istruttore
     * @return type
     */
    public function getCognome() {
        return $this->cognome;
    }
    
    /**
     * Setta il cognome dell'utente/istruttore
     * @param type $cognome
     * @return boolean
     */
    public function setCognome($cognome) {
        $this->cognome = $cognome;
        return true;
    }
    
    /**
     * Restituisce il ruolo "utente" o "istruttore"
     * @return type
     */
    public function getRuolo() {
        return $this->ruolo;
    }
    
    /**
     * Setta il ruolo "utente" o "istruttore"
     * @param type $ruolo
     * @return boolean
     */
    public function setRuolo($ruolo) {
        switch ($ruolo) {
            case self::Istruttore:
            case self::Utente:
                $this->ruolo = $ruolo;
                return true;
            default:
                return false;
        }
    }
    
    /**
     * Restituisce la data di nascita dell'utente/istruttore
     * @return type
     */
    public function getDataNascita() {
        return $this->dataNascita;
    }
    
    /**
     * Setta la data di nascita dell'utente/istruttore
     * @param type $dataNascita
     * @return boolean
     */
    public function setDataNascita($dataNascita) {
        $this->dataNascita = $dataNascita;
        return true;
    }
    
    /**
     * Restituisce l'id dell'utente/istruttore
     * @return type
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Setta l'id dell'utente/istruttore
     * @param type $id
     * @return boolean
     */
    public function setId($id){
        $valore = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(!isset($valore)){
            return false;
        }
        $this->id = $valore;
    }
    
     /**
     * Controlla se utente/istruttore esiste
     * @return type
     */
    public function esiste() {
        return isset($this->ruolo);
    }
    
    
    /**
     * Controlla de due utenti/istruttori sono uguali. Due utenti/istruttori sono uguali se hanno
     * stesso id, nome e cognome
     * @param UtenteGenerico $user
     * @return type
     */
    public function equals(UtenteGenerico $user) {

        return  $this->id == $user->id &&
                $this->nome == $user->nome &&
                $this->cognome == $user->cognome &&
                $this->ruolo == $user->ruolo;
    }

}

?>
