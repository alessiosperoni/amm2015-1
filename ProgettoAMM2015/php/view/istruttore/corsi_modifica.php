<div class="input-form">
    <h3>Modifica corso</h3>
    <form method="post" action="index.php?page=istruttore&subpage=corsi_modifica<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="corso" value="<?= $mod_corso->getCodice() ?>"/>
        <label for="nomeCorso">Nome</label>
        <input type="text" name="nomeCorso" id="nomeCorso" value="<?= $mod_corso->getNome() ?>"/>
        <br/>
        <label for="descrizione">Descrizione</label>
        <input type="text" name="descrizione" id="descrizione" value="<?= $mod_corso->getDescrizione() ?>"/>
        <br/>
         <label for="durata">Durata</label>
        <input type="text" name="durata" id="durata" value="<?= $mod_corso->getDurata() ?>"/>
        <br/>
        <label for="NMax">Partecipanti massimi</label>
        <input type="text" name="NMax" id="NMax" value="<?= $mod_corso->getNMax() ?>"/>
        <br/>
        <div class="save">
            <button type="submit" name="cmd" value="salva">Salva</button>
        </div>
    </form>
</div>

