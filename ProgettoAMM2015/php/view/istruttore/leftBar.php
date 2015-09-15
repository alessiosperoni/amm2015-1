<h2>Navigazione</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="index.php?page=istruttore&subpage=home<?= $vd->scriviToken('?')?>">Home</a></li>
    <li><a href="#segnalibro">Contatti</a></li>
    <li class="<?= $vd->getSottoPagina() == 'profilo' ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=profilo<?= $vd->scriviToken('?')?>">Impostazioni</a></li>
    <li class="<?= $vd->getSottoPagina() == 'sicurezza' ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=sicurezza<?= $vd->scriviToken('?')?>">Sicurezza</a></li>
    <li class="<?= $vd->getSottoPagina() == 'corsi' ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=corsi<?= $vd->scriviToken('?')?>">Corsi</a></li>
    <li class="<?= strpos($vd->getSottoPagina(),'lista_iscritti') !== false ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=lista_iscritti<?= $vd->scriviToken('?')?>">Lista iscritti</a></li>
    <li class="<?= strpos($vd->getSottoPagina(),'aggiungi_iscrizione') !== false ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=aggiungi_iscrizione<?= $vd->scriviToken('?')?>">Aggiungi e iscrivi</a></li>
</ul>

