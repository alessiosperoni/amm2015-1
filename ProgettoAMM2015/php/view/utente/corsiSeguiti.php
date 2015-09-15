<h2>Corsi seguiti<br>
da <?= $user->getNome() ?> <?= $user->getCognome() ?> </h2>

<?php if (count($corsi) > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>Nome Corso</th> 
                <th>Durata Corso</th>
                <th>Data Iscrizione</th> 
                <th>Giorno Corso</th>
                <th>Orario Corso</th>
                <th>Pagato</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
            foreach ($corsi as $corso) {
                    ?>
                    <tr <?= $k % 2 == 0 ? 'class="alt-row"' : '' ?>>
                        <td><?= $corso->getCorso()->getNome() ?></td>
                        <td><?= $corso->getCorso()->getDurata() ?></td> 
                        <td><?= $corso->getDataIscrizione() ?></td>
                        <td><?= $corso->getEdizione()->getGiorno() ?></td> 
                         <td><?= $corso->getEdizione()->getOra() ?></td> 
                        <td><?= $corso->getPagato() ?></td>
                    </tr>
                    <?php
                    $k++;
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="messaggio"> Nessun corso presente </p>
<?php } ?>