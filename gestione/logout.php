<?php

use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Logout";
$link_attivo = 'logout';

Utente::Logout();
header('Location:login.php');

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Bye bye</h1>
<p class="lead">Sarai reindirizzato a breve alla pagina di accesso</p>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>