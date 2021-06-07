<?php

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Paginazione;
use itcbonelli\donatempo\tabelle\Comune;

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Elenco comuni - Gestione Donatempo";
$link_attivo = 'comuni';

$comuni = Comune::getElencoComuni();

ob_start();
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
                    <td><a href="comune-edit.php?id=<?= $comune->id_comune ?>"><?= $comune->id_comune ?></a></td>
                    <td><?= $comune->denominazione ?></td>
                    <td><?= $comune->provincia ?></td>
                    <td><?= "{$comune->latitudine}, {$comune->longitudine}" ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$conta = (new AiutoDB($dbconn))->eseguiScalare("SELECT count(*) FROM comuni");
$pp = new Paginazione($conta);
$pp->mostraPaginazione();
?>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>