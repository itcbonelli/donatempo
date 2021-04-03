<?php

use itcbonelli\donatempo\filtri\FiltroUtenti;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Gestione utenti";
$link_attivo = 'utenti';

$filtro = new FiltroUtenti();
$utenti = Utente::ElencoUtenti($filtro);

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione utenti</h1>

<p>
    <a class="btn btn-primary" href="utente-edit.php" role="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Crea utente</a>
</p>

<div class="table-responsive">
    <table id="tabella_utenti" class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th><abbr title="Identificativo utente">Id</abbr></th>
                <th>Nome utente</th>
                <th>Email</th>
                <th>Data creazione</th>
                <th>Data ultimo accesso</th>

                <th>attivo</th>
                <th>eliminato</th>
                <th>telefono</th>
                <th>volontario</th>
            </tr>
        <tbody>
            <?php foreach ($utenti as $utente) : ?>
                <tr>
                    <td class="text-center"><?= $utente->id_utente ?></td>
                    <td><?= $utente->username ?></td>
                    <td><?= $utente->email ?></td>
                    <td><?= $utente->data_creazione->format('d/m/Y') ?></td>
                    <td><?= $utente->ultimo_accesso->format('d/m/Y') ?></td>

                    <td class="text-center">
                        <?= $utente->attivo ? 'Sì' : 'No'; ?>
                    </td>
                    <td class="text-center">
                        <?= $utente->eliminato ? 'Sì' : 'No'; ?>
                    </td>
                    <td><?= $utente->telefono ?></td>
                    <td class="text-center">
                        <?= $utente->volontario ?>
                    </td>
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