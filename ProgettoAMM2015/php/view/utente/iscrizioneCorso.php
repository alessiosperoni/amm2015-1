<h2>Iscrizione corsi <br>per
<?= $user->getNome() ?> <?= $user->getCognome() ?> </h2>

<?php
// Controllo se il certificato medico è scaduto
$data1 = strtotime($user->getDataCertificato());
$data2 = strtotime(date("Y-m-d"));
// differeza tra data odierna e data del certificato
$differenza = (($data2-$data1)/3600)/24;

// Se è scaduto, non permetto l'iscrizione ai corsi
if(floor($differenza) > 365) {
?>
<p class='scadenza'> Siamo spiacenti, il suo certificato medico e' scaduto.<br>
    Non e' possibile iscriversi ai corsi fino al suo rinnovo.
    <br><br>
    <b>N.B.</b>: il certificato medico ha durata annuale.
    <br><br>
</p>

<p> Controllare la data del certificato </p>
  <ul>
    <li class="<?= $vd->getSottoPagina() == 'profilo' ? 'current_page_item' : '' ?>"><a href="index.php?page=utente&subpage=profilo<?= $vd->scriviToken('?')?>">Impostazioni</a></li>
  </ul>
<?php }
// Certificato medico non scaduto
elseif (count($corsiIscrizione) > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrizione corso</th>
                <th>Durata</th>
                <th>Partecipanti massimi</th>
                <th>Prezzo</th>
                <th>Iscrizione</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $k = 0;
            foreach ($corsiIscrizione as $corso) {
                
                if (!$corso->inLista($user)) {
                ?>
                <tr <?= $k % 2 == 0 ? 'class="alt-row"' : '' ?>>
                   
                    <td><?= $corso->getNome() ?></td> 
                    <td><?= $corso->getDescrizione() ?></td>
                    <td><?= $corso->getDurata() ?></td>
                    <td><?= $corso->getNMax() ?></td>
                     <td><?= $corso->getEdizione()->getPrezzo() ?></td>
                    <td><a href="index.php?page=utente&subpage=iscrizioneCorso&cmd=iscrivi&iscrizione=<?= $i ?><?= $vd->scriviToken('&') ?>" title="Iscrivi al corso">Iscriviti</a></td>
                    <td>
                    </td>
                </tr>
                <?php
                    $k++;
                }
                $i++;
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="messaggio"> Nessun corso presente </p>
<?php } ?>
