<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Provincia;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica comune - Gestione Donatempo";
$link_attivo = 'comuni';
$id_comune = AiutoInput::leggiStringa('id', '', 'G');
$comune = new Comune();
$province = Provincia::caricaTutte();
if (!empty($id_comune)) {
    $comune->carica($id_comune);
}

$azione = AiutoInput::leggiStringa('azione');
switch ($azione) {
    case 'salva':
        $comune->denominazione = AiutoInput::leggiStringa('denominazione', '', 'P');
        $comune->provincia = AiutoInput::leggiStringa('provincia', '', 'P');
        $comune->latitudine = AiutoInput::leggiFloat('latitudine', null, 'P');
        $comune->longitudina = AiutoInput::leggiFloat('longitudine', null, 'P');
        if($comune->salva()) {
            Notifica::accoda('Comune salvato correttamente', Notifica::TIPO_SUCCESSO);
            header("location:comuni.php");
        }
        break;
}

ob_start();
?>
<h1>Modifica comune</h1>

<form action="" method="post">
    <div class="row">
        <div class="col">
            <label for="id_comune">Codice catastale</label>
            <input type="text" name="id_comune" id="id_comune" class="form-control" value="<?= $comune->id_comune; ?>" />
        </div>
        <div class="col">
            <label for="denominaione">Denominazione</label>
            <input type="text" name="denominazione" id="denominazione" class="form-control" value="<?= $comune->denominazione; ?>" />
        </div>
        <div class="col">
            <label for="provincia">Provincia</label>
            <select name="provincia" id="provincia" class="form-control">
                <?php AiutoHTML::options($province, 'sigla', 'denominazione', $comune->provincia); ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="latitudine">Latitudine</label>
            <input type="number" name="latitudine" id="latitudine" class="form-control" value="<?= floatval($comune->latitudine); ?>">
        </div>
        <div class="col">
            <label for="longitudine">Longitudine</label>
            <input type="number" name="longitudine" id="longitudine" class="form-control" value="<?= floatval($comune->longitudine); ?>">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-primary" name="azione" value="salva">Salva</button>
        </div>
    </div>

</form>

<?php
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>