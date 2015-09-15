<div class="input-form">
    <h2>Aggiunta utente</h2>
</div>

<div class="input-form">
    <h3>Dati utente</h3>
    <form method="post" action="index.php?page=istruttore&subpage=home<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="aggiungi_iscrivi"/>
             
        <label for="username"><strong> Username: </strong></label>
        <input type="text" name="username" id="username" />
        <br/>
        <label for="password"><strong>Password:</strong></label>
        <input type="password" name="password" id="password"/>
        <br/>
        <label for="cognome"><strong> Cognome: </strong></label>
        <input type="text" name="Cognome" id="cognome" />
        <br/>
        <label for="Nome"><strong> Nome: </strong></label>
        <input type="text" name="Nome" id="Nome" />
        <br/>
        <label for="datan"><strong> Data di nascita (aaaa-mm-gg): </strong></label>
        <input type="text" name="DataNascita" id="datan" />
        <br/>
        <label for="telefono"><strong> Telefono: </strong></label>
        <input type="text" name="Telefono" id="telefono" />
        <br/>
        <label for="datac"><strong>Data certificato medico (aaaa-mm-gg):</strong></label>
        <input type="text" name="DataCertificato" id="datac"/>
        <br/>

        <h2>Aggiunta iscrizione ai corsi di<br>
        <?= $user->getNome() ?> <?= $user->getCognome() ?>
        </h2>   
        <h3>Iscrizione</h3>
        <label for="datai"><strong> Data iscrizione (aaaa-mm-gg): </strong></label>
        <input type="text" name="DataIscrizione" id="datai" />
        <br/>
        <strong> Pagato: </strong>
        <label for="pagato_si"><strong> SI </strong></label>
        <input type="radio" name="Pagato" id="pagato_si" value="SI"/>
        <label for="pagato_no"><strong> NO </strong></label>
        <input type="radio" name="Pagato" id="pagato_no" value="NO"/>
        <br/>
        <strong>Corso:</strong>
        <select name="NumeroEdizione">
        <?php $c = 0;
            foreach($corsi as $corso) { ?>
              <option value="<?= $corso->getEdizione()->getNumero() ?>"> <?= $corso->getNome() ?></option>
               
        <?php $c++; } ?>
        </select>
        <input type="submit" value="aggiungi"/>
              
    </form>
</div>
