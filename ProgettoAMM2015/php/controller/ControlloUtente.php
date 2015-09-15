<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/CorsiFactory.php';
include_once basename(__DIR__) . '/../model/IscrizioneFactory.php';

class ControlloUtente extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function invoke(&$request) {

        $vd = new ViewDescriptor();

        $vd->setPagina($request['page']);

        $this->setImpostaToken($vd, $request);

        if (!$this->loggedIn()) {
            
            $this->showLogin($vd);
        } 
        else {
            $user = UtenteGenericoFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::ruolo]);

            if (isset($request["subpage"])) {
               
                // inizio switch subpage
                switch ($request["subpage"]) {
                    
                    // profilo dell'utente
                    case 'profilo':
                        $vd->setSottoPagina('profilo');
                        break;
                    
                    // username e password dell'utente
                    case 'sicurezza':
                        $vd->setSottoPagina('sicurezza');
                        // aggiugo gli script per implementazione funzionalità ajax
                        $vd->addScript("../Ajax/jquery-2.1.4.min.js");
                        $vd->addScript("../Ajax/validazione.js");
                        break;
                    
                    // iscrizione ad un corso della palestra
                    case 'iscrizioneCorso':
                        $corsiIscrizione = CorsiFactory::instance()->corsiPerUtente($user);
                        $vd->setSottoPagina('iscrizioneCorso');
                        break;
                    
                    // lista corsi seguiti dal'utente
                    case 'corsiSeguiti':
                        $corsi = IscrizioneFactory::instance()->getCorsiIscrizionePerUtente($user);
                        $vd->setSottoPagina('corsiSeguiti');
                        break;
                    
                    default:
                        $vd->setSottoPagina('home');
                        break;
                } // fine switch subpage
            }
            if (isset($request["cmd"])) {
                // inizio switch comando
                switch ($request["cmd"]) {

                    case 'logout':
                        $this->logout($vd);
                        break;

                    case 'cambia_sicurezza':
                        // se premuto il pulsante salva
                        if (isset($_POST['salva']) && $_POST['salva'] == "Salva") {
                            include_once basename(__DIR__) . '../../../Ajax/Classe.php';
                            $users = new Classe();
                            // elimino il post del submit
                            unset($_POST['salva']);
                            // aggiorno la sicurezza
                            $aggiornaSicurezza = $users->aggiornaSicurezza($user, $_POST);
                            // stampo un eventuale problema
                            if($aggiornaSicurezza !== true) {
                                echo "$aggiornaSicurezza";
                            }
                        }
                        
                        $this->showHomeUtente($vd);
                        break;
                    
                    // aggiorno i dati personali dell'utente
                    case 'dati_personali': 
                        $this->aggiornaDataNascita($user, $request);
                        $this->aggiornaUtente($user, $request);
                        $this->showHomeUtente($vd);
                        break;
                    
                    // iscrivo l'utente ad un corso
                    case 'iscrivi':
                        // cerco i lcorso di cui si richiede l'iscrizione
                        $corso_iscr = $this->getCorsoPerIndice($corsiIscrizione, $request);
                         
                        if (isset($corso_iscr)) {
                            // aggiungo l'utente agli iscritti al corso
                            $result = $corso_iscr->iscrivi($user);
                            if($result) {
                                // query di iscrizione dell'utente
                                IscrizioneFactory::instance()->aggiungiIscrizione($user, $corso_iscr);
                            } else {
                                echo '<p class="messaggio">Siamo spiacenti. <br> Posti disponibili non sufficienti</p>';
                            }
                        } else {
                           echo '<p class="messaggio">Impossibile iscriversi al corso<p>';
                        }
                        $this->showHomeUtente($vd);
                        break;

                    default : $this->showLogin($vd);
                         
                }// fine switch comando
            } else {
                    $user = UtenteGenericoFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::ruolo]);
                    $this->showHomeUtente($vd);
                }
        }
        require basename(__DIR__) . '/../view/master.php';
    }
    
    /** 
     * Aggiorno i dati personali dell'utente
     * @param type $user
     * @param type $request
     */
    protected function aggiornaUtente($user, &$request) {
        // aggiorno il numero di telefono
        if (isset($request['Telefono'])) {
            $user->setTelefono($request['Telefono']);
        }
        
        // aggiorno la data del certificato medico
        if (isset($request['DataCertificato'])) {
            $user->setDataCertificato($request['DataCertificato']);
        }
        
        // salvo i cambiamenti
        UtenteGenericoFactory::instance()->salva($user);
        
    }
    
    /**
     * Cerco il corso per l'iscrizione del'utente
     * @param type $corsiIscrizione
     * @param type $request
     * @return type
     */
    private function getCorsoPerIndice(&$corsiIscrizione, &$request) {
        if (isset($request['iscrizione'])) {
            $valore = filter_var($request['iscrizione'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (isset($valore) && $valore > -1 && $valore < count($corsiIscrizione)) {
                return $corsiIscrizione[$valore];
            } else {    
                echo '<p class="messaggio">Corso inesistente</p>';
                return null;
            }
        } else {
            echo '<p class="messaggio">Specificare corso</p>';
            return null;
        }
    }

}

?>
