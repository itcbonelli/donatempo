<?php

use itcbonelli\donatempo\AiutoDB;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Cruscotto - Gestione Donatempo";
$link_attivo = 'dashboard';

$adb = new AiutoDB($dbconn);
$numUtenti = $adb->eseguiScalare("SELECT COUNT(*) FROM utenti WHERE attivo=1");
$numVolontari = $adb->eseguiScalare("SELECT COUNT(*) FROM utenti WHERE attivo=1 AND volontario=1");

ob_start();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-bar-chart" aria-hidden="true"></i> Statistiche</h4>
                </div>
                <div class="card-body">

                    <table class="table table-striped table-sm">
                        <tbody>
                            <tr>
                                <td>Numero utenti</td>
                                <td><?php echo $numUtenti; ?></td>
                            </tr>
                            <tr>
                                <td>Numero di volontari</td>
                                <td><?php echo $numVolontari; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Richieste</strong></td>
                            </tr>
                            <tr>
                                <td>Totali</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>In lavorazione</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Soddisfatte</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>