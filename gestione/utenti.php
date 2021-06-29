<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\filtri\FiltroUtenti;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Gestione utenti - Gestione Donatempo";
$link_attivo = 'utenti';

$filtro = new FiltroUtenti();
$filtro->orderby=AiutoInput::leggiStringa('orderby', 'data_creazione', 'G');
$utenti = Utente::ElencoUtenti($filtro);

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione utenti</h1>

<?php Notifica::MostraNotifiche(); ?>

<p>
    <a class="btn btn-success" href="utente-edit.php" role="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Crea utente</a>
</p>

<div class="table-responsive">
    <table id="tabella_utenti" class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th><abbr title="Identificativo utente">Id</abbr></th>
                <th><a href="?orderby=username">Nome utente</a></th>
                <th>Email</th>
                <th><a href="?orderby=data_creazione">Data creazione</a></th>
                <th><a href="?orderby=ultimo_accesso">Data ultimo accesso</a></th>

                
                <th>telefono</th>
                <th><a href="?orderby=attivo">Attivo</a></th>
                <th><a href="?orderby=volontario">volontario</a></th>
            </tr>
        <tbody>
            <?php foreach ($utenti as $utente) : ?>
                <tr>
                    <td class="text-center"><?= $utente->id_utente ?></td>
                    <td><a href="utente-edit.php?id=<?= $utente->id_utente ?>"><?= $utente->username ?></a></td>
                    <td><?= $utente->email ?></td>
                    <td><?= $utente->data_creazione->format('d/m/Y') ?></td>
                    <td><?= $utente->ultimo_accesso->format('d/m/Y') ?></td>

                    <td><?= $utente->telefono ?></td>
                    <td class="text-center">
                        <?php AiutoHTML::yesNo($utente->attivo); ?>
                    </td>
                    <td class="text-center">
                        <?php AiutoHTML::yesNo($utente->volontario); ?>
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