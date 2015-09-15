<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> Descrizione dell'applicazione</title>
    </head>
    
    <body>
        
        <ul>
            <li><h2><strong> Descrizione dell'applicazione </strong></h2></li>
        </ul>
        <p> L'applicazione gestisce corsi offerti da una palestra alla propria clientela.<br>
            I corsi si caratterizzano per: <br>
        </p>
            <ol>
                <li>La presenza di istruttori specializzati</li>
                <li>Numero massimo di partecipanti variabile per ciascun corso</li>
                <li>Offerta dello stesso corso in diversi orari della giornata (Edizioni)</li>
                <li>La partecipazione al corso con idoneo certificato medico di durata annuale.</li>
            </ol>
        <p>
            L'applicazione ha due ruoli: <b> utente </b> e <b> istruttore</b>.
        </p>
        
        <p>
            Il ruolo <b>utente</b> rappresenta un cliente della palestra. Una volta autenticato con ruolo utente 
            (nella pagina di login) è possibile:<br>
        </p>
       
            <ol>
                <li>Accedere al profilo (impostazioni) e modificarne i dati</li>
                <li>Accedere alla sicurezza (password e username) e modificarla</li>
                <li>Accedere ai corsi seguiti dall'utente autenticato</li>
                <li>Iscrivere l'utente autenticato ad un corso. In questo caso l'iscrizione è possibile
                solo nel caso in cui il certificato medico dell'utente non sia scaduto e il corso abbia
                ancora posti disponibili (in caso di certificato medico scaduto, nella sezione "Iscrizione corso"
                apparirà il messaggio corrispondente e non sarà possibile nè vedere nè tanto meno iscriversi ai corsi (provare a modificare la data del certificato dalle impostazioni);
                in caso, invece, di superamento dei posti massimi disponibili, l'utente verrà avvisato: "Siamo spiacenti. Posti disponibili non sufficienti.").</li>
            </ol>
        
        <p>
            Il ruolo <b>istruttore</b> rappresenta un istruttore che dirige uno o piu' corsi all'interno della palestra.
            Una volta autenticato con ruolo istruttore (nella pagina di login) è possibile:<br>
        </p>
        
            <ol>
                 <li>Accedere al profilo (impostazioni) e modificarne i dati</li>
                 <li>Accedere alla sicurezza (password e username) e modificarla</li>
                 <li>Accedere ai corsi gestiti dall'istruttore autenticato e modificarne gli attributi.</li>
                 <li>Accedere alla lista degli iscritti ai corsi tenuti dall'istruttore autenticato (in questo caso
                     la dicitura "Nessuno" nella colonna "Iscritti" sta a significare che gli iscritti al corso corrispondente hanno tutti il certificato medico scaduto)</li>
                 <li>Aggiungere un utente e iscriverlo ad uno dei corsi tenuti dall'istruttore autenticato (in questo caso
                     tutti i campi richiesti vanno compilati affinchè l'aggiunta vada a buon fine).</li>
            </ol>
        
        <br>
        <p>
            L'applicazione consente di passare da un ruolo all'altro attraverso <b> logout </b> e sucessivo 
            <b> login</b>.
        </p>
        <br>
        
        <ul>
            <li><h2><strong> Elenco di quali requisiti soddisfatti </strong></h2></li>
        </ul>
        
            <ol>
                <li>Utilizzo di HTML e CSS (HTML presente in molte pagine php (cartella php); CSS presente nella pagina css/layout.css)</li>
                <li>Utilizzo di PHP e MySQL (PHP presente in molte pagine php (cartella php); MySQL presente in molte pagine php (cartella php)</li>
                <li>Utilizzo del pattern MVC (le cartelle all'interno del progetto sono suddivise in "model-view-controller")</li>
                <li>Due ruoli (come già detto in precedenza, ruolo utente e ruolo istruttore)</li>
                <li>Una transazione (con 2 query tra autocommit(); e commit(); la transazione è implementata 
                    nella classe php/model/CorsiFactory.php all'interno della funzione <b>addSignIn()</b>;</li>
                <li>Una funzionalità ajax (vedere Ajax/validazione.js assieme ai file controla.php e users.class.php</li>
            </ol>
        
        <p>
            Per quanto riguarda la funzionalità ajax essa riguarda la validazione della password e della
            username quando uno dei due ruoli decide di modificare la sicurezza. In particolare:
            prima di effettuare la submit, si fa una richiesta ajax che verifica
            l’ammissibilità dei valori inseriti nel form. I messaggi vengono mostrati senza ricaricare la pagina.
        </p>
        <br>
        
        <ul>
            <li><h2><strong> Credenziali di autenticazione, link alla homepage e alla repository git</strong></h2></li>
        </ul>
        
        <p> <strong> Credenziali</strong> </p>
            <ul>
                <li>ruolo utente
                    <ul>
                        <li> username: utente</li>
                        <li> password: Progetto15</li>
                    </ul>
                <li>ruolo istruttore
                    <ul>
                        <li> username: istruttore</li>
                        <li> password: Progetto15</li>
                    </ul>
            </ul>
        
        <p> <strong> Homepage</strong> </p>
        <ul>
            <li> <a href="http://spano.sc.unica.it/amm2015/virdisSamuele/ProgettoAMM2015/php/index.php?page=login">http://spano.sc.unica.it/amm2015/virdisSamuele/ProgettoAMM2015/php/index.php?page=login</a></li>
        </ul>
        
        <p> <strong> Link alla repository </strong> </p>
        <ul>
            <li> <a href="https://github.com/SamueleVirdis/amm2015"> https://github.com/SamueleVirdis/amm2015</a></li>
        </ul>
    </body>
</html>
