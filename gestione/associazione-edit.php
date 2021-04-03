<?php
$titolo_pagina = "Modifica associazione";
$link_attivo = 'associazioni';
ob_start();
?>
<h1>Modifica associazione</h1>

<form action="" method="post">


    <div class="form-group">
        <label for="ragsoc">Ragione sociale</label>
        <input type="text" name="ragsoc" id="ragsoc">
    </div>
    <div class="form-group">
        <label for="codfis">Codice fiscale</label>
        <input type="text" name="codfis" id="codfis" min="1" maxlength="11">
    </div>

    <div class="form-group">
        <label for="logo">Logo</label>
        <input type="file" name="logo" id="logo" />
    </div>

    <div class="form-group">
        <label for="descrizione">Descrizione</label>
        <input type="text" name="descrizione" id="descrizione">
    </div>

    <div class="form-group">
        <label for="ins_da">Inserito da</label>
        <input type="text" name="ins_da" id="ins_da">
    </div>

    <div class="form-group">
        <label for="date">Data inserimento</label>
        <input type="date" name="data_inserimento" id="data_inserimento">
    </div>

</form>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>