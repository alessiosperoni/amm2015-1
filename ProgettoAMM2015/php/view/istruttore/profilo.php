<div class="input-form">
    <h2>Profilo<br>
    <?= $user->getNome() ?> <?= $user->getCognome() ?></h2>
</div>

<div class="input-form">
        <h3>Dati personali e Contatti</h3>
    <form method="post" action="index.php?page=istruttore&subpage=profilo<?= $vd->scriviToken('?')?>">
               <input type="hidden" name="cmd" value="dati_personali"/>
               
               <label for="datan"><strong> Data di nascita: </strong></label>
               <input type="text" name="DataNascita" id="datan" value="<?= $user->getDataNascita() ?>"/>
               <br>
               <label for="cod"><strong>Codice Fiscale:</strong></label>
               <input type="text" name="CodiceFiscale" id="cod" value="<?= $user->getCodiceFiscale() ?>"/>
               <br/>
               <label for="mail"><strong>Email:</strong></label>
               <input type="text" name="Email" id="mail" value="<?= $user->getEmail() ?>"/>
               <br/>
               <input type="submit" value="Salva"/>
    </form>
</div>
