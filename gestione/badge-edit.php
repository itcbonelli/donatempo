<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\AiutoUpload;
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

    if (isset($_FILES['immagine'])) {
        $au = new AiutoUpload();
        $au->destinazione .= "/badge/";
        $au->generaNomeCasuale = true;
        $badge->url_immagine = $au->carica('immagine');
    }

    $badge->salva();
    Notifica::accoda('Badge salvato correttamente', Notifica::TIPO_SUCCESSO);
    Notifica::salva();
    header('location:badge.php');
} elseif ($azione == 'elimina') {
    $badge->elimina();
    Notifica::accoda('Badge eliminato correttamente');
    Notifica::salva();
    header('location:badge.php');
}

ob_start();
?>

<form action="" method="post" autocomplete="off" enctype="multipart/form-data">
    <h1>Modifica badge</h1>

    <p><a href="badge.php">&larr; Torna all'elenco dei badge</a></p>

    <?php AiutoHTML::campoInput('nome', 'Nome', $badge->nome, ['required' => true]); ?>
    <?php AiutoHTML::campoInput('descrizione', 'Descrizione', $badge->descrizione); ?>

    <?php if (strlen($badge->url_immagine) > 0) : ?>
        <img src="../uploads/badge/<?= $badge->url_immagine ?>" alt="Immagine badge" /><br />
        <label for="rimuovi_immagine" class="checkbox"><input type="checkbox" name="rimuovi_immagine" id="rimuovi_immagine" value="1" /></label>
    <?php endif; ?>

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