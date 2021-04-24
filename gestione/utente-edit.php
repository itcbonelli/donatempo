<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Gestione utenti - Gestione Donatempo";
$link_attivo = 'utenti';

$id_utente = AiutoInput::leggiStringa('id', -1, 'G');
$utente = new Utente();
if ($id_utente > 0) {
  $utente->carica($id_utente);
}


ob_start();
?>

<form action="" method="post">
  <h1>Modifica utente</h1>

  <p>
    <button type="button" class="btn btn-primary" name="azione" value="conferma">Conferma</button>
    <button type="button" class="btn btn-outline-danger" name="azione" value="annulla">Annulla</button>
  </p>

  <fieldset>

    <div class="form-group">
      <label for="username">Nome utente</label>
      <input type="text" class="form-control" name="username" id="username" value="<?= $utente->username; ?>" required />
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" required />
    </div>

    <div class="form-group">
      <label for="password2">Conferma password</label>
      <input type="password" class="form-control" name="password2" id="password2" required />
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" class="form-control" name="email" id="email" value="<?= $utente->email; ?>" required />
    </div>

    <div class="form-group">
      <label for="attivo" class="checkbox"><input type="checkbox" name="attivo" id="attivo" <?= $utente->attivo ? 'checked' : '' ?>> Attivo</label>
    </div>

    <?php if($utente->id_utente>0) : ?>
      <p>
        <strong>Data registrazione: </strong> <?= $utente->data_creazione->format('d/m/Y h:i:s'); ?>
      </p>
    <?php endif; ?>

  </fieldset>

  <p>
    <button type="button" class="btn btn-primary" name="azione" value="conferma">Conferma</button>
    <button type="button" class="btn btn-outline-danger" name="azione" value="annulla">Annulla</button>
  </p>
</form>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>