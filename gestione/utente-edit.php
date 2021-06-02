<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Profilo;
use itcbonelli\donatempo\tabelle\Provincia;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Gestione utenti - Gestione Donatempo";
$link_attivo = 'utenti';

$id_utente = AiutoInput::leggiStringa('id', -1, 'G');
$utente = new Utente();
$profilo = new Profilo();
if ($id_utente > 0) {
  $utente->carica($id_utente);
  $profilo = $utente->getProfilo();
}

$azione = AiutoInput::leggiStringa('azione', '', 'P');
if ($azione == 'salva') {
} elseif ($azione == 'annulla') {
  header('location:badge.php');
}

ob_start();
?>

<form action="" method="post">
  <h1>Modifica utente</h1>

  <p><a href="utenti.php">&larr; Torna all'elenco degli utenti</a></p>

  <fieldset>
    <legend><i class="fa fa-user" aria-hidden="true"></i> Account</legend>

    <div class="form-group">
      <?php AiutoHTML::campoInput('username', 'Nome utente', $utente->username, ['disabled' => $utente->id_utente > 0]); ?>
    </div>

    <div class="row">
      <div class="col">
        <?php AiutoHTML::campoInput('password', 'Password', '', ['type' => 'password']); ?>
      </div>
      <div class="col">
        <?php AiutoHTML::campoInput('password2', 'Conferma password', '', ['type' => 'password']); ?>
      </div>
    </div>


    <div class="form-group">
      <?php AiutoHTML::campoInput('email', 'E-mail', $utente->email); ?>
    </div>

    <div class="form-group">
      <label for="attivo" class="checkbox"><input type="checkbox" name="attivo" id="attivo" <?= $utente->attivo ? 'checked' : '' ?>> Attivo</label>
    </div>

    <?php if ($utente->id_utente > 0) : ?>
      <p>
        <strong>Data registrazione: </strong> <?= $utente->data_creazione->format('d/m/Y h:i:s'); ?>
      </p>
    <?php endif; ?>

  </fieldset>

  <hr />

  <fieldset>
    <legend><i class="fa fa-pencil-square" aria-hidden="true"></i> Profilo</legend>

    <div class="row">
      <div class="col"><?php AiutoHTML::campoInput('nome', 'Nome', $profilo->cognome); ?></div>
      <div class="col"><?php AiutoHTML::campoInput('cognome', 'Cognome', $profilo->cognome); ?></div>
    </div>
    <div class="row">
      <div class="col"><?php AiutoHTML::campoInput('telefono1', 'Telefono principale', $profilo->telefono1); ?></div>
      <div class="col"><?php AiutoHTML::campoInput('telefono2', 'Telefono secondario', $profilo->telefono2); ?></div>
    </div>
    <div class="row">
      <div class="col"><?php AiutoHTML::campoInput('cod_fis', 'Codice fiscale', $profilo->cod_fis); ?></div>
    </div>
    <div class="row">
      <div class="col"><?php AiutoHTML::campoInput('indirizzo', 'Indirizzo', $profilo->indirizzo); ?></div>
    </div>
    <div class="row">
      <div class="col">
        <?php
        $province = Provincia::caricaTutte();
        ?>
        <label for="provincia">Provincia</label>
        <select name="provincia" id="provincia" class="form-control" onchange="setProvincia(this, 'cod_comune');">
          <option value="---"></option>
          <?php AiutoHTML::options($province, 'sigla', 'denominazione'); ?>
        </select>
      </div>
      <div class="col">
        <label for="cod_comune">Città</label>
        <select name="cod_comune" id="cod_comune" class="form-control">
          <option value="" selected disabled>---</option>
          <?php
          AiutoHTML::optionsComuni(strval($profilo->id_comune));
          ?>
        </select>
      </div>
      <div class="col">
        <?php AiutoHTML::campoInput('cap', 'Cap', $profilo->cap); ?>
      </div>

    </div>
  </fieldset>

  <p>
    <button type="submit" class="btn btn-primary" name="azione" value="salva">Conferma</button>
  </p>
</form>

<?php if ($id_utente > 0) : ?>
  <form action="" class="border my-4 p-3">
    <fieldset>
      <legend class="text-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Elimina utente</legend>
      <div class="form-group">
        <button type="submit" class="btn btn-outline-danger" name="azione" value="elimina" onclick="return alert('Confermare eliminazione utente?');">Elimina</button>
      </div>
    </fieldset>
  </form>
<?php endif; ?>

<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>