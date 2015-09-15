<div class="input-form">
    <h2 class="icon-title" id="h-personali">Profilo<br>
    <?= $user->getNome() ?> <?= $user->getCognome() ?>
</div>

<div class="input-form">
    <h3>Dati personali</h3>
    <form method="post" action="index.php?page=utente&subpage=profilo<?= $vd->scriviToken('?')?>">
               <input type="hidden" name="cmd" value="dati_personali"/>
               
               <label for="datan"><strong> Data di nascita: </strong></label>
               <input type="text" name="DataNascita" id="datan" value="<?= $user->getDataNascita() ?>"/>
               <br>
               <label for="tel"><strong>Telefono:</strong></label>
               <input type="text" name="Telefono" id="tel" value="<?= $user->getTelefono() ?>"/>
               <br/>
               <label for="datac"><strong>Data certificato medico:</strong></label>
               <input type="text" name="DataCertificato" id="datac" value="<?= $user->getDataCertificato() ?>"/>
               <br/>
               <input type="submit" value="Salva"/>
    </form>
</div>
