<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\tabelle\Associazione;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Elenco associazioni - Gestione Donatempo";
$link_attivo = 'associazioni';

$associazioni = Associazione::elencoAssociazioni();

ob_start();
?>
<h1>Elenco associazioni</h1>

<p><a href="associazione-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi associazione</a></p>

<table id="tab_associaz" class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th style="width: 32px;">Id.</th>
            <th>ragione sociale</th>
            <th>Cod. fis.</th>
            <th>Logo</th>
            <th class="text-center">Attivo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($associazioni as $associazione) : ?>
            <tr>
                <td><?= $associazione->id_associazione; ?></td>
                <td><a href="associazione-edit.php?id=<?= $associazione->id_associazione; ?>"><?= $associazione->ragsoc; ?></a></td>
                <td><?= $associazione->codfis; ?></td>
                <td><?= $associazione->url_logo; ?></td>
                <td class="text-center">
                    <?php AiutoHTML::yesNo($associazione->attivo); ?>                   
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