<?php

use itcbonelli\donatempo\tabelle\Associazione;

require __DIR__ . '/../include/main.php';

$titolo_pagina = "Modifica associazione";
$link_attivo = 'associazioni';
ob_start();

$associazione = new Associazione();

?>
<h1>Modifica associazione</h1>

<form action="" method="post">


    <div class="form-group">
        <label for="ragsoc">Ragione sociale</label>
        <input type="text" name="ragsoc" id="ragsoc" class="form-control" />
    </div>
    <div class="form-group">
        <label for="codfis">Codice fiscale</label>
        <input type="text" name="codfis" id="codfis" min="1" maxlength="11" class="form-control" />
    </div>

    <p>
        <img src="" alt="Logo associazione" />
    </p>
    <div class="form-group">
        <label for="rimuovi_logo" class="checkbox" title="Se questa casella viene spuntata, verrà rimosso il logo attualmente caricato anche se non è stato inserito un nuovo logo.">
            <input type="checkbox" name="rimuovi_logo" id="rimuovi_logo" /> Rimuovi logo
        </label>
    </div>

    <div class="form-group">
        <label for="logo">Logo</label>
        <input type="file" name="logo" id="logo" class="form-control" />
    </div>

    <div class="form-group">
        <label for="descrizione">Descrizione</label>
        <input type="text" name="descrizione" id="descrizione" class="form-control" />
    </div>

</form>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>