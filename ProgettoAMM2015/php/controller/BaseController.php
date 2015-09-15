<?php

include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
include_once basename(__DIR__) . '/../model/UtenteGenericoFactory.php';

class BaseController {

    const user = 'user';
    const ruolo = 'ruolo';
    const nessuno = '_nessuno';
    
    public function __construct() {
        
    }

    public function invoke(&$request) {
      
        $vd = new ViewDescriptor();
        
        $vd->setPagina($request['page']);

        $this->setImpostaToken($vd, $request);
        
        // gestione input
        if (isset($request["cmd"])) {
            // controllo il comando
            switch ($request["cmd"]) {
                // Sono nella pagina di login
                case 'index.php?page=login':
                    $this->showLogin($vd);
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                    // Loggo
                    $this->login($vd, $username, $password);
                
                    // inizializzo l'utente
                    if($this->loggedIn()) {
                        $user = UtenteGenericoFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::ruolo]);
                    }
                    
                    break;
                default : $this->showLogin($vd);
            }
        } else {
            if ($this->loggedIn()) {
                $user = UtenteGenericoFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::ruolo]);
                $this->showHomeUtente($vd);
            } else {
             
                $this->showLogin($vd);
            }
        }
        
     require basename(__DIR__) . '/../view/master.php';
    }
    
    /**
     * Mostra la pagina dell'utente
     * @param type $vd
     */
    protected function showUtente($vd) {
        $vd->setTitolo(" Utente ");
        $vd->setMenu(basename(__DIR__) . '/../view/utente/menu.php');
        $vd->setLeftBar(basename(__DIR__) . '/../view/utente/leftBar.php');
        $vd->setRightBar(basename(__DIR__) . '/../view/utente/rightBar.php');
        $vd->setContent(basename(__DIR__) . '/../view/utente/content.php');
    }

    /**
     *  Mostra la pagina dell'istruttore
     * @param type $vd
     */
    protected function showIstruttore($vd) {
        $vd->setTitolo(" Istruttore ");
        $vd->setMenu(basename(__DIR__) . '/../view/istruttore/menu.php');
        $vd->setLeftBar(basename(__DIR__) . '/../view/istruttore/leftBar.php');
        $vd->setRightBar(basename(__DIR__) . '/../view/istruttore/rightBar.php');
        $vd->setContent(basename(__DIR__) . '/../view/istruttore/content.php');
    }
    
    /**
     * Mostra la pagina di login
     * @param type $vd
     */
    protected function showLogin($vd) {
        $vd->setTitolo("Palestra Login");
        $vd->setMenu(basename(__DIR__) . '/../view/login/menu.php');
        $vd->setLeftBar(basename(__DIR__) . '/../view/login/leftBar.php');
        $vd->setRightBar(basename(__DIR__) . '/../view/login/rightBar.php');
        $vd->setContent(basename(__DIR__) . '/../view/login/content.php');
    }
    
    /**
     *  Mostra, a seconda del ruolo, la pagina dell'utente o la pagina dell'istruttore
     * @param type $vd
     */
    protected function showHomeUtente($vd) {
        
        $user = UtenteGenericoFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::ruolo]);
        switch ($user->getRuolo()) {
            // se il ruolo è "utente"
            case UtenteGenerico::Utente:
                // mostro la pagina dell'utente
                $this->showUtente($vd);
                break;
            // se il ruolo è "istruttore"
            case UtenteGenerico::Istruttore:
                // mostro la pagina dell'istruttore
                $this->showIstruttore($vd);
                break;
        }
    }
    
    /**
     * Aggiorna la data di nascita dell'istruttore o dell'utente ( modificata dalle impostazioni)
     * @param type $user
     * @param type $request
     */
    protected function aggiornaDataNascita($user, &$request) {
        
        // aggiorno la data di nascita
        if (isset($request['DataNascita'])) {
            $user->setDataNascita($request['DataNascita']);
        }
        
        // salvo i cambiamenti
        UtenteGenericoFactory::instance()->salva($user);
    }
    
    /**
     *  Funzione che controlla se esiste un utente che può autenticarsi con $password e $username
     * @param type $vd
     * @param type $username
     * @param type $password
     */
    protected function login($vd, $username, $password) {
        
        $user = UtenteGenericoFactory::instance()->caricaUtente($username, $password);
        if (isset($user) && $user->esiste()) {
            $_SESSION[self::user] = $user->getId();
            $_SESSION[self::ruolo] = $user->getRuolo();
            $this->showHomeUtente($vd);
        } else {
            // utente inesistente, mostro la pagina di login
            echo '<p class="messaggio">Utente sconosciuto o password errata</p>';
            $this->showLogin($vd);
        }
    }
    
    /**
     * Funzione che termina una sessione e mostra nuovamente la pagina di login.
     * @param type $vd
     */
    protected function logout($vd) {

        $_SESSION = array();
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            
            setcookie(session_name(), '', time() - 2592000, '/');
        }
        session_destroy();
        
        // sessione terminata, mostro pagina login
        $this->showLogin($vd);
    }
    
    /**
     * Controllo di logged in
     * @return type
     */
    protected function loggedIn() {
        return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
    }
    
    /**
     * Imposta il token
     * @param ViewDescriptor $vd
     * @param type $request
     */
    protected function setImpostaToken(ViewDescriptor $vd, &$request) {

        if (array_key_exists('_nessuno', $request)) {
            $vd->setImpostaToken($request['_nessuno']);
        }
    }

}

?>