<?php

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Paginazione;
use itcbonelli\donatempo\tabelle\Disponibilita;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Disponibilità - Gestione Donatempo";
$link_attivo = 'disponibilita';



$adb = new AiutoDB($dbconn);

$query = "SELECT disponibilita.*, utenti.username, associazioni.ragsoc
FROM disponibilita 
JOIN utente_partecipa_associazione partecipa ON partecipa.id_partecipazione = disponibilita.id_partecipazione
JOIN utenti ON utenti.id_utente = partecipa.utenti_id_utente
JOIN associazioni ON partecipa.associazioni_id_associazione = associazioni.id_associazione";
$query .= " ORDER BY data_disp DESC, ora_inizio DESC ";

$pagination=new Paginazione($adb->eseguiScalare("SELECT COUNT(*) FROM disponibilita"));
$query.= $pagination->getLimit();
$disponibilita = $adb->eseguiQuery($query);

ob_start();
?>
<h1>Gestione disponibilità di tempo</h1>

<p>
    <a href="disponibilita-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi</a>
</p>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>Utente</th>
            <th>Data</th>
            <th>Ora inizio</th>
            <th>Ora fine</th>
            <th>Associazione</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($disponibilita as $disp) : ?>
            <tr>
                <td><?= $disp['username']; ?></td>
                <td><?= $disp['data_disp']; ?></td>
                <td><?= $disp['ora_inizio']; ?></td>
                <td><?= $disp['ora_fine']; ?></td>
                <td><?= $disp['ragsoc']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $pagination->mostraPaginazione(); ?>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>