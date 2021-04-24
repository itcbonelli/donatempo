<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica servizio - Gestione Donatempo";
$link_attivo = 'servizio-edit';

$id_servizio = AiutoInput::leggiIntero('id', -1, 'G');
$servizio = new Servizio();
if ($id_servizio > 0) {
    $servizio->carica($id_servizio);
}
ob_start();
?>
<h1>Modifica servizio</h1>

<form action="" method="post">
    <input type="hidden" class="form-control" name="id" id="id" value="<?= intval($servizio->id_servizio); ?>" />

    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?= htmlentities($servizio->nome); ?>" >
    </div>

    <div class="form-group">
        <label for="id_tipo">Tipologia</label>
        <select class="form-control" name="id_tipo" id="id_tipo">
            <option value="" selected disabled>---</option>
        </select>
    </div>

    <div class="form-group">
        <label for="durata">Durata</label>
        <input type="number" class="form-control" name="durata" id="durata" aria-describedby="durataHelp" value="<?= intval($servizio->durata); ?>">
        <small id="durataHelp" class="form-text text-muted">Durata del servizio in minuti</small>
    </div>

    <div class="form-check">
      <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name="attivo" id="attivo" value="1" <?= $servizio->attivo ? 'checked' : '' ?> />
        Attivo
      </label>
    </div>

    <div class="form-group">
      <label for="descrizione">Descrizione</label>
      <textarea class="form-control" name="descrizione" id="descrizione"><?= htmlentities($servizio->descrizione); ?></textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Salva</button>
        <a href="servizi.php" class="btn btn-outline-danger">Annulla</a>
    </div>

</form>


<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>