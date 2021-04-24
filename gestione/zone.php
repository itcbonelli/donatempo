<?php

use itcbonelli\donatempo\tabelle\Zona;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Gestione zone - Gestione Donatempo";
$link_attivo = 'zone';

$zone = Zona::ElencoZone();

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione zone geografiche</h1>
<p>
    <a href="zona-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi zona</a>
</p>

<table id="tabella_zone" class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th style="width: 48px">Id</th>
            <th>Denominazione</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($zone as $zona) : ?>
            <tr>
                <td><?php echo $zona->id_zona; ?></td>
                <td>
                    <a href="zona-edit.php?id_zona=<?php echo ($zona->id_zona); ?>">
                        <?php echo $zona->denominazione; ?>
                    </a>
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