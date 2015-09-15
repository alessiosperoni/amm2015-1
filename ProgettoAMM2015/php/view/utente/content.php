<?php
switch ($vd->getSottoPagina()) {
    case 'profilo':
        include_once 'profilo.php';
        break;
    
    case 'sicurezza':
        include_once 'sicurezza.php';
        break;
    
    case 'corsiSeguiti':
        include_once 'corsiSeguiti.php';
        break;

    case 'iscrizioneCorso':
        include_once 'iscrizioneCorso.php';
        break;
    default:
        
        ?>
        <p> Benvenuto a Bsb Center the Temple of Fitness</p>
       
        <p>
            Accedi a:
        </p>
        <ul class="contenuto">
            <li><a href="index.php?page=utente&subpage=profilo<?= $vd->scriviToken('?')?>">Impostazioni</a></li>
            <li><a href="index.php?page=utente&subpage=sicurezza<?= $vd->scriviToken('?')?>">Sicurezza</a></li>
            <li><a href="index.php?page=utente&subpage=corsiSeguiti<?= $vd->scriviToken('?')?>">Corsi seguiti</a></li>
            <li><a href="index.php?page=utente&subpage=iscrizioneCorso<?= $vd->scriviToken('?')?>">Iscrizione corsi</a></li>       
        </ul>
        <?php
        break;
}
?>


