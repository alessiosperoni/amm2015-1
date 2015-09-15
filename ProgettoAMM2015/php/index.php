<?php 
 include_once 'controller/BaseController.php';
 include_once 'controller/ControlloUtente.php';
 include_once 'controller/ControlloIstruttore.php';

 date_default_timezone_set("Europe/Rome");
 FrontController::dispatch($_REQUEST);
 
 class FrontController {
     
    public static function dispatch(&$request) {
        // inizio sessione
        session_start();
        if (isset($request["page"])) {

            switch ($request["page"]) {
                // se siamo nella pagina di login
                case "login":
                    // gestisce il controllo principale
                    $controllo = new BaseController();
                    $controllo->invoke($request);
                    break;
                
                // se siamo nella pagina dell'utente
                case 'utente':
                    // gestisce il controllo dell'utente
                    $controllo = new ControlloUtente();
                    if (isset($_SESSION[BaseController::ruolo]) && $_SESSION[BaseController::ruolo] != UtenteGenerico::Utente) {}
                    $controllo->invoke($request);
                    break;
               
                // se siamo nella pagina dell'istruttore
                case 'istruttore':
                    // gestisce il controllo dell'istruttore
                    $controllo = new ControlloIstruttore();
                    if (isset($_SESSION[BaseController::ruolo]) && $_SESSION[BaseController::ruolo] != UtenteGenerico::Istruttore) {}
                    $controllo->invoke($request);
                    break;
                
                // se la pagina e' inesistente
                default:
                    echo 'Siamo spiacenti ma la pagina a cui si cerca di accedere &egrave; inesistente';
                    break;
           }
        } else {
           echo 'Siamo spiacenti ma la pagina a cui si cerca di accedere &egrave; inesistente';
        }
    }
 }
?>