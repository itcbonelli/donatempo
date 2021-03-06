<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica servizio - Gestione Donatempo";
$link_attivo = 'servizio-edit';

$id_servizio = AiutoInput::leggiIntero('id', -1, 'G');
$azione = AiutoInput::leggiStringa('azione', '', 'P');
$servizio = new Servizio();
if ($id_servizio > 0) {
    $servizio->carica($id_servizio);
}

if($azione=='salva') {
    $servizio->nome = AiutoInput::leggiStringa('nome', '', 'P');
    $servizio->tipo = AiutoInput::leggiIntero('tipologia', null, 'P');
    $servizio->durata = AiutoInput::leggiIntero('durata', 0, 'P');
    $servizio->attivo = AiutoInput::leggiBool('attivo', true, 'P');
    $servizio->descrizione = AiutoInput::leggiStringa('descrizione', '', 'P');
    $servizio->salva();
} elseif($azione=='elimina') {
    $servizio->elimina();
    Notifica::accoda("Servizio eliminato correttamente");
    Notifica::salva();
    header('location: servizi.php');
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
        <button type="submit" class="btn btn-primary" name="azione" value="salva">Salva</button>
        <a href="servizi.php" class="btn btn-outline-danger">Annulla</a>
    </div>

</form>

<?php if($id_servizio>0) : ?>
<form action="" method="post" class="border border-danger my-4 p-3">
    <fieldset>
        <legend class="text-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Cancellazione</legend>
        <div class="form-group">
            <button type="submit" class="btn btn-danger" name="azione" value="elimina" onclick="return confirm('Confermare l\'operazione?');">Elimina questo servizio</button>
        </div>
    </fieldset>
</form>
<?php endif; ?>


<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>