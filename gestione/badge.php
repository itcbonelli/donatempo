<?php

use itcbonelli\donatempo\tabelle\Badge;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Badge - Gestione Donatempo";
$link_attivo = 'badge';
$badges = Badge::elenco();
ob_start();
?>
<h1>Gestione badge</h1>

<p>
    <a href="badge-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi</a>
</p>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>Immagine</th>
            <th>Nome</th>
            <th>Descrizione</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($badges as $badge) : ?>
            <tr>
                <td class="text-center"><img src="../uploads/badge/<?= $badge->url_immagine ?>" alt="Immagine badge" class="icona48"></td>
                <td><a href="badge-edit.php?id=<?= $badge->id_badge; ?>"><?= $badge->nome; ?></a></td>
                <td><?= $badge->descrizione; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>