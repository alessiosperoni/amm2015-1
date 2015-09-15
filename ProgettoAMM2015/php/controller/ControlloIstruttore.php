<?php

include_once 'BaseController.php';

class ControlloIstruttore extends BaseController {

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
                    // profilo dell'istruttore
                    case 'profilo':
                        $vd->setSottoPagina('profilo');
                        break;
                    
                    // username e password dell'istruttore
                    case 'sicurezza':
                        $vd->setSottoPagina('sicurezza');
                        // aggiugo gli script per implementazione funzionalità ajax
                        $vd->addScript("../Ajax/jquery-2.1.4.min.js");
                        $vd->addScript("../Ajax/validazione.js");
                        break;
                    
                    // corsi seguiti dall'istruttore
                    case 'corsi':
                        // cerco tutti i corsi dell'istruttore
                        $corsi = CorsiFactory::instance()->getCorsiPerIstruttore($user);
                        $vd->setSottoPagina('corsi');
                        break;
                    
                    // modifica attributi di un corso
                    case 'corsi_modifica':
                        // cerco tutti i corsi dell'istruttore
                        $corsi = CorsiFactory::instance()->getCorsiPerIstruttore($user);
                        // prendo il corso da modificare
                        $mod_corso = $this->getCorso($request);
                        if (!isset($mod_corso)) {
                            $vd->setSottoPagina('corsi');
                        } else {
                            $vd->setSottoPagina('corsi_modifica');
                        }
                        break;
                    
                    // iscritti ai corsi del'istruttore
                    case 'lista_iscritti':
                        // cerco tutti i corsi dell'istruttore
                        $corsi = CorsiFactory::instance()->getCorsiPerIstruttore($user);
                        $vd->setSottoPagina('lista_iscritti');
                        break;
                    
                    // aggiungo un utente (un iscritto alla palestra)
                    case 'aggiungi_utente':
                        $vd->setSottoPagina('aggiungi_utente');
                        break;
                    
                    // aggiungo un iscrizione all'utente aggiunto
                    case 'aggiungi_iscrizione': 
                        // cerco tutti i corsi dell'istruttore
                        $corsi = CorsiFactory::instance()->getCorsiPerIstruttore($user);
                        $vd->setSottoPagina('aggiungi_iscrizione');                
                        break;
                    
                    default:
                        $vd->setSottoPagina('home');
                        break;
                }// fine switch subpage
            }

            if (isset($request["cmd"])) {
                // inizio switch comando
                switch ($request["cmd"]) {

                    case 'logout':
                        $this->logout($vd);
                        break;

                    // cambio password
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
                        $this->aggiornaIstruttore($user, $request);
                        $this->showHomeUtente($vd);
                        
                        break;
                    
                    // aggiungo un utente e lo iscrivo ad un corso
                    case 'aggiungi_iscrivi':
                        $corsi = CorsiFactory::instance()->getCorsiPerIstruttore($user);
                        // aggiungo e iscrivo (transazione)
                        CorsiFactory::instance()->addSignIn($request, $corsi);
                        $this->showHomeUtente($vd);
                        break;
                    
                    // modifico gli attributi di un corso
                    case 'modifica':
                        $corsi = CorsiFactory::instance()->getCorsiPerIstruttore($user);
                        if (isset($request['corso'])) {
                            $valore = filter_var($request['corso'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($valore)) {
                                // se tutto è andato a buon fine, cerco il codice del corso scelto
                                $mod_corso = $this->cercaCorsoPerCodice($valore, $corsi);
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;
                    
                    // salvataggio cambiamenti corso
                    case 'salva':
                        if (isset($request['corso'])) {
                            $valore = filter_var($request['corso'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($valore)) {
                                $mod_corso = $this->cercaCorsoPerCodice($valore, $corsi);
                                // aggiorno il corso e salvo i cambiamenti
                                $this->aggiornaCorso($mod_corso, $request);
                                if (CorsiFactory::instance()->salva($mod_corso) != 1) {
                                   echo '<p class="messaggio">Impossibile modificare il corso</p>';
                                }
                            }
                        } else {
                           echo '<p class="messaggio">Specificare corso</p>';
                        }
                        
                        $this->showHomeUtente($vd);
                        break;
                    
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }// fine switch comando
            } else {
                $user = UtenteGenericoFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::ruolo]);
                $this->showHomeUtente($vd);
            }
        }
        
        require basename(__DIR__) . '/../view/master.php';
    }
    
    /**
     * Aggiorna i dati personali di un istruttore
     * @param type $user
     * @param type $request
     */
    protected function aggiornaIstruttore($user, &$request) {
         
        // aggiorno il codice fiscale
        if (isset($request['CodiceFiscale'])) {
            $user->setCodiceFiscale($request['CodiceFiscale']);
        }
        
        // aggiorno email
        if (isset($request['Email'])) {
            $user->setEmail($request['Email']);
        }
        
        // salvo i cambiamenti
        if (UtenteGenericoFactory::instance()->salva($user) != 1) {
               echo '<p class="messaggio">Salvataggio fallita</p>';   
        }
        
    }
    
    /**
     *  Aggiorno gli attributi di un corso
     * @param type $mod_corso
     * @param type $request
     */
    private function aggiornaCorso($mod_corso, &$request) {
        
        // aggiorno il nome del corso
        if (isset($request['nomeCorso'])) {
            $mod_corso->setNome($request['nomeCorso']);
        }
        
        // aggiorno la descrizione del corso
        if (isset($request['descrizione'])) {
            $mod_corso->setDescrizione($request['descrizione']);
        }
        
        // aggiorno la durata del corso
        if (isset($request['durata'])) {
            $mod_corso->setDurata($request['durata']);
        }
        
        // aggiorno il numero massimo di partecipanti al corso
        if (isset($request['NMax'])) {
            $mod_corso->setNMax($request['NMax']);
        }
    }
    
    /**
     * Cerco il corso di cui si richiede la cancellazione o la modifica
     * @param type $request
     * @return type
     */
    private function getCorso(&$request) {
        if (isset($request['corso'])) {
            $corso_codice = filter_var($request['corso'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $corso = CorsiFactory::instance()->cercaCorsoPerCodice($corso_codice);
            if ($corso == null) {
                echo '<p class="messaggio">Corso non corretto</p>';
            }
            return $corso;
        } else {
            return null;
        }
    }
    
    /**
     * Cerco tra i corsi tenuti da un istruttore uno specifico corso di dato codice
     * @param type $codice
     * @param type $corsi
     * @return type
     */
    private function cercaCorsoPerCodice($codice, &$corsi) {
        foreach ($corsi as $corso) {
            if ($corso->getCodice() == $codice) {
                return $corso;
            }
        }
        return null;
    }
}
?>
