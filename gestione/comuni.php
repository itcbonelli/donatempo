<?php

use itcbonelli\donatempo\tabelle\Comune;

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Elenco comuni";
$link_attivo = 'comuni';

$comuni = Comune::getElencoComuni();

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione comuni</h1>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th>Cod. cat.</th>
                <th>Denominazione</th>
                <th>Prov.</th>
                <th>Coordinate</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comuni as $comune) : ?>
                <tr>

                    <td><?= $comune->id_comune ?></td>
                    <td><?= $comune->denominazione ?></td>
                    <td><?= $comune->provincia ?></td>
                    <td><?= "{$comune->latitudine}, {$comune->longitudine}" ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>