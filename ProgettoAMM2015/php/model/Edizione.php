<?php

class Edizione {
    
    private $giorno;
    private $ora;
    private $prezzo;
    private $numero;

    public function __construct() {
        
    }
    
    /**
     * Restituisce il giorno in cui si tiene l'edizione del corso
     * @return type
     */
    public function getGiorno() {
        return $this->giorno;
    }
    
    /**
     * Setta il giorno dell'edizione del corso
     * @param type $giorno
     */
    public function setGiorno($giorno) {
        $this->giorno = $giorno;
    }
    
    /**
     * Restituisce il numero dell'edizione
     * @return type
     */
    public function getNumero() {
        return $this->numero;
    }
    
    /**
     * Setta il numero dell'edizione
     * @param type $numero
     */
    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    /**
     * Restituisce l'ora dell'edizione del corso
     * @return type
     */
    public function getOra() {
        return $this->ora;
    }
    
    /**
     * Setta l'ora dell'edizione del corso
     * @param type $ora
     */
    public function setOra($ora) {
        $this->ora = $ora;
    }
    
    /**
     * Restituisce il prezzo del'edizione del corso
     * @return type
     */
    public function getPrezzo() {
        return $this->prezzo;
    }
    
    /**
     * Setta il prezzo dell'edizione del corso
     * @param type $prezzo
     */
    public function setPrezzo($prezzo) {
        $this->prezzo = $prezzo;
    }
   
}

?>

