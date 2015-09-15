<?php
include_once 'Edizione.php';

class EdizioneFactory {
    
    private static $singleton;

    private function __constructor() {
        
    }

   
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new EdizioneFactory();
        }

        return self::$singleton;
    }

    
    public function crea($row) {
        
        $edizione = new Edizione();
        $edizione->setNumero($row['Edizioni_Numero']);
        $edizione->setGiorno($row['Edizioni_Giorno']);
        $edizione->setOra($row['Edizioni_Ora']);
        $edizione->setPrezzo($row['Edizioni_Prezzo']);
       
        return $edizione;
    }

}

?>



