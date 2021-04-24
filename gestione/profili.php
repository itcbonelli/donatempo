<?php

use itcbonelli\donatempo\tabelle\Profilo;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Profili - Gestione Donatempo";
$link_attivo = 'profili';

$profili = Profilo::elencoProfili();

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Anagrafica profili</h1>

<form action="" class="mb-4">
    <fieldset>
        <legend>Filtri</legend>

        <div class="row">
            <div class="col">
                <label for="cerca" >Cerca</label>
                <input type="search" name="cerca" id="cerca" class="form-control form-control-sm" placeholder="Cerca">
            </div>
            <div class="col">
                <label for="tipo" >Tipologia di utente</label>
                <select name="tipologia" id="tipologia" class="form-control form-control-sm">
                    <option value="utente">Utente</option>
                    <option value="volontario">Volontario</option>
                    <option value="associazione">Associazione</option>
                    <option value="amministratore">Amministratore</option>
                </select>
            </div>
        </div>

    </fieldset>

</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm table-hover">
        <thead>
            <tr>
                <th>Utente</th>
                <th>Ruolo</th>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Indirizzo</th>
                <th>Cap</th>
                <th>Città</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profili as $profilo) :
                $utente = $profilo->getUtente();
            ?>
                <tr>
                    <td><?= $profilo->id_utente; ?></td>
                    <td><?php if ($utente->volontario) {
                            echo 'Volontario';
                        } ?></td>
                    <td><?= $profilo->cognome; ?></td>
                    <td><?= $profilo->nome; ?></td>
                    <td><?= $profilo->indirizzo; ?></td>
                    <td><?= $profilo->cap; ?></td>
                    <td><?= $profilo->id_comune; ?></td>
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