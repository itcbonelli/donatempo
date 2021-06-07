<?php
require_once __DIR__ . '/../include/main.php';
use itcbonelli\donatempo\tabelle\StatoAvanzamento;

$titolo_pagina = "Stati di avanzamento richiesta - Gestione Donatempo";
$link_attivo = 'stati-avanzamento';
$stati = StatoAvanzamento::ElencoStatiAvanzamento();
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elenco stati di avanzamento</h1>

<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>Codice</th>
            <th>Descrizione</th>
            <th>Ordine visuale</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($stati as $stato) {
        echo "<tr>
        <td>{$stato->codice}</td>
        <td>{$stato->descrizione}</td>
        <td>{$stato->ordine_vis}</td>
        </tr>";
    } ?>
    </tbody>
</table>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>