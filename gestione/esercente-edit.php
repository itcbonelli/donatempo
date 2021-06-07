<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Esercente;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica esercente - Gestione Donatempo";
$link_attivo = 'esercenti';

$id_esercente = AiutoInput::leggiIntero('id', -1, 'G');

$esercente = new Esercente();

if ($id_esercente > 0) {
    $esercente->carica($id_esercente);
}

$azione = AiutoInput::leggiStringa('azione', '', 'P');
if ($azione == 'salva') {
    $esercente->nome = AiutoInput::leggiStringa('nome', '', 'P');
    $esercente->ragsoc = AiutoInput::leggiStringa('ragsoc', '', 'P');
    $esercente->piva = AiutoInput::leggiStringa('piva', '', 'P');
    $esercente->indirizzo = AiutoInput::leggiStringa('indirizzo', '', 'P');
    $esercente->cap = AiutoInput::leggiStringa('cap', '', 'P');
    $esercente->descrizione = AiutoInput::leggiStringa('descrizione', '', 'P');

    $esercente->salva();
}

ob_start();
?>

<h1>Modifica esercente</h1>

<p>
    <a href="esercenti.php">&larr; Torna all'elenco esercenti</a>
</p>

<form action="" method="post">
    <?php AiutoHTML::campoInput('nome', 'Nome', $esercente->nome, ['required' => true]); ?>
    <?php AiutoHTML::campoInput('ragsoc', 'Ragione sociale', $esercente->ragsoc); ?>
    <?php AiutoHTML::campoInput('piva', 'Partita IVA', $esercente->piva); ?>
    <?php AiutoHTML::campoInput('indirizzo', 'Indirizzo', $esercente->indirizzo); ?>
    <?php AiutoHTML::campoInput('cap', 'Cap', $esercente->cap); ?>
    <div class="form-group">
        <label for="cod_comune">Comune</label>
        <select name="cod_comune" id="cod_comune" class="chzn-select">
            <?php AiutoHTML::optionsComuni($esercente->cod_comune); ?>
        </select>
    </div>
    <?php AiutoHTML::areaTesto('descrizione', 'Descrizione', $esercente->descrizione); ?>
    <?php AiutoHTML::checkbox('attivo', 'Attivo', $esercente->attivo); ?>
    <?php AiutoHtml::bsButton('azione', 'Salva', 'salva'); ?>
</form>
<?php

$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>