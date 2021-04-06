<?php
require __DIR__ . '/../include/main.php';
$titolo_pagina = "Elenco associazioni";
$link_attivo = 'associazioni';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elenco associazioni</h1>

<p><a href="associazione-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi associazione</a></p>

<table id="tab_associaz" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Identificativo</th>
            <th>ragione sociale</th>
            <th>Cod. fis.</th>
            <th>Logo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td></td>
            <td>RSSFNC82H16L219B</td>
            <td></td>
        </tr>
    </tbody>
</table>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>