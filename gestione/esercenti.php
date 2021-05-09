<?php

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
            <th>esercente</th>
            <th>nome</th>
            <th>ragione sociale</th>
            <th>partita iva</th>
            <th>codice comune</th>
            <th>indirizzo</th>
            <th>cap</th>
            <th>attivo</th>
        </tr>
    <tbody>

        <?php foreach ($esercenti as $esercente) : ?>
            <tr>

                <td>1</td>
                <td><a href="esercente-edit.php?id=<?php echo $esercente->id_esercente; ?>"><?php echo $esercente->nome; if(!empty($esercente->ragsoc)) echo "<br /><em><small>{$esercente->ragsoc}" ?></small></em></a></td>
                <td>caio</td>
                <td>00281783340</td>
                <td>D205</td>
                <td>corso nizza</td>
                <td>12100</td>
                <td>attivo</td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>