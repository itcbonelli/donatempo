<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Badge;

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Modifica Badge - Gestione Donatempo";
$link_attivo = 'badge';

$id_badge = AiutoInput::leggiIntero('id', -1, 'G');

$badge = new Badge();

if ($id_badge > 0) {
    $badge->carica($id_badge);
}

$azione = AiutoInput::leggiStringa('azione', '', 'P');
if ($azione == 'salva') {
    $badge->nome = AiutoInput::leggiStringa('nome', '', 'P');
    $badge->descrizione = AiutoInput::leggiStringa('descrizione', '', 'P');
    $badge->salva();
    Notifica::accoda('Badge salvato correttamente', Notifica::TIPO_SUCCESSO);
    header('location:badge.php');
} elseif ($azione == 'elimina') {
    $badge->elimina();
    Notifica::accoda('Badge eliminato correttamente');
    header('location:badge.php');
}

ob_start();
?>

<form action="" method="post" autocomplete="off">
    <h1>Modifica badge</h1>

    <?php AiutoHTML::campoInput('nome', 'Nome', $badge->nome, ['required' => true]); ?>
    <?php AiutoHTML::campoInput('descrizione', 'Descrizione', $badge->descrizione); ?>

    <div class="form-group">
        <label for="immagine">Immagine</label>
        <input type="file" name="immagine" id="immagine" class="form-control" />
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="azione" value="salva">Salva</button>
        <button type="submit" class="btn btn-outline-danger" name="azione" value="elimina">Elimina</button>
    </div>
</form>


<?php
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>