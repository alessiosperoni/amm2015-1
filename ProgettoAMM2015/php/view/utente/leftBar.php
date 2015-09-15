<h2>Navigazione</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="index.php?page=utente<?= $vd->scriviToken('?')?>">Home</a></li>
    <li><a href="#segnalibro">Contatti</a></li>
    <li class="<?= $vd->getSottoPagina() == 'profilo' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=profilo<?= $vd->scriviToken('?')?>">Impostazioni</a></li>
    <li class="<?= $vd->getSottoPagina() == 'sicurezza' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=sicurezza<?= $vd->scriviToken('?')?>">Sicurezza</a></li>
    <li class="<?= $vd->getSottoPagina() == 'corsiSeguiti' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=corsiSeguiti<?= $vd->scriviToken('?')?>">Corsi seguiti</a></li>
    <li class="<?= $vd->getSottoPagina() == 'iscrizioneCorso' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=iscrizioneCorso<?= $vd->scriviToken('?')?>">Iscrizione corso</a></li>
</ul>
