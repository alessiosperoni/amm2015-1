<ul>
    <li class="logout"> <a href="index.php?page=istruttore&cmd=logout">  Logout </a> </li> 
    <li class="<?= strpos($vd->getSottoPagina(),'home') !== false || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="index.php?page=istruttore&subpage=home<?= $vd->scriviToken('?')?>">Home</a></li>
    <li><a href="#segnalibro">Contatti</a></li>
    <li class="<?= strpos($vd->getSottoPagina(), 'corsi') !== false ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=corsi<?= $vd->scriviToken('?')?>">Corsi</a></li>
    <li class="<?= strpos($vd->getSottoPagina(),'lista_iscritti') !== false ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=lista_iscritti<?= $vd->scriviToken('?')?>">Lista iscritti</a></li>
    <li class="<?= strpos($vd->getSottoPagina(),'aggiungi_iscrizione') !== false ? 'current_page_item' : '' ?>"><a href="index.php?page=istruttore&subpage=aggiungi_iscrizione<?= $vd->scriviToken('?')?>">Aggiungi e iscrivi</a></li>
</ul>
