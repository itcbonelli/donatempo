<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Modifica associazione - Gestione Donatempo";
$link_attivo = 'associazioni';
ob_start();

$id_associazione = AiutoInput::leggiIntero('id', -1, 'G');
$azione = AiutoInput::leggiStringa("azione", "", "P");

$associazione = new Associazione();
if ($id_associazione > 0) {
    $associazione->carica($id_associazione);
}

switch ($azione) {
    case 'salva':
        $associazione->ragsoc = AiutoInput::leggiStringa('ragsoc');
        $associazione->codfis = AiutoInput::leggiStringa('codfis');
        $associazione->descrizione = AiutoInput::leggiStringa('descrizione');
        if ($associazione->convalida()) {
            $associazione->salva();
        }
        break;
    case 'elimina':
        $associazione->elimina();
        break;
}

?>
<h1>Modifica associazione</h1>

<?php Notifica::MostraNotifiche(); ?>

<form action="" method="post">


    <div class="form-group">
        <label for="ragsoc">Ragione sociale</label>
        <input type="text" name="ragsoc" id="ragsoc" class="form-control" value="<?= htmlentities($associazione->ragsoc); ?>" />
    </div>
    <div class="form-group">
        <label for="codfis">Codice fiscale</label>
        <input type="text" name="codfis" id="codfis" min="1" maxlength="11" class="form-control" value="<?= htmlentities($associazione->codfis); ?>" />
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
        <input type="text" name="descrizione" id="descrizione" class="form-control" value="<?= htmlentities($associazione->descrizione); ?>" />
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="azione" value="salva">Salva</button>
        <button type="submit" class="btn btn-outline-danger" name="azione" value="elimina">Elimina</button>
    </div>

</form>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>