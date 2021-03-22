<?php
$titolo_pagina = "Gestione utenti";
$link_attivo = 'utenti';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione utenti</h1>

<p>
    <a class="btn btn-primary" href="utente-add.php" role="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Crea utente</a>
</p>

<table class="table table-sm table-bordered table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th><input type="checkbox" id="chkSelezionaTutti" title="Seleziona/Deseleziona tutti"></th>
            <th>Attivo</th>
            <th>Nome utente</th>
            <th>Cognome</th>
            <th>Nome</th>
            <th>E-mail</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"><input type="checkbox" name="id_utente[]" /></td>
            <td class="text-center"><input type="checkbox" name="attivo[]" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>


<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>