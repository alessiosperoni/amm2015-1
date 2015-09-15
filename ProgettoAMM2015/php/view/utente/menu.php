<ul>
    <li class="logout"> <a href="index.php?page=utente&cmd=logout">  Logout </a> </li> 
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="index.php?page=utente<?= $vd->scriviToken('?')?>">Home</a></li>
    <li><a href="#segnalibro">Contatti</a></li>
    <li class="<?= $vd->getSottoPagina() == 'corsiSeguiti' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=corsiSeguiti<?= $vd->scriviToken('?')?>">Corsi seguiti</a></li>
    <li class="<?= $vd->getSottoPagina() == 'iscrizioneCorso' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=iscrizioneCorso<?= $vd->scriviToken('?')?>">Iscrizione corso</a></li>
</ul>