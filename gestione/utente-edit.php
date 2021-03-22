<?php
$titolo_pagina = "Gestione utenti";
$link_attivo = 'utenti';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>

<form action="" method="post">
    <h1>Modifica utente</h1>

    <p>
        <button type="button" class="btn btn-primary" name="azione" value="conferma">Conferma</button>
        <button type="button" class="btn btn-outline-danger" name="azione" value="annulla">Annulla</button>
    </p>

    <div class="form-group">
      <label for="username">Nome utente</label>
      <input type="text" class="form-control" name="username" id="username" required />
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" required />
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" class="form-control" name="email" id="email" required />
    </div>


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