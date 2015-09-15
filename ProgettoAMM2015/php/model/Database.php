<?php

class Database {
    
    private function __construct() {
        
    }
    
    private static $singleton;
 
    public static function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new Database();
        }
        
        return self::$singleton;
    }
    
    public function connectDb(){
        $mysqli = new mysqli();
        //$mysqli->connect("localhost","virdisSamuele",
        //"formica1015", "amm15_virdisSamuele");
        
        $mysqli->connect("localhost","root",
        "davide", "palestra");
        if($mysqli->errno != 0){
            return null;
        }else{
            return $mysqli;
        }
    }
}

?>
