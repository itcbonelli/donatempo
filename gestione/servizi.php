<?php

use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Servizi - Gestione Donatempo";
$link_attivo = 'servizi';

$servizi=Servizio::elencoServizi();

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elenco servizi</h1>

<p><a href="servizio-edit.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi servizio</a></p>

<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Tipologia</th>
            <th>Durata (minuti)</th>
            <th>Attivo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($servizi as $servizio) : ?>
        <tr>
            <td><a href="servizio-edit.php?id=<?php echo $servizio->id_servizio; ?>"><?php echo $servizio->nome; ?></a></td>
            <td>
                <?php echo $servizio->tipo; ?>
            </td>
            <td><?php echo $servizio->durata; ?></td>
            <td>
                <?php echo $servizio->attivo ? 'Sì' : 'No'; ?>
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