<?php
switch ($vd->getSottoPagina()) {
    case 'profilo':
        include 'profilo.php';
        break;
    
    case 'sicurezza':
        include 'sicurezza.php';
        break;
        
    case 'corsi':
        include 'corsi.php';
        break;
    
    case 'corsi_modifica':
        include 'corsi_modifica.php';
        break;
    
    case 'lista_iscritti':
        include 'lista_iscritti.php';
        break;
   
    case 'aggiungi_iscrizione':
        include 'aggiungi_iscrizione.php';
        break;
    
    default:
?>
        <p> Benvenuto a Bsb Center the Temple of Fitness</p>
       
        <p>
            Accedi a:
        </p>
        <ul class="contenuto">
            <li><a href="index.php?page=istruttore&subpage=profilo<?= $vd->scriviToken('?')?>">Impostazioni</a></li>
            <li><a href="index.php?page=istruttore&subpage=sicurezza<?= $vd->scriviToken('?')?>">Sicurezza</a></li>
            <li><a href="index.php?page=istruttore&subpage=corsi<?= $vd->scriviToken('?')?>">Corsi</a></li>
            <li><a href="index.php?page=istruttore&subpage=lista_iscritti<?= $vd->scriviToken('?')?>">Lista Iscritti</a></li>
            <li><a href="index.php?page=istruttore&subpage=aggiungi_iscrizione<?= $vd->scriviToken('?')?>">Aggiungi e iscrivi</a></li>
        </ul>
        <?php
        break;
}
?>
