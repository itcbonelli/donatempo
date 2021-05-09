<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Profilo;
use itcbonelli\donatempo\tabelle\Provincia;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica profilo - Gestione Donatempo";
$link_attivo = 'profili';
$province = Provincia::caricaTutte();
$comuni = Comune::getElencoComuni();
$id_profilo=AiutoInput::leggiIntero('id', -1, 'G');
$profilo=new Profilo();
if($id_profilo>0) {
    $profilo->carica($id_profilo);
}

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Modifica profilo</h1>

<form action="" method="post">
    <div class="row">
        <div class="col mw-320">
            <div class="form-group">
                <label for="cognome">Cognome</label>
                <input type="text" class="form-control" name="cognome" id="cognome" value="<?= htmlentities($profilo->cognome); ?>" />
            </div>
        </div>
        <div class="col mw-320">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" value="<?= htmlentities($profilo->nome); ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="indirizzo">Indirizzo</label>
            <input type="text" name="indirizzo" id="indirizzo" value="<?= htmlentities($profilo->indirizzo); ?>" class="form-control" />
        </div>
        <div class="col">
            <label for="cap">Cap</label>
            <input type="text" name="cap" id="cap" class="form-control" value="<?= htmlentities($profilo->cap); ?>" />
        </div>

        <div class="col">
            <label for="provincia">Provincia</label>
            <select name="provincia" id="provincia" class="form-control">
                <option value="" selected disabled>---</option>
                <?php AiutoHTML::options($province, 'sigla', 'denominazione'); ?>
            </select>
        </div>
        <div class="col">
            <label for="cod_comune">Comune</label>
            <select name="cod_comune" id="cod_comune" class="form-control">
                <option value="" selected disabled>---</option>
                <?php AiutoHTML::options($comuni, 'id_comune', 'denominazione'); ?>
            </select>
        </div>
    </div>



    <div class="form-group">
        <button type="submit" class="btn btn-primary">Conferma</button>
    </div>
</form>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>