<?php

use itcbonelli\donatempo\tabelle\Richiesta;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Richieste di aiuto - Gestione Donatempo";
$link_attivo = 'richieste';

$richieste = Richiesta::ElencoRichieste();

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elenco richieste di aiuto</h1>

<form action="" method="get">
    <fieldset>
        <legend>Filtri</legend>

        <div class="row">
            <div class="col">
                <label for="filtro_stato_avanzamento">Stato avanzamento</label>
                <select id="filtro_stato_avanzamento" name="filtro_stato_avanzamento" class="form-control form-control-sm">
                    <option value="">Tutti gli stati di avanzamento</option>
                </select>
            </div>
            <div class="col">
                <label for="filtro_associazione">Associazione</label>
                <select name="filtro_associazione" id="filtro_associazione" class="form-control form-control-sm">
                    <option value="">Tutte le associazioni</option>
                </select>
            </div>

        </div>
        <div class="row mt-2">
            <div class="col">
                <button class="btn btn-secondary btn-sm">Applica</button>
            </div>
        </div>
    </fieldset>

</form>
<p>&nbsp;</p>
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>Identificativo</th>
            <th>Data inserimento</th>
            <th>Stato avanzamento</th>
            <th>Richiedente</th>
            <th>Servizio richiesto</th>
            <th>Durata (minuti)</th>
            <th>Attivo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($richieste as $richiesta) : ?>
            <tr>
                <td><?php echo $richiesta->id_richiesta; ?></td>
                <td><?php echo $richiesta->data_inserimento; ?></td>
                <td>
                    <?php echo $richiesta->tipo; ?>
                </td>
                <td><?php echo $richiesta->durata; ?></td>
                <td>
                    <?php echo $richiesta->attivo ? 'Sì' : 'No'; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>