<?php

use itcbonelli\donatempo\tabelle\Provincia;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Elenco province";
$link_attivo = 'province';

$province = Provincia::caricaTutte();

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elenco province</h1>

<table id="tabella_province" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>sigla</th>
            <th>denominazione</th>
            <th>regione</th>
        </tr>
    <tbody>
        <?php foreach ($province as $provincia) : ?>
            <tr>
                <td><?php echo $provincia->sigla; ?></td>
                <td>
                    <a href="provincia-edit.php?sigla=<?php echo ($provincia->sigla); ?>">
                        <?php echo $provincia->denominazione; ?>
                    </a>
                </td>
                <td><?php echo $provincia->regione; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>