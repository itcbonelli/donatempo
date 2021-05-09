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

ob_start();
?>

<h1>Modifica esercente</h1>

<p>
    <a href="esercenti.php">&larr; Torna all'elenco esercenti</a>
</p>

<form action="" method="post"></form>

<?php AiutoHTML::campoInput('nome', 'Partita IVA', $esercente->nome, ['required' => true]); ?>
<?php AiutoHTML::campoInput('ragsoc', 'Ragione sociale', $esercente->ragsoc); ?>
<?php AiutoHTML::campoInput('piva', 'Partita IVA', $esercente->piva); ?>
<?php AiutoHTML::campoInput('indirizzo', 'Indirizzo', $esercente->indirizzo); ?>
<?php AiutoHTML::campoInput('cap', 'Cap', $esercente->cap); ?>
<?php AiutoHTML::areaTesto('descrizione', 'Descrizione', $esercente->descrizione); ?>
<?php AiutoHTML::checkbox('attivo', 'Attivo', $esercente->attivo); ?>

<?php

$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>