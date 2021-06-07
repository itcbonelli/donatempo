<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Esercente;

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Esercenti - Gestione Donatempo";
$link_attivo = 'esercenti';

$esercenti = Esercente::ElencoEsercenti();

ob_start();
?>
<h1>Elenco esercenti</h1>

<p>
    <a href="esercente-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi esercente</a>
</p>

<table id="tabella_esercenti" class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>Id.</th>
            <th>nome (ragione sociale)</th>
            <th>partita iva</th>
            <th>codice comune</th>
            <th>indirizzo</th>
            <th>cap</th>
            <th>attivo</th>
        </tr>
    <tbody>

        <?php foreach ($esercenti as $esercente) : ?>
            <tr>

                <td><?= $esercente->id_esercente; ?></td>
                <td><a href="esercente-edit.php?id=<?php echo $esercente->id_esercente; ?>"><?php echo $esercente->nome; if(!empty($esercente->ragsoc)) echo "<br /><em><small>{$esercente->ragsoc}" ?></small></em></a></td>
                <td><?= $esercente->piva; ?></td>
                <td><?= $esercente->cod_comune; ?></td>
                <td><?= $esercente->indirizzo; ?></td>
                <td><?= $esercente->cap; ?></td>
                <td><?= AiutoHTML::yesNo($esercente->attivo); ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>