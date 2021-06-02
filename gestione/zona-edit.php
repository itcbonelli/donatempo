<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Zona;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica zona - Gestione Donatempo";
$link_attivo = 'zone';

$id_zona = AiutoInput::leggiIntero('id_zona', -1, 'G');

$zona = new Zona();
if ($id_zona > 0) {
    $zona->carica($id_zona);
}

ob_start();
?>
<h1>Modifica zona geografica</h1>

<form action="" method="post">
    <?php AiutoHTML::campoInput('id_zona', 'Identificativo', $zona->id_zona, ['readonly' => true]); ?>
    <?php AiutoHTML::campoInput('denominazione', 'Denominazione', $zona->denominazione, ['maxlength' => 50]); ?>
    <?php AiutoHTML::bsButton('azione', 'Salva', 'salva'); ?>
</form>

<hr />

<form action="">
    <fieldset>
        <legend>Comuni compresi nella zona</legend>


    </fieldset>
</form>

<hr />

<form action="">
    <fieldset>
        <legend>Aggiungi comune</legend>
        <div class="form-group">
            <label for="cod_comune">Comune</label>
            <select name="cod_comune" id="cod_comune" class="form-control">
                <?php 
                $comuni=Comune::getElencoComuni();
                AiutoHTML::options($comuni, 'id_comune', 'denominazione');
                unset($comuni);
                ?>
            </select>
            <?php AiutoHTML::bsButton('azione', 'Conferma', 'associa_comune'); ?>
        </div>
    </fieldset>
</form>
<?php
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>